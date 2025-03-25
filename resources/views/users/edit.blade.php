<x-wire-modal-card title="Editar usuario" wire:model="editUser.openModal">

    <form class="space-y-4" wire:submit="update">

        <x-wire-input label="Nombre" wire:model="editUser.name" type="text" placeholder="Ingrese el nombre" />

        <x-wire-input label="Correo" wire:model="editUser.email" type="email" placeholder="Ingrese el correo" />

        <x-wire-input label="Contraseña" wire:model="editUser.password" type="password"
            placeholder="Ingrese la contraseña" />

        <x-wire-input label="Confirmar contraseña" wire:model="editUser.password_confirmation" type="password"
            placeholder="Confirme la contraseña" />

        <div class="flex justify-end">
            <x-wire-button blue type="submit">
                Guardar
            </x-wire-button>
        </div>
    </form>

</x-wire-modal-card>