<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\MerchantAccount;
use App\models\admin\Merchants;
use Auth;
use Storage;

class MerchantAccountController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
     {
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = MerchantAccount::with('merchant')->orderBy('created_at','desc')->get(); 
        return view('admin.merchants.accounts.index',compact('accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
        return view('admin.merchants.accounts.create',compact('merchants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [            
            'merchant' => 'required',
            'acc_holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            //'routing_name' => 'required',
        ],['acc_holder_name.required' => 'The account holder name field is required.']);

        try{
            
            $user = New MerchantAccount; 
            $user->merchant_id = $request->merchant; 
            $user->acc_holder_name = $request->acc_holder_name; 
            $user->bank_name = $request->bank_name; 
            $user->branch_name = $request->branch_name; 
            $user->account_number = $request->account_number; 
            $user->routing_name = " "; 
            $user->save(); 
            return redirect()->route('admin.merchant-account.index')->with('flash_success','Merchant Account Created Successfully');
            }
        catch (Exception $e) {
            dd($e->getMessage());
            return back()->with('flash_error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $merchant = MerchantAccount::findOrFail($id);
            return view('admin.merchants.details',compact('merchant'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $merchant_Account = MerchantAccount::findOrFail($id);
            $merchants=Merchants::where('status','Active')->orderBy('name','asc')->get();
            return view('admin.merchants.accounts.edit',compact('merchant_Account','merchants'));
        } catch (ModelNotFoundException $e) {
            return $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [            
            'merchant' => 'required',
            'acc_holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'account_number' => 'required',
            //'routing_name' => 'required',
        ],['acc_holder_name.required' => 'The account holder name field is required.']);

        try{
            
            $user = MerchantAccount::findOrFail($id);
            $user->merchant_id = $request->merchant; 
            $user->acc_holder_name = $request->acc_holder_name; 
            $user->bank_name = $request->bank_name; 
            $user->branch_name = $request->branch_name; 
            $user->account_number = $request->account_number; 
            $user->routing_name = " "; 
            $user->save(); 
            return redirect()->route('admin.merchant-account.index')->with('flash_success','Merchant Account Updated Successfully');
            }

        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Merchant Not Found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try {
            $user = MerchantAccount::findOrFail($id);
            $user->delete();
            return back()->with('flash_success', 'Merchant Account deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Merchant Not Found');
        }
    }
}
