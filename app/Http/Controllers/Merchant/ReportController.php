<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type='daily')
    {
        return view('merchant.reports.index',compact('type'));
    }


    /**
     * Display a listing of the resource earnings.
     *
     * @return \Illuminate\Http\Response
     */
    public function my_earnings(Request $request)
    {
        return view('merchant.reports.earnings');
    }



    /**
     * Display a listing of the resource earnings.
     *
     * @return \Illuminate\Http\Response
     */
    public function delivery_graph(Request $request)
    {
        return view('merchant.reports.graph');
    }


   

  
}
