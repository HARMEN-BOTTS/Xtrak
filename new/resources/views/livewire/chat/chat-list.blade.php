<div>
    <div class="chatlist_header">
        <div class="title">{{ $auth_first_name }} {{ $auth_last_name }} -- {{ $auth_trigram }}</div>
        <div class="img_container">
            @if(auth()->user()->profile_photo_path)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="">
            @else
                <img src="assets/images/logo.png" alt="">
            @endif
        </div>
    </div>

    <div class="chatlist_body">
        <div class="add_chat_container">
            <button class="add_chat_button" wire:click="openModal">+</button>
        </div>
        @if(count($conversations) > 0)
            @foreach ($conversations as $conversation)
                @php
                    $lastMessage = $conversation->messages->last();
                    $receiverId = $this->getChatUserInstance($conversation, 'id');
                    $receiverUser = $this->receiverInstance; 
                    $hasUnreadMessages = $this->hasUnreadMessages($conversation);
                @endphp
                <div class="chatlist_item {{ $hasUnreadMessages ? 'unread-message' : '' }}" wire:key="{{$conversation->id}}" wire:click="chatUserSelected({{ $conversation->id }}, {{ $receiverId }})">
                    <div class="chatlist_img_container">
                        @if($receiverUser)
                            @if($receiverUser->profile_photo_path)
                                <img src="{{ asset('storage/' . $receiverUser->profile_photo_path) }}" alt="">
                            @else
                                <img src="assets/images/logo.png" alt="">
                            @endif
                        @endif
                    </div>
                    <div class="chatlist_info">
                        <div class="top_row">
                            <div class="list_username">
                                @if($receiverUser)
                                    {{ $receiverUser->first_name }} {{ $receiverUser->last_name }}
                                    @if($receiverUser->is_connect)
                                        <span class="badge bg-success" style="width: 10px; height: 10px; border-radius: 50%; padding: 0;">&nbsp;</span>
                                    @else
                                        <span class="badge bg-danger" style="width: 10px; height: 10px; border-radius: 50%; padding: 0;">&nbsp;</span>
                                    @endif
                                @endif
                            </div>

                            <span class="date">{{ $lastMessage ? $lastMessage->created_at->shortAbsoluteDiffForHumans() : '' }}</span>
                        </div>
                        <div class="bottom_row">
                            <div class="message_body text-truncate">
                                @if ($lastMessage)
                                    @if ($lastMessage->attachment)
                                        @php
                                            $senderName = $lastMessage->user->first_name;
                                        @endphp
                                        {{ $lastMessage->sender_id == auth()->id() ? 'Vous avez envoyé une pièce-jointe' : $senderName . ' a envoyé une pièce-jointe' }}
                                    @else
                                        {{ $lastMessage->body }}
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            Vous n'avez pas de conversation
        @endif
    </div>

    <!-- Modal -->
    <div x-data="{ open: @entangle('isModalOpen') }">
        <div x-show="open" class="modale">
            <div class="modale-content">
                <span class="close" @click="open = false" wire:click="closeModal">&times;</span>
                <h2>Nouvelle discussion - Nouveau contact</h2>
                @if ($users)
                    <ul>
                        @foreach ($users as $user)
                            <li wire:click="startConversation({{ $user->id }})">
                                {{ $user->first_name }} {{ $user->last_name }} -- {{ $user->trigramme }}
                                @if($user->is_connect)
                                    <span class="badge bg-success" style="width: 10px; height: 10px; border-radius: 50%; padding: 0;">&nbsp;</span>
                                @else
                                    <span class="badge bg-danger" style="width: 10px; height: 10px; border-radius: 50%; padding: 0;">&nbsp;</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Pas d'utilisateurs disponibles</p>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.onclick = function(event) {
                const modal = document.querySelector('.modale');
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
</div>
