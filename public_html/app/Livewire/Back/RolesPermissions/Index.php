<?php

namespace App\Livewire\Back\RolesPermissions;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Index extends Component
{
    public $roles;
    public $permissions;
    public $role;
    public $permission;
    public $role_id;
    public $permission_id;
    public function mount()
    {
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }
    public function updateRolePermission($role, $permission)
    {
        try {
            DB::beginTransaction();
            $role = Role::find($role);
            $permission = Permission::find($permission);
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
            } else {
                $role->givePermissionTo($permission);
            }
            $this->roles = Role::all();
            $this->permissions = Permission::all();
            DB::commit();
            $this->dispatch('alert', type: 'success', message: 'Rôle et permission mis à jour avec succès');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Impossible de mettre à jour le rôle et la permission');
        }
    }
    public function render()
    {
        return view('livewire.back.roles-permissions.index');
    }
}
