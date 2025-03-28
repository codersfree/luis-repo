<div>

    <flux:breadcrumbs class="mb-8">
        <flux:breadcrumbs.item href="{{route('dashboard')}}">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item>Roles</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex justify-between">

        <div class="w-64">
            <x-wire-input placeholder="Buscar" wire:model.live="search" />
        </div>

        @can('create permission')
        
            <x-wire-button wire:click="create">
                Nuevo
            </x-wire-button>

        @endcan
    </div>

    @if ($roles->count())
        
        <div class="relative overflow-x-auto mt-4">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        @canany(['update user', 'delete user'])
                            <th scope="col" class="px-6 py-3" width="240px">
                                Edit
                            </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $role->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $role->name }}
                            </td>
                            @canany(['update user', 'delete user'])
                                <td class="px-6 py-4">
                                    
                                    @can('update permission')
                                    
                                        <x-wire-button green spinner="edit({{ $role->id }})" wire:click="edit({{ $role->id }})">
                                            Editar
                                        </x-wire-button>

                                    @endcan
            
                                    @can('delete permission')
                                    
                                        {{-- <x-wire-button red spinner="delete({{ $role->id }})" wire:click="delete({{ $role->id }})">
                                            Eliminar
                                        </x-wire-button> --}}

                                        <x-wire-button red onclick="deleteRole({{ $role->id }})">
                                            Eliminar
                                        </x-wire-button>

                                    @endcan
            
                                </td>
                            @endcanany
                        </tr>
        
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

        @if ($search)
            <div class="mt-4">
                <x-wire-alert title="No hay registros que coincidan con la busqueda" />
            </div>

        @else
            
            <div class="mt-4">
                <x-wire-alert title="No hay registros" />
            </div>

        @endif

    @endif

    <div class="mt-4">
        {{ $roles->links() }}
    </div>

    <x-wire-modal-card title="Roles" wire:model="roleForm.openModal">

        <form class="space-y-4" wire:submit="save">
    
            <x-wire-input label="Nombre" wire:model="roleForm.name" type="text" placeholder="Ingrese el nombre" />

            <flux:checkbox.group wire:model="roleForm.permissions" label="Permisos">
                @foreach ($permissions as $permission)
                    <flux:checkbox label="{{$permission->name}}" value="{{$permission->id}}" />
                @endforeach
            </flux:checkbox.group>

            <div class="flex justify-end">
                <x-wire-button blue type="save">
                    Guardar
                </x-wire-button>
            </div>
        </form>
    
    </x-wire-modal-card>

    @push('js')
        
        <script>
            function deleteRole(roleId)
            {
                document.activeElement.blur();
                
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, bórralo!",
                    cancelButtonText: "Cancelar"
                    }).then((result) => {
                    if (result.isConfirmed) {

                        //Sacar el foco del botón
                        @this.call('delete', roleId);
                    }
                });
            }
        </script>

    @endpush

</div>
