<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\Thana;
class ThanaDropdown extends Component
{
     public $selected='';
     public $id='thana';
     public $name='thana';
     public $district=0;
        /**
         * Create a new component instance.
         *
         * @return void
         */
        public function __construct($district=0,$selected='',$name='',$id='')
        {
            $this->district=$district;
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
        $thanas = Thana::where('district_id',$this->district)->orderBy('name','asc')->get();
        return view('components.thana-dropdown',['thanas'=>$thanas]);
    }
}
