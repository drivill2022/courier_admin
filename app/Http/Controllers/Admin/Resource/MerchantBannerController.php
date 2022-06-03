<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\MerchantBanner;
use Auth;
use Storage;

class MerchantBannerController extends Controller
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
        $banners = MerchantBanner::orderBy('created_at','desc')->get(); 
        return view('admin.merchants.banners.index',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.merchants.banners.create');
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
            'image' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880|dimensions:max_width=1125,max_height=300',
        ]);

        try{
            if($request->hasFile('image')) {
                $user['image'] = $request->image->store('merchant/banner');
            }
            $user = MerchantBanner::create($user);  
            return redirect()->route('admin.merchant-banners.index')->with('flash_success','Merchant Banner Created Successfully');
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
            $merchant = MerchantBanner::findOrFail($id);
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
            $banner = MerchantBanner::findOrFail($id);
            return view('admin.merchants.banners.edit',compact('banner'));
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
            'image' => 'mimes:jpeg,jpg,bmp,png|max:5242880|dimensions:max_width=1125,max_height=300',
        ]);
        try {
             $banner = MerchantBanner::findOrFail($id);
            if($request->hasFile('image')) {
                Storage::delete($banner->image);
                $banner->image = $request->image->store('merchant/banner');
            }
            
            $banner->save();
            return redirect()->route('admin.merchant-banners.index')->with('flash_success', 'Merchant Banner Updated Successfully');    
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
            $user = MerchantBanner::findOrFail($id);
            $user->delete();
            return back()->with('flash_success', 'Merchant Banner deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Merchant Not Found');
        }
    }
}
