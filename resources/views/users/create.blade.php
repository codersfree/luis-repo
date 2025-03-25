<x-wire-modal-card title="Nuevo usuario" name="userModal" wire:model="userForm.openModal">

    <form class="space-y-4" wire:submit="store">

        <x-wire-input label="Nombre" wire:model="userForm.name" type="text" placeholder="Ingrese el nombre" />

        <x-wire-input label="Correo" wire:model="userForm.email" type="email" placeholder="Ingrese el correo" />

        <x-wire-input label="Contraseña" wire:model="userForm.password" type="password"
            placeholder="Ingrese la contraseña" />

        <x-wire-input label="Confirmar contraseña" wire:model="userForm.password_confirmation" type="password"
            placeholder="Confirme la contraseña" />

        <div class="flex justify-end">
            <x-wire-button blue type="save">
                Guardar
            </x-wire-button>
        </div>
    </form>

</x-wire-modal-card>