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
                    <h4 class="mb-0 card-title">UPLOAD AUTOMATIQUE DE CANDIDATS</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Veuillez vous assurer que votre grille est enregistrée au format CSV et que ses
                        colonnes suivent la structure du fichier "Matrice UploadCDT", disponible en exemple
                        téléchargeable.
                        .</p>
                    <form wire:submit.prevent="storeFileData">
                        @csrf
                        <div class="input-group">
                            <input type="file" class="form-control @error('fileData') is-invalid @enderror"
                                wire:model.live="fileData">
                            <button type="submit" class="btn btn-outline-primary" wire:loading.attr="disabled"
                                wire:target="fileData">UPLOAD</button>
                            <button type="button" class="btn btn-outline-primary" disabled wire:loading
                                wire:target="storeFileData">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                UPLOAD...
                            </button>
                            @error('fileData')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror

                        </div>
                        <!-- Barre de progression -->
                        <div class="mt-3 progress" style="height: 25px; display: none;"
                            wire:loading.class.remove="d-none" wire:loading.class="d-block"
                            wire:loading.target="fileData">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                                Chargement du fichier...
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end card body -->
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">Matrice UploadCDT</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <p class="text-muted">Veuillez télécharger l'exemplaire de la Matrice UploadCDT.</p>

                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar-xs">
                                <div class="rounded avatar-title bg-secondary-subtle text-secondary">
                                    <img src="{{ asset('assets/images/excel.png') }}" alt="excel file HARMEN & BOTT"
                                        width="30" height="30">
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1 fs-15">Exemple Matrice UploadCDT</h5>
                        </div>
                        <div>
                            <a class="btn btn-success" wire:click='downloadFile' wire:loading.remove
                                wire:target='downloadFile'>
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

    <div class="row">
        <div class="@if (!empty($accepted) && !empty($rejected)) col-md-6 @else col-md-12 @endif">
            @if (!empty($accepted))
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Les données acceptées avec succès
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table mb-0 align-middle table-striped table-hover table-hover-primary table-nowrap">
                                <thead class="text-white bg-primary sticky-top">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Aut</th>
                                        <th scope="col">Civ.</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Fonction</th>
                                        <th scope="col">Société</th>
                                        <th scope="col">Tél</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">CP/Dpt</th>
                                        <th scope="col">Ville</th>
                                        <th scope="col">Pays</th>
                                        <th scope="col">Etat</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Disponibilité</th>
                                        <th scope="col">Next step</th>
                                        <th scope="col">NSdate</th>
                                        <th scope="col">CV</th>
                                        <th scope="col">CRE</th>
                                        <th scope="col">Commentaire</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Suivi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($accepted as $value)
                                        @php
                                            $candidate = \App\Models\Candidate::find($value['id']);
                                        @endphp
                                        @if ($candidate)
                                            <tr
                                                ondblclick="window.location='{{ Route('candidates.show', $candidate->id) }}'">
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $candidate->auteur->trigramme ?? '' }}</td>
                                                <td>{{ $candidate->civ->name ?? '' }}</td>
                                                <td>{{ $candidate->first_name }}</td>
                                                <td id="Lcol">{{ $candidate->last_name ?? '--' }}</td>
                                                <td id="Lcol">{{ $candidate->position->name ?? '--' }}</td>
                                                <td>{{ $candidate->compagny->name ?? '--' }}</td>
                                                <td>{{ $candidate->phone ?? '--' }}</td>
                                                <td>{{ $candidate->email ?? '--' }}</td>
                                                <td>{{ $candidate->postal_code ?? '--' }}</td>
                                                <td>{{ $candidate->city ?? '--' }}</td>
                                                <td>{{ $candidate->country ?? '--' }}</td>
                                                @if ($candidate->candidateState->name == 'Certifié')
                                                    <td id="colState">
                                                        <span class="badge rounded-pill bg-success"
                                                            id="certificate-{{ 0 }}"
                                                            onclick="toggleCertificate({{ 0 }})">
                                                            <span
                                                                id="hidden-certificate-{{ 0 }}">Certifié</span>
                                                            <span id="visible-certificate-{{ 0 }}"
                                                                style="display: none;">{{ $candidate->certificate }}</span>
                                                        </span>
                                                    </td>
                                                @else
                                                    <td>{{ $candidate->candidateState->name }}</td>
                                                @endif
                                                <td>{{ $candidate->candidateStatut->name ?? '--' }}</td>
                                                <td>{{ $candidate->disponibility->name ?? '--' }}</td>
                                                <td>{{ $candidate->nextStep->name ?? '--' }}</td>
                                                <td>{{ $candidate->nsDate->name ?? '--' }}</td>
                                                <td>
                                                    @if ($candidate->files()->exists())
                                                        @php
                                                            $cvFile = $candidate
                                                                ->files()
                                                                ->where('file_type', 'cv')
                                                                ->first();
                                                        @endphp
                                                        @if ($cvFile)
                                                            <a class="text-body" href="#"
                                                                wire:click.prevent="selectCandidateGoToCv('{{ $candidate->id }}', '{{ $candidates->currentPage() }}')">OK</a>
                                                        @else
                                                            n/a
                                                        @endif
                                                    @else
                                                        n/a
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($candidate->cres()->exists())
                                                        <a class="text-body" href="#"
                                                            wire:click.prevent="selectCandidateGoToCre('{{ $candidate->id }}', '{{ $candidates->currentPage() }}')">{{ $candidate->cres()->exists() ? 'OK' : '--' }}</a>
                                                    @else
                                                        n/a
                                                    @endif
                                                </td>
                                                <td>{{ $candidate->commentaire ?? '--' }}</td>
                                                <td>{{ $candidate->description ?? '--' }}</td>
                                                <td>{{ $candidate->suivi ?? '--' }}</td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="21" class="text-center">
                                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                                    colors="primary:#405189,secondary:#0ab39c"
                                                    style="width:72px;height:72px"></lord-icon>
                                                <h5 class="mt-4">Aucun résultat trouvé</h5>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="@if (!empty($accepted) && !empty($rejected)) col-md-6 @else col-md-12 @endif">
            @if (!empty($rejected))
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Candidats rejetés
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table mb-0 align-middle table-striped table-hover table-hover-primary table-nowrap">
                                <thead class="text-white bg-primary sticky-top">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Aut</th>
                                        <th scope="col">Civ.</th>
                                        <th scope="col">Prénom</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Fonction</th>
                                        <th scope="col">Société</th>
                                        <th scope="col">Tél</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">CP/Dpt</th>
                                        <th scope="col">Ville</th>
                                        <th scope="col">Pays</th>
                                        <th scope="col">Etat</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Disponibilité</th>
                                        <th scope="col">Next step</th>
                                        <th scope="col">NSdate</th>
                                        <th scope="col">CV</th>
                                        <th scope="col">CRE</th>
                                        <th scope="col">Commentaire</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Suivi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rejected as $key => $value)
                                        @php
                                            $candidate = \App\Models\Candidate::where('first_name', $value['Prénom'])
                                                ->where('last_name', $value['Nom'])
                                                ->first();
                                        @endphp
                                        <tr
                                            @if ($candidate) ondblclick="window.location='{{ Route('candidates.show', $candidate->id) }}'" @endif>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $candidate->auteur->trigramme ?? '' }}</td>
                                            <td>{{ $candidate->civ->name ?? '' }}</td>
                                            <td>{{ $candidate->first_name ?? '--' }}</td>
                                            <td id="Lcol">{{ $candidate->last_name ?? '--' }}</td>
                                            <td id="Lcol">{{ $candidate->position->name ?? '--' }}</td>
                                            <td>{{ $candidate->compagny->name ?? '--' }}</td>
                                            <td>{{ $candidate->phone ?? '--' }}</td>
                                            <td>{{ $candidate->email ?? '--' }}</td>
                                            <td>{{ $candidate->postal_code ?? '--' }}</td>
                                            <td>{{ $candidate->city ?? '--' }}</td>
                                            <td>{{ $candidate->country ?? '--' }}</td>
                                            <td>{{ $candidate->candidateState->name ?? 'Attente' }}</td>
                                            <td>{{ $candidate->candidateStatut->name ?? '--' }}</td>
                                            <td>{{ $candidate->disponibility->name ?? '--' }}</td>
                                            <td>{{ $candidate->nextStep->name ?? '--' }}</td>
                                            <td>{{ $candidate->nsDate->name ?? '--' }}</td>
                                            <td>
                                                @if ($candidate && $candidate->files()->exists())
                                                    @php
                                                        $cvFile = $candidate
                                                            ->files()
                                                            ->where('file_type', 'cv')
                                                            ->first();
                                                    @endphp
                                                    @if ($cvFile)
                                                        OK
                                                    @else
                                                        n/a
                                                    @endif
                                                @else
                                                    n/a
                                                @endif
                                            </td>
                                            <td>
                                                @if ($candidate && $candidate->cres()->exists())
                                                    OK
                                                @else
                                                    n/a
                                                @endif
                                            </td>
                                            <td>{{ $candidate->commentaire ?? '--' }}</td>
                                            <td>{{ $candidate->description ?? '--' }}</td>
                                            <td>{{ $candidate->suivi ?? '--' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
