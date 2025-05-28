<div>
    @include('components.breadcrumb', [
        'title' => 'Listes des rôles et permissions',
        'breadcrumbItems' => [
            ['text' => 'Paramètres', 'url' => '#'],
            ['text' => 'Listes des rôles et permissions', 'url' => Route('roles.permissions')],
        ],
    ])

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listes des rôles et permissions</h3>
                </div>
                <div class="card-body">
                    <!-- Bordered Tables -->
                    <div class="table-responsive">

                        <table
                            class="table table-striped  table-hover table-hover-primary align-middle table-nowrap mb-0">
                            <thead class="bg-secondary text-white">
                        <thead class="bg-white text-black sticky-top">
                            <tr>
                                <th scope="col">Autorisations</th>
                                @foreach ($roles as $role)
                                    <th scope="col">{{ $role->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $index => $permission)
                                <tr class="{{  $index % 2 == 0 ? 'table-secondary' : '' }}">
                                    <td>{{ $permission->name }}</td>
                                    @foreach ($roles as $role)
                                        <td>
                                            <input type="checkbox" style="transform: scale(1.5);"
                                                wire:change="updateRolePermission({{ $role->id }}, {{ $permission->id }})"
                                                @if ($role->permissions->count() > 0 && $role->hasPermissionTo($permission->name)) checked @endif>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
