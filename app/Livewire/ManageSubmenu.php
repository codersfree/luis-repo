<?php

namespace App\Livewire;

use App\Models\SubItem;
use Livewire\Component;

class ManageSubmenu extends Component
{

    public $item;
    public $subItems;

    public $formSubItem = [
        'open' => false,
        'name' => '',
        'url' => '',
        'icon' => '',
    ];

    public $formSubItemEdit = [
        'id' => '',
        'name' => '',
        'url' => '',
        'icon' => '',
    ];

    public function mount()
    {
        $this->getSubItems();
    }

    public function getSubItems()
    {
        $this->subItems = SubItem::where('item_id', $this->item->id)
            ->orderBy('order')
            ->get();
    }

    public function store()
    {
        $this->item->subItems()->create([
            'name' => $this->formSubItem['name'],
            'url' => $this->formSubItem['url'],
            'icon' => $this->formSubItem['icon'],
        ]);

        $this->reset('formSubItem');

        $this->getSubItems();

        $this->dispatch('menuUpdated');
    }

    public function edit(SubItem $subItem)
    {
        $this->formSubItemEdit['id'] = $subItem->id;
        $this->formSubItemEdit['name'] = $subItem->name;
        $this->formSubItemEdit['url'] = $subItem->url;
        $this->formSubItemEdit['icon'] = $subItem->icon;
    }

    public function update()
    {
        $subItem = SubItem::find($this->formSubItemEdit['id']);
        $subItem->update([
            'name' => $this->formSubItemEdit['name'],
            'url' => $this->formSubItemEdit['url'],
            'icon' => $this->formSubItemEdit['icon'],
        ]);

        $this->reset('formSubItemEdit');

        $this->getSubItems();

        $this->dispatch('menuUpdated');
    }

    public function destroy(SubItem $subItem)
    {
        $subItem->delete();
        $this->getSubItems();

        $this->dispatch('menuUpdated');
    }

    public function render()
    {
        return view('livewire.manage-submenu');
    }
}
