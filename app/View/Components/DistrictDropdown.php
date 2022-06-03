<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\District;
class DistrictDropdown extends Component
{
     public $selected='';
     public $id='district';
     public $name='district';
     public $division=0;
        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($division=0,$selected='',$name='',$id='')
        {
            $this->division=$division;
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
        $districts = District::where('division_id',$this->division)->orderBy('name','asc')->get();
        return view('components.district-dropdown',['districts'=>$districts]);
    }
}
