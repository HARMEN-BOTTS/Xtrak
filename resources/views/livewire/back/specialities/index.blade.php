<div>
    <!-- start page title -->
    {{-- @include('components.breadcrumb', [
        'title' => 'Listes des spécialités',
        'breadcrumbItems' => [
            ['text' => 'spécialités', 'url' => '#'],
            ['text' => 'Listes', 'url' => Route('specialities.index')],
        ],
    ]) --}}
    <!-- end page title -->
    <div class="d-flex justify-content-end">
        <div class="p-2">
            <button type="button" wire:click="openModal()" data-bs-toggle="modal" data-bs-target="#modal"
                class="btn btn-primary"><i class="ri-add-line align-bottom me-1"></i>
                Nouveau</button>
        </div>
        <div class="p-2">
            <select class="form-control w-md" wire:model.live='nbPaginate'>
                <option value="6" selected>6</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
        <div class="p-2">
            <div class="search-box ms-2">
                <input type="text" class="form-control" placeholder="Rechercher..." wire:model.live='search'>
                <i class="ri-search-line search-icon"></i>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-hover-primary align-middle table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Poste</th>
                            <th scope="col">Spécialité</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($specialities as $speciality)
                            <tr id="speciality-{{ $speciality->id }}" ondblclick="handleDoubleClick('{{ $speciality->id }}')">
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $speciality->position->name ?? '---' }}</td>
                                <td>{{ $speciality->name ?? '---'}}</td>
                                <td>{{ $speciality->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <!-- <li class="list-inline-item edit">
                                            <a wire:click="openModal('{{ $speciality->id }}')" data-bs-toggle="modal" data-bs-target="#modal"
                                                class="text-primary d-inline-block edit-item-btn">
                                                <i class="ri-pencil-fill fs-16"></i>
                                            </a>
                                        </li> -->
                                        <li class="list-inline-item">
                                            <a wire:click="confirmDelete('{{ $speciality->name }}', '{{ $speciality->id }}')"
                                                class="text-danger d-inline-block remove-item-btn">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <h5 class="mt-4">Aucun résultat trouvé</h5>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- end row -->
    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
        {{ $specialities->links() }}
    </div><!-- end row -->

    <x-modal>
        <x-slot name="title">
            {{ $isUpdate ? 'Modification de la spécialité' : 'Ajout de la spécialité' }}
        </x-slot>
        <x-slot name="body">
            <form wire:submit.prevent="storeData()">
                @csrf
                <div class="modal-body">
                    <div class="mb-2 mt-2">
                        <div>
                            <label for="position" class="form-label">Postes</label>
                            <select class="form-control form-control-custom @error('position_id') is-invalid @enderror"
                                wire:model='position_id'>
                                <option value="" selected>Selectionner</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                            @error('position_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2 mt-2">
                        <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                            wire:model.live='name' placeholder="Veuillez entrer le nom" />
                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">{{ $isUpdate ? 'Modifier' : 'Ajouter' }}</button>
                </div>
            </form>
        </x-slot>
    </x-modal>
</div>

<script>
    function handleDoubleClick(id) {
        @this.openModal(id);
        var myModal = new bootstrap.Modal(document.getElementById('modal'), {
            keyboard: false
        });
        myModal.show();
    }
</script>
