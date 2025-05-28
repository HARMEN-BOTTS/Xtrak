<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;
use App\Models\User;

class ChatList extends Component
{
    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;
    public $isModalOpen = false;
    public $users = [];
    public $auth_first_name;
    public $auth_last_name;
    public $auth_trigram;
    
    protected $listeners = ['chatUserSelected', 'refresh', 'messageSent','resetComponent'];

    public function resetComponent()
    {
        $this->selectedConversation = null;
        $this->receiverInstance = null;
        // dd('reset');
    }
    public function chatUserSelected($conversationId, $receiverId)
    {
        $conversation = Conversation::find($conversationId);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = User::find($receiverId);
        $this->dispatch('loadConversation', $this->selectedConversation, $this->receiverInstance->id);
        $this->dispatch('updateSendMessage', $this->selectedConversation->id, $this->receiverInstance);
    }

    public function getChatUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = auth()->id();
        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $conversation->receiver_id);
        } else {
            $this->receiverInstance = User::firstWhere('id', $conversation->sender_id);
        }
    
        if (isset($request) && $this->receiverInstance) {
            return $this->receiverInstance->$request;
        }
    
        return null;
    }
    
    // public function openModal()
    // {
    //     $this->isModalOpen = true;
    //     $this->users = User::where('id', '!=', $this->auth_id)->get();
    // }
    public function openModal()
{
    $this->isModalOpen = true;

    if (auth()->user()->hasRole('Consultant')) {

        $this->users = User::where('id', '!=', $this->auth_id)
                           ->whereHas('roles', function($query) {
                               $query->where('name', 'Manager');
                           })
                           ->get();
    } else {

        $this->users = User::where('id', '!=', $this->auth_id)->get();
    }
}


    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function startConversation($userId)
    {
        $existingConversation = Conversation::where(function($query) use ($userId) {
            $query->where('sender_id', $this->auth_id)
                  ->where('receiver_id', $userId);
        })->orWhere(function($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $this->auth_id);
        })->first();

        if ($existingConversation) {
            $this->chatUserSelected($existingConversation->id, $userId);
        } else {
            $conversation = Conversation::create([
                'sender_id' => $this->auth_id,
                'receiver_id' => $userId,
                'last_time_message' => now(),
            ]);

            $this->chatUserSelected($conversation->id, $userId);
        }

        $this->closeModal();
    }

    public function messageSent()
    {
        $this->refresh();
    }

    public function refresh()
    {
        info('Refresh called');
        $this->mount();
    }

    public function mount()
    {
        info('ChatList mount called');
        $this->auth_id = auth()->id();
        $user = auth()->user();
        $this->auth_first_name = $user->first_name;
        $this->auth_last_name = $user->last_name;
        $this->auth_trigram = $user->trigramme;
        $this->conversations = Conversation::where(function($query) {
            $query->where('sender_id', $this->auth_id)
                ->orWhere('receiver_id', $this->auth_id);
        })->whereHas('messages') 
        ->orderBy('last_time_message', 'DESC')
        ->get();
    
        info('Conversations loaded', ['conversations' => $this->conversations->toArray()]);
    }
    

    public function hasUnreadMessages($conversation)
    {
        return $conversation->messages->where('receiver_id', $this->auth_id)->where('read', false)->count() > 0;
    }
    public function render()
    {
        info('ChatList render called');
        return view('livewire.chat.chat-list')
            ->extends('layouts.app');
    }

}
