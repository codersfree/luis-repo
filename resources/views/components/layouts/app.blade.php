<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
    </flux:main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('swal', data => {
                Swal.fire(data[0])
            })
        });
    </script>

    @stack('js')

</x-layouts.app.sidebar>
