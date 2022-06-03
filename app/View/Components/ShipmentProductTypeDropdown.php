<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\ProductType;

class ShipmentProductTypeDropdown extends Component
{
    public $selected='';
    public $id='product_type';
    public $name='product_type';
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
        /*$product_types=[
            ['id'=>1,'name'=>'Documents'],
            ['id'=>2,'name'=>'Heavy Weight']
        ];*/
        $product_types=ProductType::where('status','Active')->orderBy('name','asc')->get();
        return view('components.shipment-product-type-dropdown',compact('product_types'));
    }
}
