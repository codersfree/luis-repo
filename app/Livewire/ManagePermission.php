<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class ManagePermission extends Component
{

    public $search;

    public $permissionId;

    public $permissionForm = [
        'openModal' => false,
        'name' => '',
    ];

    public function updated($name, $value)
    {
        if ($name == 'search') {
            $this->resetPage();
        }
    }

    public function rules()
    {
        return [
            'permissionForm.name' => 'required|string',
        ];
    }

    public function save()
    {
        if ($this->permissionId) {
            $this->update();
        }else{
            return $this->store();
        }
    }

    public function create()
    {
        $this->reset(['permissionId', 'permissionForm']);
        $this->permissionForm['openModal'] = true;
    }

    public function store()
    {
        $this->validate();

        Permission::create($this->permissionForm);

        $this->reset('permissionForm');

        $this->dispatch('swal', [
            'icon' => 'success',
            'title'   => '¡Permiso creado!',
            'text' => 'El permiso se ha creado correctamente.',
        ]);
    }

    public function edit(Permission $permission)
    {
        $this->permissionId = $permission->id;

        $this->permissionForm = [
            'openModal' => true,
            'name' => $permission->name,
        ];
    }

    public function update()
    {
        $this->validate();

        $permission = Permission::find($this->permissionId);

        $permission->update($this->permissionForm);

        $this->reset('permissionForm');

        $this->dispatch('swal', [
            'icon' => 'success',
            'title'   => '¡Permiso actualizado!',
            'text' => 'El permiso se ha actualizado correctamente.',
        ]);

    }


    public function delete(Permission $permission)
    {
        $permission->delete();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title'   => '¡Permiso eliminado!',
            'text' => 'El permiso se ha eliminado correctamente.',
        ]);
    }

    public function render()
    {
        $permissions = Permission::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })
        ->paginate();

        return view('livewire.manage-permission', compact('permissions'));
    }
}
