<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\ProductType;

class ProductTypeDropdown extends Component
{
    public $selected=array();
    public $single='';
    public $id='product_type';
    public $name='product_type[]';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selected='',$name='',$id='',$single='')
    {
        $this->selected=explode(',',$selected);
        $this->id=$id?:$this->id;
        $this->name=$name?:$this->name;
        $this->single=$single?:$this->single;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {   
        $product_types=ProductType::where('status','Active')->orderBy('name','asc')->get();
        return view('components.product-type-dropdown',compact('product_types'));
    }
}
