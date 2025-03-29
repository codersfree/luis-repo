<flux:navlist variant="outline">
    <flux:navlist.group :heading="__('Platform')" class="grid">

        @foreach ($items as $item)
            

            @if ($item->subItems->count())
                
                <flux:navlist.group expandable :heading="$item->name">

                    @foreach ($item->subItems as $subItem)
                        <flux:navlist.item {{-- :icon="$subItem->icon" --}} :href="$subItem->url" :current="request()->is(trim($subItem->url, '/'))" wire:navigate>
                            {{ $subItem->name }}
                        </flux:navlist.item>
                    @endforeach

                </flux:navlist.group>

            @else

                <flux:navlist.item :icon="$item->icon" :href="$item->url" :current="request()->is(trim($item->url, '/'))" wire:navigate>
                    {{ $item->name }}
                </flux:navlist.item>

            @endif

        @endforeach


    </flux:navlist.group>
</flux:navlist>