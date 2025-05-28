<!-- resources/views/livewire/back/cres/show_pdf.blade.php -->

<div>
    <div class="row justify-content-center">
        <div class="col-xxl-9">
            <div class="card" id="demo">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header border-bottom-dashed p-4">
                            <div class="d-flex">
                                <div class="p-2 flex-fill">
                                    <img src="{{ asset('assets/images/logo.jpg') }}" alt="" class="img-fluid" height="200" width="200">
                                </div>
                                <div class="p-2 flex-fill mt-4">
                                    <span class="fw-bold">CONFIDENTIEL</span>
                                </div>
                                <div class="p-2 flex-fill">
                                    <h6>
                                        <span class="fw-bold">Réf: </span>
                                        <span class="badge bg-light-subtle text-body text-wrap" id="legal-register-no">{{ $candidate->cre_ref ?? '---' }}</span>
                                    </h6>
                                    <h6>
                                        <span class="fw-bold">Auteur: </span>
                                        <span class="badge bg-light-subtle text-body text-wrap">{{ $candidate->auteur->trigramme ?? '' }}</span>
                                    </h6>
                                    <h6>
                                        <span class="fw-bold">Date: </span>
                                        <span class="badge bg-light-subtle text-body text-wrap">{{ $candidate->cre_created_at ? \Carbon\Carbon::parse($candidate->cre_created_at)->format('d-m-Y') : '--' }}</span>
                                    </h6>
                                </div>
                            </div>
                            <div class="mt-4 ms-1">
                                <div>
                                    <p class="fw-bold">COMPTE RENDU D'ENTRETIEN DE {{ $candidate->civ->name ?? '---' }}. <span class="badge bg-light-subtle text-body text-wrap fs-15">{{ $candidate->first_name ?? '---' }} {{ $candidate->last_name ?? '---' }}</span></p>
                                </div>
                                <div class="d-flex justify-content-start mt-2">
                                    <p class="fw-bold">POSTE : <span class="badge bg-light-subtle text-body fs-15 text-wrap">{{ $candidate->position->name ?? '---' }}</span></p>
                                </div>
                            </div>
                        </div>
                        <!-- end card-header -->
                    </div><!-- end col -->

                    <div class="col-lg-12">
                        <div class="card-body p-4">
                            <ol>
                                @forelse ($cres as $cre)
                                    <li>
                                        <p class="fw-bold">{{ $cre->question }} :</p>
                                        <p class="text-start badge bg-light-subtle text-body fs-6 text-wrap">{{ $cre->response }}</p>
                                    </li>
                                @empty
                                    <div class="alert alert-warning" role="alert">
                                        Aucun compte rendu d'entretien n'est disponible pour le moment.
                                    </div>
                                @endforelse
                            </ol>
                        </div>
                        <!-- end card-body -->
                    </div><!-- end col -->
                    <div class="hstack gap-2 justify-content-center mt-2">
                        <span>-----+-----+-----+-----</span>
                    </div>
                </div><!-- end row -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
</div>
