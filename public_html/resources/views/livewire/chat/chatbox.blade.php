<div>
    <div>
        @if ($selectedConversation)
            <div class="chatbox_header">
                <div class="return hide-on-large-screens" id="return-btn">
                    <i class="bi bi-arrow-left"></i>
                </div>
                <div class="img_container">
                    @if($receiverInstance->profile_photo_path)
                        <img src="{{ asset('storage/' . $receiverInstance->profile_photo_path) }}" alt="">
                    @else
                        <img src="assets/images/logo.png" alt="">
                    @endif
                </div>
                <div class="name">
                    {{$receiverInstance->first_name}}  {{$receiverInstance->last_name}}
                </div>
                <div class="info">
                    <div class="info_item" id="attachmentsIcon">
                        <i class="bi bi-image"></i>
                    </div>
                </div>
            </div>

            <div class="chatbox_body" id="chatbox_body">
                @php
                    $currentDate = null;
                @endphp

                @foreach ($messages as $message)
                    @php
                        $messageDate = $message->created_at->format('Y-m-d');
                    @endphp

                    @if ($currentDate !== $messageDate)
                        @php
                            $currentDate = $messageDate;
                        @endphp
                        <div class="date-separator" style="text-align: center;margin: 10px 0">
                            <span style="display: inline-block;padding: 5px 10px;background-color: #f1f1f1;border-radius: 5px;color: #555;font-weight: bold">
                          {{ $this->formatDate($message->created_at) }}</span>
                        </div>
                    @endif

                    <div wire:key='{{$message->id}}' class="msg_body {{auth()->id() == $message->sender_id ? 'msg_body_me' : 'msg_body_receiver'}}" style="width:80%;max-width:80%;max-width:max-content;">
                        {!! nl2br(e($message->body)) !!}
                        @if ($message->attachment)
                            <div class="msg_attachment">
                                @if ($message->isImageAttachment())
                                    <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $message->attachment) }}" alt="Attachment" style="max-width: 100%; height: auto; cursor: pointer;" onclick="openImageModal('{{ asset('storage/' . $message->attachment) }}')">
                                    </a>
                                @else
                                    <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" download>
                                        <i class="attachment-link bi bi-paperclip"></i>
                                        <span class="attachment-link">{{ basename($message->attachment) }}</span>
                                    </a>
                                @endif
                            </div>
                        @endif
                        <div class="msg_body_footer">
                            <div class="date" style="color:#555;font-size:11px">
                                {{$this->formatDate($message->created_at)}} {{$message->created_at->format('H:i')}}
                            </div>
                            <div class="read">
                                <i class="bi bi-check"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="attachmentsModal" class="modal-attachments">
                <div class="modal-attachments-content">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h2 style="margin: 0;">Les pièces jointes</h2>
                        <span class="close" onclick="closeAttachmentsModal()">&times;</span>
                    </div>
                    
                    <ul id="attachmentsList">
                        @php
                        $hasAttachment = false;
                        @endphp

                        @foreach ($messages as $message)
                            @if ($message->attachment)
                                @php
                                $hasAttachment = true;
                                @endphp

                                <li> 
                                    @if ($message->isImageAttachment())
                                        <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $message->attachment) }}" alt="Attachment" class="attachment-icon">
                                        </a>
                                    @else
                                        <a href="{{ asset('storage/' . $message->attachment) }}" target="_blank" download>{{ basename($message->attachment) }}</a>
                                    @endif
                                </li>
                            @endif
                        @endforeach

                        @if (!$hasAttachment)
                            Aucune pièce jointe
                        @endif
                    </ul>
                </div>
            </div>
        @else
            <div class="fs-4 text-center text-primary mt-5">
                Pas de conversation sélectionnée
            </div>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new MutationObserver((mutationsList, observer) => {
                for(const mutation of mutationsList) {
                    if (mutation.type === 'childList') {
                        const chatboxBody = document.getElementById('chatbox_body');
                        if (chatboxBody) {
                            chatboxBody.addEventListener('scroll', function() {
                                if (chatboxBody.scrollTop === 0) {
                                    Livewire.dispatch('loadMore');
                                }
                            });
                            observer.disconnect();
                        }
                    }
                }
            });
            observer.observe(document.body, { childList: true, subtree: true });

            window.addEventListener('rowChatToBottom', event => {
                setTimeout(() => {
                    const chatboxBody = document.querySelector('.chatbox_body');
                    if (chatboxBody) {
                        chatboxBody.scrollTop = chatboxBody.scrollHeight;
                    }
                }, 1);
            });

            const checkInterval = setInterval(function() {
                const attachmentsIcon = document.getElementById('attachmentsIcon');
                if (attachmentsIcon) {
                    console.log('Attachments icon found'); 
                    attachmentsIcon.addEventListener('click', function() {
                        const modal = document.getElementById('attachmentsModal');
                        if (modal) {
                            console.log('Modal element found'); 
                            modal.style.display = 'block';
                        } else {
                            console.log('Modal element not found'); 
                        }
                    });
                    clearInterval(checkInterval);
                }
            }, 1);
        });

        function closeAttachmentsModal() {
            const modal = document.getElementById('attachmentsModal');
            if (modal) {
                console.log('Closing modal'); 
                modal.style.display = 'none';
            } else {
                console.log('Modal element not found'); 
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '#return-btn', function() {
                Livewire.dispatch('resetComponent');
            });
        });
    </script>
</div>
