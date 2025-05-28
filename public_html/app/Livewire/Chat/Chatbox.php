<?php

namespace App\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Carbon\Carbon; 

class Chatbox extends Component
{
    public $selectedConversation;
    public $receiver;
    public $messages_count;
    public $messages;
    public $receiverInstance; 
    public $height;
    public $paginateVar = 1000;

    // protected $listeners = ['loadConversation', 'pushMessage', 'loadMore', 'updateHeight'];

    public function getListeners()
    {
        $auth_id = auth()->user()->id;
        return [
            "echo-private:chat.{$auth_id},MessageSent" => 'broadcastedMessageReceived',
            'loadConversation', 'pushMessage', 'loadMore', 'updateHeight'
        ];
    }

    public function broadcastedMessageReceived($event)
    {
        info('broadcastedMessageReceived called', ['event' => $event]);

        $this->dispatch('refresh');

        $broadcastedMessage = Message::find($event['message']);
        
        if ($this->selectedConversation) {
            if ((int) $this->selectedConversation->id === (int)$event['conversation_id']) {
                $broadcastedMessage->read = 1;
                $broadcastedMessage->save();
                $this->pushMessage($broadcastedMessage->id);
            }
        }
    }

    
    public function messageSent()
    {
        info('Message sent');
        $this->dispatch('refresh');
    }
    
    public function refresh()
    {
        info('Refresh called');
        $this->mount();
    }    

    public function pushMessage($messageId)
    {   
        $newMessage = Message::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatch('rowChatToBottom');
    }
    public function formatDate($date)
    {
        $carbonDate = Carbon::parse($date);
        
        if ($carbonDate->isToday()) {
            return 'Aujourd\'hui';
        } elseif ($carbonDate->isYesterday()) {
            return 'Hier';
        } elseif ($carbonDate->isCurrentWeek()) {
            return $carbonDate->translatedFormat('l'); 
        } else {
            return $carbonDate->format('d/m/y');
        }
    }
    public function isCurrentWeek($date)
    {
        $carbonDate = Carbon::parse($date);
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $carbonDate->between($startOfWeek, $endOfWeek);
    }

    public function loadMore()
    {
        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip(max(0, $this->messages_count - $this->paginateVar))
            ->take($this->paginateVar)
            ->get();

        $this->paginateVar += 10;

        $height = $this->height;
        $this->dispatch('updatedHeight', $height);
    }

    public function updateHeight($height)
    {
        $this->height = $height;
    }

    public function loadConversation(Conversation $conversation, $receiverId)
    {
        $this->selectedConversation = $conversation;
        $this->receiverInstance = User::find($receiverId);

        $this->messages_count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($this->messages_count - $this->paginateVar)
            ->take($this->paginateVar)
            ->get();

        $this->dispatch('chatSelected');
    }

    public function render()
    {
        return view('livewire.chat.chatbox', [
            'messages' => $this->messages,
            'receiverInstance' => $this->receiverInstance
        ]);
    }
}
