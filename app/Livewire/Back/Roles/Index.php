<?php

namespace App\Livewire\Back\Roles;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $role;
    public $search = '';
    public $nbPaginate = 10;
    public $name;
    public $isUpdate = false;
    #[On('delete')]
    public function deleteData($id)
    {
        DB::beginTransaction();
        $role = Role::find($id);
        if ($role) {
            if ($role->name == 'Administrateur') {
                DB::rollBack();
                $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le rôle $role->name");
                return;
            }
            $role->permissions()->detach();
            $role->delete();
        } else {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le rôle $role->name");
        }
        DB::commit();
        $this->dispatch('alert', type: 'success', message: 'le rôle est supprimé avec succès');
        try {
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: "Impossible de supprimer le rôle $role->name");
        }
    }

    public function confirmDelete($nom, $id)
    {
        $this->dispatch('swal:confirm', title: 'Suppression', text: "Vous-êtes sur le point de supprimer le rôle $nom", type: 'warning', method: 'delete', id: $id);
    }
    public function searchFiles()
    {
        return Role::where('name', 'like', '%' . $this->search . '%')->paginate($this->nbPaginate);
    }
    public function openModal($id = null)
    {
        $this->name = '';
        $this->isUpdate = false;
        if ($id) {
            $this->isUpdate = true;
            $this->role = Role::find($id);
            $this->name = $this->role->name ?? '';
        }
    }
    public function storeData()
    {
        $validateData = $this->validate(
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Le nom est obligatoire',
            ],
        );
        DB::beginTransaction();

        if ($this->isUpdate) {
            if ($this->role->name == 'Administrateur') {
                DB::rollBack();
                $this->dispatch('alert', type: 'error', message: 'Impossible de modifier le rôle administrateur');
                return;
            }
            $this->role->update($validateData);
        } else {
            Role::create([
                'name' => $validateData['name'],
                'guard_name' => 'web',
            ]);
        }
        DB::commit();
        $this->dispatch('close:modal');
        $this->dispatch('alert', type: 'success', message: $this->isUpdate ? 'le nom est modifié avec success' : 'le rôle est ajouté avec succès');
        try {
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: $this->isUpdate ? 'Impossible de modifier le nom' : 'Impossible d\'ajouter le rôle');
        }
    }
    public function render()
    {
        return view('livewire.back.roles.index')->with([
            'roles' => $this->searchFiles(),
        ]);
    }
}
