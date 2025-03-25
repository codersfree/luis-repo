<div>

    <div class="flex justify-between">

        <div class="w-64">
            <x-wire-input placeholder="Buscar" wire:model.live="search" />
        </div>

        @can('create user')
            <x-wire-button wire:click="create">
                Nuevo
            </x-wire-button>
        @endcan

    </div>

    @if ($users->count())
        
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
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        @canany(['update user', 'delete user'])
                            <th scope="col" class="px-6 py-3" width="240px">
                                Edit
                            </th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $user->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $user->email }}
                            </td>

                            @canany(['update user', 'delete user'])
                                <td class="px-6 py-4">
                                    
                                    @can('update user')
                                        <x-wire-button green spinner="edit({{ $user->id }})" wire:click="edit({{ $user->id }})">
                                            Editar
                                        </x-wire-button>
                                    @endcan

                                    @can('delete user')
                                        {{-- <x-wire-button red wire:click="delete({{ $user->id }})">
                                            Eliminar
                                        </x-wire-button> --}}
                                        <x-wire-button red onclick="deleteUser({{ $user->id }})">
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

        <div class="mt-4">
            <x-wire-alert title="No hay registros que coincidan con la busqueda" />
        </div>

    @endif

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <x-wire-modal-card title="Usuario" wire:model="userForm.openModal">

        <form class="space-y-4" wire:submit="save">
    
            <x-wire-input label="Nombre" wire:model="userForm.name" type="text" placeholder="Ingrese el nombre" />
    
            <x-wire-input label="Correo" wire:model="userForm.email" type="email" placeholder="Ingrese el correo" />
    
            <x-wire-input label="Contraseña" wire:model="userForm.password" type="password"
                placeholder="Ingrese la contraseña" />
    
            <x-wire-input label="Confirmar contraseña" wire:model="userForm.password_confirmation" type="password"
                placeholder="Confirme la contraseña" />
    
            <flux:checkbox.group wire:model="userForm.roles" label="Roles">

                @foreach ($roles as $role)
                    <flux:checkbox label="{{$role->name}}" value="{{$role->id}}" />
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
            function deleteUser(userId)
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
                        @this.call('delete', userId);
                    }
                });
            }
        </script>

    @endpush

</div>
