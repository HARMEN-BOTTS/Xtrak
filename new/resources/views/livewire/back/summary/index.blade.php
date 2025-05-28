<div>
    <!-- start page title -->
    @include('components.breadcrumb', [
        'title' => 'Nombre de connexion par utilisateur',
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
                <h4 class="card-title">Nombre de connexion par utilisateur</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover table-hover-primary align-middle table-nowrap mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Trigramme</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aujourd'hui</th>
                            <th scope="col">7 derniers jours</th>
                            <th scope="col">30 derniers jours</th>
                            <th scope="col">Dernière connexion</th>
                            <th scope="col">Etat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usersWithLoginTimes as $userData)
                            <tr>
                                <td>{{ $userData['user']->trigramme ?? '' }}</td>
                                <td>{{ $userData['user']->last_name ?? '' }}</td>
                                <td>{{ $userData['user']->first_name ?? '' }}</td>
                                <td>{{ gmdate('H:i:s', $userData['total_login_time']) }}</td>
                                <td>{{ gmdate('H:i:s', $userData['login_time_today']) }}</td>
                                <td>{{ gmdate('H:i:s', $userData['login_time_this_week']) }}</td>
                                <td>{{ gmdate('H:i:s', $userData['login_time_this_month']) }}</td>
                                <td style="width: 50px;">
                                    @if ($userData['user']->last_seen)
                                        {{ Carbon\Carbon::parse($userData['user']->last_seen)->diffForHumans() }}
                                    @else
                                        Jamais connecté
                                    @endif
                                </td>
                                <td style="width: 50px;" class="py-3 px-6 text-center">
                                    @if ($userData['user']->is_connect)
                                        <span class="badge border border-light rounded-circle bg-success p-2 fs-4">
                                        </span>
                                    @else
                                        <span class="badge border border-light rounded-circle bg-danger p-2 fs-4">
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
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
        {{-- {{ $usersWithLoginCounts->links() }} --}}
    </div><!-- end row -->

    {{-- @push('page-script')
        <script>
            setInterval(function() {
                Livewire.dispatch('userActivityUpdated');
            }, 500);
        </script>
    @endpush --}}
    @push('scripts')
    <script>
        window.addEventListener('beforeunload', function (e) {
            
            Livewire.dispatch('userDisconnected');
        });

        window.addEventListener('unload', function (e) {
            Livewire.dispatch('userDisconnected');
        });
    </script>
@endpush

</div>
