<?php

namespace App\Livewire\Back\Users;

use App\Models\User;
use Livewire\Component;
use App\Mail\GeneralMail;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class Profile extends Component
{
    use WithFileUploads;
    public $user;
    public $nbPaginate = 10;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $passwordRepete;
    public $photo;

    public function mount()
    {
        $this->user = Auth::user();
        $this->first_name = $this->user->first_name ?? '';
        $this->last_name = $this->user->last_name ?? '';
        $this->phone = $this->user->phone ?? '';
        $this->email = $this->user->email ?? '';
    }
    public function openModal($id = null)
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->phone = '';
        $this->email = '';
        if ($id) {
            $this->user = User::find($id);
            $this->first_name = $this->user->first_name ?? '';
            $this->last_name = $this->user->last_name ?? '';
            $this->phone = $this->user->phone ?? '';
            $this->email = $this->user->email ?? '';
        }
    }

    public function storeData()
    {
        $validateData = $this->validate(
            [
                'first_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:255',
                'email' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'password' => 'nullable',
                'photo' => 'nullable',
            ],
            [
                'first_name.required' => 'Le nom est obligatoire',
                'last_name.required' => 'Le prénom est obligatoire',
            ],
        );
        try {
            DB::beginTransaction();
           
            if ($validateData['photo']) {
                $file = $validateData['photo'];
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

                $file->storeAs('files', $fileName, 'public');
                $path = 'files' . '/' . $fileName;
                $validateData['profile_photo_path'] = $path;
            }
            $this->user->update([
                'first_name' => $validateData['first_name'],
                'phone' => $validateData['phone'],
                'email' => $validateData['email'],
                'last_name' => $validateData['last_name'],
                'profile_photo_path'=> $validateData['profile_photo_path'] ?? $this->user->profile_photo_path ?? null,
            ]);
            DB::commit();
            $this->dispatch('alert', type: 'success', message: 'Vos informations sont modifier avec succès');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Impossible de modifier vos informations');
        }
    }
    public function changePassword()
    {
        $validateData = $this->validate(
            [
                'password' => 'required|string|max:255',
                'passwordRepete' => 'required|string|max:255',
            ],
            [
                'password.required' => 'Le nom est obligatoire',
                'passwordRepete.required' => 'La repetition du mot de passe est obligatoire',
            ],
        );

        DB::beginTransaction();
        if ($validateData['password'] == $validateData['passwordRepete']) {
            $this->user->update(['password' => Hash::make($validateData['password'])]);
        } else {
            return $this->addError('passwordRepete', 'Le second mot de passe est différent.');
        }

        DB::commit();
        if ($this->user->uuid == Auth::user()->uuid) {
            return redirect()->route('login');
        }
        try {
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->dispatch('alert', type: 'error', message: 'Impossible de modifier vos informations');
        }
    }
    public function render()
    {
        return view('livewire.back.users.profile');
    }
}
