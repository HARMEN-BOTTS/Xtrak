<div>

    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{ asset('assets/images/profile-bg.jpg') }}" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
        <div class="row g-4">
            <div class="text-center col-auto profile-user position-relative d-inline-block mx-auto  mb-4">
                @if ($user->profile_photo_path != null)
                    <img src=" {{ asset('storage') . '/' . $user->profile_photo_path }}"
                        class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                @else
                    <img src="assets/images/logo.png" class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                        alt="user-profile-image">
                @endif

            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{ $user->first_name }} {{ $user->last_name }}</h3>
                    <p class="text-white text-opacity-75">{{ $user->roles->first()->name }}</p>
                    <div class="hstack text-white-50 gap-1">
                        <div>
                            <i class="ri-building-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>HARMEN & BOTTS
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->


        </div>
        <!--end row-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div>
                <div class="d-flex profile-wrapper">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                    class="d-none d-md-inline-block">Vos informations</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                Changez votre mot de passe
                            </a>
                        </li>
                    </ul>

                </div>
                <!-- Tab panes -->
                <div class="tab-content pt-4 text-muted">
                    <div class="tab-pane active" id="overview-tab" role="tabpanel">
                        <div class="row">
                            <div class="col-xxl-12">
                                <form wire:submit.prevent="storeData()">
                                    @csrf
                                    <div class="card">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="trigramme" class="form-label">Trigramme</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            value='{{ $user->trigramme }}'
                                                            disabled>
                                                    </div>

                                                   
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">Photo de profil</label>
                                                        <input wire:model='photo' type="file" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="firstnameInput" class="form-label">Prénom</label>
                                                        <input wire:model='first_name' type="text"
                                                            class="form-control  @error('first_name') is-invalid @enderror"
                                                            id="firstnameInput" placeholder="Enter your firstname">
                                                    </div>
                                                    @error('first_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="lastnameInput" class="form-label">Nom</label>
                                                        <input type="text"
                                                            class="form-control @error('last_name') is-invalid @enderror"
                                                            wire:model='last_name'
                                                            placeholder="Veuillez entrer le prénom ">
                                                    </div>

                                                    @error('last_name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="phonenumberInput"
                                                            class="form-label">Téléphone</label>
                                                        <input type="text" class="form-control"
                                                            wire:model.live='phone'
                                                            placeholder="Veuillez entrer le numéro de téléphone ">
                                                    </div>
                                                </div>
                                                <!--end col-->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="emailInput" class="form-label">Address Email
                                                        </label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            wire:model='email'
                                                            placeholder="Veuillez entrer l'address email ">
                                                    </div>
                                                    @error('email')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <!--end col-->


                                                <!--end col-->
                                            </div>

                                        </div><!-- end card body -->
                                        <div class="card-footer">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                            </div>
                                        </div>
                                    </div><!-- end card -->
                                </form>
                            </div>
                            <!--end col-->

                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <div class="tab-pane" id="changePassword" role="tabpanel">
                        <form wire:submit.prevent="changePassword()">
                            @csrf
                            <div class="card">
                                <div class="card-body">

                                    <div class="row g-2  mt-3">
                                        <div class="mb-2 mt-2 col-lg-4 ">
                                            <label class="form-label" for="password-input">Nouveau mot de
                                                passe </label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror pe-5 password-input"
                                                    wire:model='password' placeholder="Nouveau ">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-2 mt-2 col-lg-4">
                                            <label class="form-label" for="passwordRepete-input">Repetez le
                                                mot de passe
                                            </label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password"
                                                    class="form-control @error('passwordRepete') is-invalid @enderror pe-5 password-input"
                                                    wire:model='passwordRepete' placeholder="Repetez le nouveau">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted "
                                                    type="button"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>

                                            @error('passwordRepete')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->

                                </div>
                                <div class="card-footer">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success">Enregistrer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
            <!--end tab-content-->
        </div>
    </div>
    <!--end col-->
</div>

</div>