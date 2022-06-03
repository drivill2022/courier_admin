<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\models\admin\Seller;
use App\models\admin\PaymentMethod;
use App\models\admin\ProductType;
use Illuminate\Http\Request;
use Auth;
use Storage;
class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
       return view('seller.dashboard');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function edit_profile()
    {
        $payment_method=PaymentMethod::where('status','Active')->orderBy('name','asc')->get();
        $product_type=ProductType::where('status','Active')->orderBy('name','asc')->get();
        return view('seller.account.edit-profile',compact('payment_method','product_type'));
    }  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('seller.account.profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function profile_update(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        $this->validate($request, [                      
            'name'=> 'required|max:255',            
            'address'=> 'required|max:255',            
            'email'=> 'required|unique:sellers,email,'.$seller->id.',id|email|max:255',
            'mobile'=> 'required|digits_between:8,12|unique:sellers,mobile,'.$seller->id.',id',
            'picture'=> 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'business_name'=> 'required|max:255',            
            'nid_no'=> 'required|max:255', 
            'payment_id'=> 'required',
            'product_type'=> 'required',
            'thana'=> 'required',
            'district'=> 'required',
            'division'=> 'required',
        ]);

        try{            
            if($request->hasFile('picture')) {
                Storage::delete($seller->picture);
                $seller->picture = $request->picture->store('seller/profile');
            }
            if($request->hasFile('business_logo')) {
                Storage::delete($seller->business_logo);
                $seller->business_logo = $request->business_logo->store('seller/business-logo');
            }

            $seller->name = $request->name;
            $seller->email = $request->email;            
            $seller->mobile = $request->mobile;            
            $seller->address = $request->address;            
            $seller->fb_page = $request->fb_page;            
            $seller->thana = $request->thana;            
            $seller->district = $request->district;            
            $seller->division = $request->division;            
            $seller->nid_no = $request->nid_no;            
            $seller->payment_id = $request->payment_id;            
            $seller->save();
            $permissionsIds=array_unique($request->product_type);
            $seller->product_type()->detach();            
            $seller->product_type()->attach($permissionsIds);
            return redirect()->back()->with('flash_success','Profile Updated Successfully');
        }
        catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password()
    {
        return view('seller.account.change-password');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Provider  $provider
     * @return \Illuminate\Http\Response
     */
    public function password_update(Request $request)
    {
        $this->validate($request,[
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        try {

           $Seller = Seller::find(Auth::guard('seller')->user()->id);

            if(password_verify($request->old_password, $Seller->password))
            {
                if($request->old_password==$request->password)
                {
                    return back()->with('flash_error','New password could not be same as current password!');
                }
                $Seller->password = bcrypt($request->password);
                $Seller->save();
                return redirect()->back()->with('flash_success','Password has been updated successfully');
            }else{
                return back()->with('flash_error','Old password are incorrect!');
            }
        } catch (Exception $e) {
             return back()->with('flash_error','Something Went Wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
