<div>
    @if ($selectedConversation)
        <form wire:submit.prevent='sendMessage' enctype="multipart/form-data" id="messageForm">
            <div class="chatbox_footer" x-data @keydown.enter.prevent="if (!event.shiftKey) { $el.closest('form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true })); } else { event.target.value += '\n'; }">
                <div class="custom_form_group">

                    @if ($attachment)
                        <div class="attachment-preview">
                            @if (in_array($attachment->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']))
                                <div class="attachment-thumbnail">
                                    <img src="{{ $attachment->temporaryUrl() }}" alt="Image preview">
                                </div>
                            @else
                                <div class="attachment-icon">
                                    <i class="bi bi-file-earmark"></i>
                                </div>
                                <div class="attachment-filename">
                                    {{ $attachment->getClientOriginalName() }}
                                </div>
                            @endif
                            <button type="button" wire:click="removeAttachment">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    @endif
                    <textarea wire:model='body' class="control" placeholder="Écrire le message" rows="3" id="messageInput"></textarea>

                    <input wire:model='attachment' type="file" id="fileInput" style="display: none;">
                    <label for="fileInput" style="font-size: 24px; margin-right: 10px;">
                        <i class="bi bi-paperclip"></i>
                    </label>

                    <button type="submit" class="submit">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
