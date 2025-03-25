<div>

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

    @if ($permissions->count())
        
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
                    @foreach ($permissions as $permission)
                    
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $permission->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $permission->name }}
                            </td>
                            @canany(['update user', 'delete user'])
                                <td class="px-6 py-4">
                                    
                                    @can('update permission')
                                        <x-wire-button green spinner="edit({{ $permission->id }})" wire:click="edit({{ $permission->id }})">
                                            Editar
                                        </x-wire-button>
                                    @endcan
            
                                    @can('delete permission')
                                        {{-- <x-wire-button red spinner="delete({{ $permission->id }})"  wire:click="delete({{ $permission->id }})">
                                            Eliminar
                                        </x-wire-button> --}}
                                        <x-wire-button red onclick="deletePermission({{ $permission->id }})">
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
        {{ $permissions->links() }}
    </div>

    <x-wire-modal-card title="Permisos" wire:model="permissionForm.openModal">

        <form class="space-y-4" wire:submit="save">
    
            <x-wire-input label="Nombre" wire:model="permissionForm.name" type="text" placeholder="Ingrese el nombre" />

            <div class="flex justify-end">
                <x-wire-button blue type="save">
                    Guardar
                </x-wire-button>
            </div>
        </form>
    
    </x-wire-modal-card>


    @push('js')
        
        <script>
            function deletePermission(permissionId)
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
                        @this.call('delete', permissionId);
                    }
                });
            }
        </script>

    @endpush

</div>
