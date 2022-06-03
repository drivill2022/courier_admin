<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeliveryTypeDropdown extends Component
{
    public $selected='';
    public $id='shipment_type';
    public $name='shipment_type';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected='',$name='',$id='')
    {
        $this->selected=$selected;
        $this->id=$id?:$this->id;
        $this->name=$name?:$this->name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $shipment_types=[
            ['id'=>1,'name'=>'Standard Delivery'],
            ['id'=>2,'name'=>'Express Delivery']
        ];
        return view('components.delivery-type-dropdown',compact('shipment_types'));
    }
}
