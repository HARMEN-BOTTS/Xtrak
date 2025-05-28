<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'Listes des utilisateurs',
        'breadcrumbItems' => [
            ['text' => 'utilisateurs', 'url' => '#'],
            ['text' => 'Listes', 'url' => Route('users.index')],
        ],
    ])
    <!-- end page title -->
    <div class="d-flex">
        <div class="p-2 flex-grow-1">
            <button type="button" wire:click="openModal()" data-bs-toggle="modal" data-bs-target="#modal"
                class="btn btn-primary"><i class="ri-add-line align-bottom me-1"></i>
                Nouveau</button>
        </div>
        <div class="p-2">
            <select class="form-control w-md" wire:model.live='filterRoleId'>
                <option value="" selected>Filtrer par rôles</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>

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

    <div class="card mt-5">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped  table-hover table-hover-primary align-middle table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Trigramme</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Téléphone</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rôle</th>
                            <th scope="col">Date de création</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->trigramme }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <th scope="row">{{ $user->roles->first()->name }}</th>
                                <td>{{ $user->created_at->format('d/m/Y') ?? 'Non renseigné' }}</td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item edit">
                                            <a wire:click="openModal('{{ $user->id }}')" data-bs-toggle="modal"
                                                data-bs-target="#modal"
                                                class="text-primary d-inline-block edit-item-btn">
                                                <i class="ri-pencil-fill fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a wire:click="confirmDelete('{{ $user->name }}', '{{ $user->id }}')"
                                                class="text-danger d-inline-block remove-item-btn">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center">

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
        <!-- end col -->
        {{ $users->links() }}
    </div><!-- end row -->


    <x-modal>
        <x-slot name="title">
            {{ $isUpdate ? 'Modification d\'utilisateur' : 'Ajout d\'utilisateur' }}
        </x-slot>
        <x-slot name="body">

            <form wire:submit.prevent="storeData()">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror "
                                wire:model.live='last_name' placeholder="Veuillez entrer le prénom " />


                            @error('last_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror "
                                wire:model.live='first_name' placeholder="Veuillez entrer le nom " />


                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6  mt-3">
                            <label for="phone" class="form-label">Téléphone </label>
                            <input type="phone" class="form-control @error('phone') is-invalid @enderror "
                                wire:model.live='phone' placeholder="Veuillez entrer le numéro de téléphone " />


                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6  mt-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror "
                                wire:model.live='email' placeholder="Veuillez entrer l'address email " />


                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                        <label class="form-label" for="password-input">Mot de passe</label>
                        <div class="position-relative auth-pass-inputgroup mb-3">
                            <input type="password" wire:model.live='password'
                                class="form-control pe-5 password-input @error('password') is-invalid @enderror"
                                placeholder="Entrez votre mot de passe" id="password-input">
                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                    type="button" id="password-addon">
                                <i class="ri-eye-fill align-middle"></i>
                            </button>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                        <div class="col-md-6 mt-3">
                            <label for="role_id" class="form-label">Rôles
                            </label>
                            <select class="form-control @error('role_id') is-invalid @enderror "
                                wire:model.live='role_id'>
                                <option value="" selected>Selectionner un rôle
                                </option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="trigramme" class="form-label">Trigramme</label>
                            <input type="text" class="form-control @error('trigramme') is-invalid @enderror "
                                wire:model.live='trigramme' placeholder="Veuillez entrer le trigramme " />
                            @error('first_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
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