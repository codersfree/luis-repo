<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\SubItem;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageMenu extends Component
{

    public $items;

    public $formItem = [
        'open' => false,
        'name' => '',
        'url' => '',
        'icon' => '',
    ];

    public $formItemEdit = [
        'id' => '',
        'name' => '',
        'url' => '',
        'icon' => '',
    ];

    public function mount()
    {
        $this->getItems();
    }

    protected function rules()
    {
        return [
            'formItem.name' => 'required',
            'formItem.url' => 'required',
            'formItem.icon' => 'required',
        ];
    }

    public function validationAttributes()
    {
        return [
            'formItem.name' => 'nombre',
            'formItem.url' => 'url',
            'formItem.icon' => 'icon',
        ];
    }


    public function getItems()
    {
        $this->items = Item::orderBy('order')
            ->get();
    }


    public function storeItem()
    {
        $this->validate();
        Item::create($this->formItem);
        $this->reset('formItem');

        $this->getItems();

        $this->dispatch('menuUpdated');
    }

    public function editItem(Item $id)
    {
        $this->formItemEdit = [
            'id' => $id->id,
            'name' => $id->name,
            'url' => $id->url,
            'icon' => $id->icon,
        ];
    }


    public function updateItem()
    {
        $this->validate([
            'formItemEdit.name' => 'required',
            'formItemEdit.url' => 'required',
            'formItemEdit.icon' => 'required',
        ]);

        Item::find($this->formItemEdit['id'])
            ->update($this->formItemEdit);

        $this->reset('formItemEdit');

        $this->getItems();
        
        $this->dispatch('menuUpdated');
    }

    public function destroyItem(Item $item)
    {
        $item->delete();

        $this->getItems();

        $this->dispatch('menuUpdated');
    }


    public function sortItems($sorts)
    {

        foreach ($sorts as $position => $itemId) {

            Item::find($itemId)->update([
                'order' => $position + 1
            ]);
        }

        $this->getItems();

        $this->dispatch('menuUpdated');
    }

    #[On('sortSubItems')]
    public function sortSubItems($sorts, $itemId)
    {
        foreach ($sorts as $position => $subItemId) {

            SubItem::find($subItemId)->update([
                'position' => $position + 1,
                'item_id' => $itemId
            ]);
        }

        $this->dispatch('menuUpdated');
    }

    public function render()
    {
        return view('livewire.manage-menu');
    }
}
