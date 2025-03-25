<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class ManageUser extends Component
{
    use WithPagination;

    public $search;

    public $userId;

    public $userForm = [
        'openModal' => false,
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'roles' => [],
    ];

    public $roles;

    public function mount()
    {
        $this->roles = Role::all();
    }


    public function updated($name, $value)
    {
        if ($name == 'search') {
            $this->resetPage();
        }
    }

    
    public function rules()
    {
        $rules = [
            'userForm.name' => 'required|string',
        ];

        if ($this->userId) {
            $rules['userForm.email'] = 'required|email|unique:users,email,' . $this->userId;
            $rules['userForm.password'] = 'nullable|confirmed';
        }else{
            $rules['userForm.email'] = 'required|email|unique:users,email';
            $rules['userForm.password'] = 'required|confirmed';
        }

        return $rules;
    }

    public function validationAttributes()
    {
        return [
            'userForm.name' => 'name',
            'userForm.email' => 'email',
            'userForm.password' => 'password',
            'userForm.password_confirmation' => 'password confirmation',
        ];
    }

    public function save()
    {
        if ($this->userId) {
            $this->update();
        }else{
            return $this->store();
        }
    }

    public function create()
    {
        $this->reset(['userId', 'userForm']);
        $this->userForm['openModal'] = true;
    }

    public function store()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->userForm['name'],
            'email' => $this->userForm['email'],
            'password' => bcrypt($this->userForm['password']),
        ]);

        $user->roles()->sync($this->userForm['roles']);

        $this->reset('userForm');
    }

    public function edit(User $user)
    {

        $this->userId = $user->id;

        $this->userForm = [
            'openModal' => true,
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
            'password_confirmation' => '',
            'roles' => $user->roles->pluck('id')->toArray(),
        ];
    }

    public function update()
    {
        $this->validate();

        $user = User::find($this->userId);

        $user->name = $this->userForm['name'];
        $user->email = $this->userForm['email'];

        if ($this->userForm['password']) {
            $user->password = bcrypt($this->userForm['password']);
        }

        $user->save();

        $user->roles()->sync($this->userForm['roles']);

        $this->reset('userForm');

    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function render()
    {
        $users = User::when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate();

        return view('livewire.manage-user', compact('users'));
    }
}
