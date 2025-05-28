 <!-- Default Modals -->
 <div wire:ignore.self id="modal" class="modal fade" tabindex="-1" aria-labelledby="modal" aria-hidden="true"
     style="display: none;">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modal">{{ $title }}</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
             </div>
             {{ $body }} 
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
