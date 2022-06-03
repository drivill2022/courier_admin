<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\models\admin\PaymentMethod;
class PaymentMethodDropdown extends Component
{
    public $selected='';
    public $id='payment_method';
    public $name='payment_method';
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
        $payment_method=PaymentMethod::where('status','Active')->orderBy('name','asc')->get();
        return view('components.payment-method-dropdown',compact('payment_method'));
    }
}
