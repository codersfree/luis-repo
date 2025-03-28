<flux:navlist variant="outline">
    <flux:navlist.group :heading="__('Platform')" class="grid">

        @foreach ($items as $item)
            
            <flux:navlist.item :icon="$item->icon" :href="$item->url" :current="request()->is(trim($item->url, '/'))" wire:navigate>
                {{ $item->name }}
            </flux:navlist.item>

        @endforeach


    </flux:navlist.group>
</flux:navlist>