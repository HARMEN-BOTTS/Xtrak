<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'UPLOAD CANDIDATS',
        'breadcrumbItems' => [
            ['text' => 'Candidats', 'url' => '#'],
            ['text' => 'Import', 'url' => Route('import.candidat')],
        ],
    ])

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">UPLOAD AUTOMATIQUE DE CANDIDATS</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Veuillez vous assurer que votre grille est enregistrée au format CSV et que ses
                        colonnes suivent la structure du fichier "Matrice UploadCDT", disponible en exemple
                        téléchargeable.
                        .</p>

                    <form wire:submit.prevent="storeData()">
                        @csrf
                        <div class="input-group">
                            <input type="file" class="form-control @error('file') is-invalid @enderror"
                                wire:model='file' aria-label="Upload" accept=".xls, .xlsx," required>
                            <button wire:loading.remove wire:target="storeData" type="submit"
                                class="btn btn-outline-primary">UPLOAD</button>
                            <button wire:loading wire:target="storeData" type="button" class="btn btn-outline-primary"
                                disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                UPLOAD...
                            </button>
                            @error('file')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </form>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Matrice UploadCDT</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Veuillez télécharger l'exemplaire de la Matrice UploadCDT.</p>

                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-xs">
                                <div class="avatar-title rounded bg-secondary-subtle text-secondary">
                                    <img src="{{ asset('assets/images/excel.png') }}" alt="excel file HARMEN & BOTT"
                                        width="30" height="30">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1 fs-15">Exemple Matrice UploadCDT</h5>
                        </div>
                        <div>
                            <a class="btn btn-success" wire:click='downloadFile' wire:loading.remove wire:target='downloadFile'>
                                <i class="ri-download-fill"></i>
                            </a>
                            <a class="btn btn-success" wire:loading wire:target='downloadFile' disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Téléchargement...
                            </a>
                        </div>
                        
                        
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
    </div>
</div>
