<div>
    <div class="card mt-4">
        <div class="card-header align-items-center d-flex border-bottom-dashed">
            <h4 class="card-title mb-0 flex-grow-1">Documents</h4>
            {{-- <div class="flex-shrink-0">
               
            </div> --}}
        </div>
        <div class="col-md-12 ">
            <div class="d-flex ">

                <div class=" p-2">
                    <div class="search-box ms-2">
                        <input type="text" class="form-control" placeholder="Rechercher..." wire:model.live='search'>
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div>
                <div class="p-2 ">
                    <select class="form-control w-md" wire:model.live='nbPaginate'>
                        <option value="0">Tous</option>
                        <option value="5" selected>5</option>
                        <option value="10">20</option>
                        <option value="20">30</option>
                        <option value="30">50</option>
                        <option value="50">100</option>
                    </select>
                </div>
                <div class="p-2">
                    <button type="button" wire:click="openModal()" data-bs-toggle="modal" data-bs-target="#modal"
                    class="btn btn-soft-info "><i class="ri-upload-2-fill me-1 align-bottom"></i>
                    Nouveau</button>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="vstack gap-2">
                @forelse ($files as $file)
                    <div class="border rounded border-dashed p-2">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <div class="avatar-title bg-light text-secondary rounded fs-24">
                                        <i class="ri-file-ppt-2-line"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="fs-15 mb-1">
                                    <a type="button" href="#" wire:click.prevent="goToCv('{{ $file->candidate->id }}')"
                                    class="text-body text-truncate d-block">{{ $file->name ?? '---' }}</a>
                                </h5> 
                                <p
                                    class="fw-medium badge rounded-pill bg-primary fs-10 
                                mb-0">
                                    @if ($file->file_type)
                                        @if ($file->file_type == 'cv')
                                            Curriculum Vitae
                                        @elseif($file->file_type == 'cover letter')
                                            Lettre de motivation
                                        @else
                                            Autre
                                        @endif
                                    @endif
                                </p>

                            </div>
                            <div class="flex-shrink-0 ms-2">
                                <div class="d-flex gap-1">

                                    {{-- <a class=""
                                        href="{{ asset('storage') . '/' . $file->path }}"
                                        download="{{ $file->name }}">
                                        <i class=""></i>
                                    </a> --}}
                                    <a class="btn btn-icon text-muted btn-sm fs-18"
                                        wire:click="downloadFile('{{ $file->path }}','{{ $file->name }}')">
                                        <i class="ri-download-2-line"></i>
                                    </a>
                                    <a wire:click="confirmDelete('{{ $file->name }}', '{{ $file->id }}')"
                                        class="btn btn-icon text-danger btn-sm fs-18">
                                        <i class="ri-delete-bin-fill align-bottom"></i>
                                    </a>
                                                                
                                    <div class="dropdown">
                                        <button class="btn btn-icon text-muted btn-sm fs-18 dropdown" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu">

                                            <li>

                                                <a class="dropdown-item" wire:click="openModal('{{ $file->id }}')"
                                                    data-bs-toggle="modal" data-bs-target="#modal"><i
                                                        class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                    Renommer</a>
                                            </li>
                                            <li><a wire:click="confirmDelete('{{ $file->name }}', '{{ $file->id }}')"
                                                    class="dropdown-item"><i
                                                        class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                    Supprimer</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-4 mt-4 text-center" id="noresult">
                        <h5 class="mt-4">Aucun document trouvé</h5>
                    </div>
                @endforelse


            </div>

        </div>
        <div class="card-header">
            <div class="row g-0 text-center text-sm-start align-items-center mb-4">
                <!-- end col -->
                {{ $files->links() }}
            </div><!-- end row -->
        </div>
        <!-- end card body -->
    </div>

    <x-modal>
        <x-slot name="title">
            {{ $isUpdate ? 'Modification du document' : 'Ajout de document' }}
        </x-slot>
        <x-slot name="body">
            <form wire:submit.prevent="storeFile()">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        @if (!$isUpdate)
                        <div class="col-md-12">
                            <label for="fileType" class="form-label">Type</label>
                            <select wire:model="fileType"
                                class="form-select mb-3  @error('fileType') is-invalid @enderror">
                                <option value="" selected>Selectionner</option>
                                <option value="cv">Curriculum Vitae</option>
                                <option value="cover letter">Lettre de motivation</option>
                                <option value="other">Autre</option>
                                @error('fileType')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror

                        </div>
                        @endif
                        @if ($isUpdate)
                        <div class="col-md-12">
                                <label for="name" class="form-label">Nom du document <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror "
                                    wire:model.live='name' placeholder="Veuillez entrer le nom du document" />


                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                          
                        </div>
                        @endif
                        @if (!$isUpdate)
                        <div class="col-md-12 ">
                          
                                <label for="newFile" class="form-label ">Documents</label>
                                <input wire:model="newFile" class="form-control mt-4 @error('newFile') is-invalid @enderror"
                                    type="file">
                                @error('newFile')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                           
                        </div>
                        @endif
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary ">{{ $isUpdate ? 'Modifier' : 'Ajouter' }}</button>
                </div>
            </form>
        </x-slot>
    </x-modal>

</div>
