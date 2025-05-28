<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'Nouveau C.R.E',
        'breadcrumbItems' => [
            ['text' => 'C.R.E', 'url' => '#'],
            ['text' => 'Nouveau', 'url' => '#', 'active' => true],
        ],
    ])
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form wire:submit.prevent="storeData()">
                    @csrf
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="p-2 flex-grow-1">
                                <h5 class="card-title mb-0 ">
                                    {{ $action == 'create' ? "Formulaire de creation d'un C.R.E" : "Formulaire de modification d'un C.R.E" }}
                                </h5>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" onclick="goBack()" class="btn btn-secondary me-2"><i class="mdi mdi-arrow-left me-1"></i>Retour</a>
                                <button type="submit" class="btn btn-primary">{{ $action == 'create' ? 'Enregistrer' : 'Enregistrer les modifications' }}</button>
                            </div>

                        </div>


                    </div>
                    <div class="card-body">
                        
                       
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response1" class="form-label">1. Statut professionnel :</label>
                                    <textarea wire:model='response1' class="form-control auto-resize" id="response1" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response2" class="form-label">2. Statut personnel :</label>
                                    <textarea wire:model='response2' class="form-control auto-resize" id="response2" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                       
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response3" class="form-label">3. Situation professionnelle :</label>
                                    <textarea wire:model='response3' class="form-control auto-resize" id="response3" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response4" class="form-label">4. Points incontournables :
                                    </label>
                                    <textarea wire:model='response4' class="form-control auto-resize" id="response4" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                        
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response5" class="form-label">5. Savoir-être du candidat : 
                                    </label>
                                    <textarea wire:model='response5' class="form-control auto-resize" id="response5" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response6" class="form-label">6. Prise de référence(s) :</label>
                                    <textarea wire:model='response6' class="form-control auto-resize" id="response6" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                        
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response7" class="form-label">7. Prétentions salariales :</label>
                                    <textarea wire:model='response7' class="form-control auto-resize" id="response7" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response8" class="form-label">8. Disponibilités candidat :</label>
                                    <textarea wire:model='response8' class="form-control auto-resize" id="response8" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <div>
                                    <label for="response7" class="form-label">9. Résumé du parcours professionnel :</label>
                                    <textarea wire:model='response9' class="form-control auto-resize" id="response9" 
                                        style="resize: none; overflow-y: hidden;"></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit"
                                class="btn btn-primary">{{ $action == 'create' ? 'Enregistrer' : 'Enregistrer les modifications' }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@push('page-script')
    <script>
        document.addEventListener("input", function(event) {
            if (event.target.tagName.toLowerCase() !== "textarea") return;
            autoResize(event.target);
        }, false);

        function autoResize(textarea) {
            textarea.style.height = "auto";
            textarea.style.height = (textarea.scrollHeight) + "px";
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.auto-resize').forEach(function(textarea) {
                autoResize(textarea);
            });
        });
    </script>
    
@endpush
