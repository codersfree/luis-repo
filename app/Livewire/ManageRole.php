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

        if ($this->roleId) {
            return [
                'roleForm.name' => 'required|string|unique:roles,name,' . $this->roleId,
            ];
        }

        return [
            'roleForm.name' => 'required|string|unique:roles,name',
        ];

    }

    public function validationAttributes()
    {
        return [
            'roleForm.name' => 'nombre',
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

        $this->dispatch('swal', [
            'icon' => 'success',
            'title'   => '¡Rol creado!',
            'text' => 'El rol se ha creado correctamente.',
        ]);
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

        $this->dispatch('swal', [
            'icon' => 'success',
            'title'   => '¡Rol actualizado!',
            'text' => 'El rol se ha actualizado correctamente.',
        ]);

    }

    public function delete(Role $role)
    {
        $role->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title'   => '¡Rol eliminado!',
            'text' => 'El rol se ha eliminado correctamente.',
        ]);
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
