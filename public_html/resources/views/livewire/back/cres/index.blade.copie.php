<div>

    <!-- end page title -->
    <div class="d-flex">
        <div class="p-2 flex-grow-1">

        </div>

        <div class="p-2">
            @if ($candidate->cres()->exists())
                <a type="button" href="#"  wire:click.prevent="goToCre('{{ $candidate->id }}')"
                    class="btn btn-success">
                    Détail
                </a>
                <a type="button" href="{{ route('add.cre', ['candidate' => $candidate, 'action' => 'update']) }}"
                    class="btn btn-info ms-2">
                    <i class="ri-add-line align-bottom me-1"></i> Modifier
                </a>
            @else
                <a type="button" href="{{ route('add.cre', ['candidate' => $candidate, 'action' => 'create']) }}"
                    class="btn btn-primary">
                    <i class="ri-add-line align-bottom me-1"></i> Nouveau
                </a>
            @endif
        </div>

        <div class="p-2">
            <div class="search-box ms-2">
                <input type="text" class="form-control" placeholder="Rechercher..." wire:model.live='search'>
                <i class="ri-search-line search-icon"></i>
            </div>
        </div>
    </div>

    @if ($hasCre)
         @livewire('back.cres.show-pdf', ['candidate' => $candidate])
    @else
        <div class="card mt-5">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped  table-hover table-hover-primary align-middle table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Question</th>
                                <th scope="col">Réponse</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cres as $cre)
                                <tr>
                                    <td>{{ $cre->created_at->format('d/m/Y') ?? 'Non renseigné' }}</td>
                                    <td>{{ $cre->question }}</td>
                                    <td>{{ $cre->response }}</td>

                                    <td>
                                        <ul class="list-inline hstack gap-2 mb-0">
                                            <li class="list-inline-item">
                                                <a wire:click="confirmDelete('{{ $cre->response }}', '{{ $cre->id }}')"
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
    @endif

    <!-- end row -->
    <div class="row g-0 text-center text-sm-start align-items-center mb-4">
        <!-- end col -->
        {{ $cres->links() }}
    </div><!-- end row -->
</div>


