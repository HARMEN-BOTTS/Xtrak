<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'Nombre de candidats par utilisateur',
        'breadcrumbItems' => [['text' => 'détail', 'url' => '#'], ['text' => 'Listes', 'url' => '#']],
    ])
    <!-- end page title -->
    <div class="d-flex">
        <div class="p-2">
            <select class="form-control w-md" wire:model.live='user_id'>
                <option value="" selected>Filtrer par utilisateur</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">
            <div class="card-header">
                <h4 class="card-title
                ">Nombre de candidats par utilisateur</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped  table-hover table-hover-primary align-middle table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Trigramme</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aujourd'hui</th>
                            <th scope="col">7 derniers jours</th>
                            <th scope="col">30 derniers jours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usersWithCandidateCounts as $value)
                            <tr>
                                <td>{{ $value->trigramme ?? ''}}</td>
                                <td>{{ $value->last_name ?? ''}}</td>
                                <td>{{ $value->first_name ?? ''}}</td>
                                <td>{{ $value->total_candidates ?? 0 }}</td>
                                <td>{{ $value->candidates_today ?? 0 }}</td>
                                <td>{{ $value->candidates_this_week ?? 0 }}</td>
                                <td>{{ $value->candidates_this_month ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                   
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
        {{-- {{ $usersWithCandidateCounts->links() }} --}}
    </div><!-- end row -->
</div>
