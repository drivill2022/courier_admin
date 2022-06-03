<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Pages;

class WebController extends Controller
{
  
   public function home()
    {
        return view('web.home');
    }
    public function privacyPolicy()
    {
        $privacy_policy = Pages::find(5);
        return view('web.privacy-policy',compact('privacy_policy'));
    }
    public function termsOfUse()
    {
        $terms_of_use = Pages::find(4);
        return view('web.terms-of-use',compact('terms_of_use'));
    }
}