<div class="parent-container">

    <div class="chat_container">

        <div class="chat_list_container">
            @livewire('chat.chat-list')
        </div>
        <div class="chat_box_container">
            @livewire('chat.chatbox')

            @livewire('chat.send-message')
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   
    <script>
        
        $(document).ready(function() {
            function adjustContainers() {
                if (window.innerWidth < 768) {
                    $('.chat_list_container').css('width', '100%').show();
                    $('.chat_box_container').hide();
                } else {
                    $('.chat_list_container').css('width', '').show();
                    $('.chat_box_container').show();
                }
            }

            adjustContainers();
            $(window).resize(adjustContainers);
            
            window.addEventListener('chatSelected',event=>{
                // console.log("aaaaaaaaaa ", window.innerWidth);
                if(window.innerWidth < 768){
                    $('.chat_list_container').hide();
                    $('.chat_box_container').show();
                }
                setTimeout(() => {
                    const chatboxBody = $('.chatbox_body')[0];
                    if (chatboxBody) {
                        chatboxBody.scrollTop = chatboxBody.scrollHeight;
                        const height = chatboxBody.scrollHeight;
                        Livewire.dispatch('updateHeight', { height: height });
                    }
                }, 1);
            });

            $(window).resize(function(){
                if(window.innerWidth > 768){
                    $('.chat_list_container').show();
                    $('.chat_box_container').show();
                }
            });

            $(document).on('click', '#return-btn', function() {
                $('.chat_list_container').show();
                $('.chat_box_container').hide();
            });
        });

    </script>
    
</div>

