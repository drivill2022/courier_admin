<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\Division;

class DivisionDropdown extends Component
{
    public $selected='';
    public $id='division';
    public $name='division';
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
        $divisions=Division::orderBy('name','asc')->get();
        return view('components.division-dropdown',['divisions'=>$divisions]);
    }
}
