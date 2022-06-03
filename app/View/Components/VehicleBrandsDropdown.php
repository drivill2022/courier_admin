<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\VehicleBrand;
class VehicleBrandsDropdown extends Component
{
    public $selected='';
    public $id='brand';
    public $name='brand';
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
        $brands=VehicleBrand::where('status','Active')->orderBy('name','asc')->get();
        return view('components.vehicle-brands-dropdown',['brands'=>$brands]);
    }
}
