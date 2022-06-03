<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use App\models\admin\Seller;
use App\models\admin\PaymentMethod;
use App\models\admin\ProductType;
use Illuminate\Http\Request;
use Storage;
class SellerController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct() {
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::orderBy('created_at','desc')->get(); 
        return view('admin.sellers.index',compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $payment_method=PaymentMethod::where('status','Active')->orderBy('name','asc')->get();
        $product_type=ProductType::where('status','Active')->orderBy('name','asc')->get();
        return view('admin.sellers.create', compact('payment_method','product_type'));
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
            'name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'required|unique:sellers,email|email|max:255',
            'mobile' => 'digits_between:8,12|unique:sellers,mobile',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:8|confirmed',
            'business_name' => 'required|max:255',            
            'nid_no' => 'required|max:255',            
            'business_logo' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'fb_page' => 'required',
            'payment_id' => 'required',
            'product_type' => 'required',
            'thana' => 'required',
            'district' => 'required',
            'division' => 'required',
            'status' => 'required'
        ]);

        try{
            $seller = $request->all();            
            $seller['password'] = bcrypt($request->password);
            if($request->hasFile('picture')) {
                $seller['picture'] = $request->picture->store('seller/profile');
            }
            if($request->hasFile('business_logo')) {
                $seller['business_logo'] = $request->business_logo->store('seller/business-logo');
            }
            $product_type=array_unique($request->product_type);
            unset($request->product_type);
            $seller = Seller::create($seller); 
            $seller->product_type()->attach($product_type);
            $seller= Seller::find($seller->id);      
            $seller->slid = '#SLR'.sprintf('%03d', $seller->id);
            $seller->save();
            return redirect()->route('admin.sellers.index')->with('flash_success','Seller Created Successfully');
            }
        catch (Exception $e) {
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
            $seller = Seller::findOrFail($id);
            return view('admin.sellers.details',compact('seller'));
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
            $seller = Seller::findOrFail($id);
            $payment_method=PaymentMethod::where('status','Active')->orderBy('name','asc')->get();
            $product_type=ProductType::where('status','Active')->orderBy('name','asc')->get();
            return view('admin.sellers.edit',compact('seller','payment_method','product_type'));
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
            'name'=> 'required|max:255',            
            'address'=> 'required|max:255',            
            'email'=> 'required|unique:sellers,email,'.$id.',id|email|max:255',
            'mobile'=> 'required|digits_between:8,12|unique:sellers,mobile,'.$id.',id',
            'picture'=> 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'business_name'=> 'required|max:255',            
            'nid_no'=> 'required|max:255', 
            'payment_id'=> 'required',
            'product_type'=> 'required',
            'thana'=> 'required',
            'district'=> 'required',
            'division'=> 'required',
            'status'=> 'required'
        ]);
        try {
            $user = Seller::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('seller/profile');
            }
            if($request->hasFile('business_logo')) {
                Storage::delete($user->business_logo);
                $user->business_logo = $request->business_logo->store('seller/business-logo');
            }

            $user->name = $request->name;
            $user->status = $request->status;
            $user->email = $request->email;            
            $user->mobile = $request->mobile;            
            $user->address = $request->address;            
            $user->fb_page = $request->fb_page;            
            $user->thana = $request->thana;            
            $user->district = $request->district;            
            $user->division = $request->division;            
            $user->nid_no = $request->nid_no;            
            $user->payment_id = $request->payment_id;            
            $user->save();
            $permissionsIds=array_unique($request->product_type);
            $user->product_type()->detach();            
            $user->product_type()->attach($permissionsIds);
            return redirect()->route('admin.sellers.index')->with('flash_success', 'Seller Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Seller Not Found');
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
            $user = Seller::findOrFail($id);
            Storage::delete($user->picture);
            Storage::delete($user->business_logo);
            $user->delete();
            return back()->with('flash_success', 'Seller deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Seller Not Found');
        }
    }
}
