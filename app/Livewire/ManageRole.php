<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRole extends Component
{

    public $search;

    public $roleId;

    public $roleForm = [
        'openModal' => false,
        'name' => '',
        'permissions' => [],
    ];

    public $permissions;

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function updated($name, $value)
    {
        if ($name == 'search') {
            $this->resetPage();
        }
    }


    public function rules()
    {
        return [
            'roleForm.name' => 'required|string',
        ];
    }

    public function save()
    {
        if ($this->roleId) {
            $this->update();
        }else{
            return $this->store();
        }
    }

    public function create()
    {
        $this->reset(['roleId', 'roleForm']);
        $this->roleForm['openModal'] = true;
    }

    public function store()
    {
        $this->validate();

        $role = Role::create($this->roleForm);

        $role->permissions()->sync($this->roleForm['permissions']);

        $this->reset('roleForm');
    }

    public function edit(Role $role)
    {

        $this->roleId = $role->id;

        $this->roleForm = [
            'openModal' => true,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('id')->toArray(),
        ];
    }

    public function update()
    {
        $this->validate();

        $role = Role::find($this->roleId);

        $role->update($this->roleForm);

        $role->permissions()->sync($this->roleForm['permissions']);

        $this->reset('roleForm');

    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function render()
    {
        $roles = Role::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->paginate();

        return view('livewire.manage-role', compact('roles'));
    }
}
