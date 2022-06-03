<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Hubs;
use App\models\admin\DeliveryRiders;
use Auth;
use Storage;
class HubController extends Controller
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
        $hubs = Hubs::orderBy('created_at','desc')->get(); 
        if(!empty($hubs))
        {
            foreach ($hubs as $key => $value) {
               $hubs[$key]->total_riders = DeliveryRiders::where('hub_id',$value->id)->count('id');
            }
        }
        return view('admin.hubs.index',compact('hubs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.hubs.create');
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
            'supervisor_name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'required|unique:hubs,email|email|max:255',
            'phone' => 'required|digits_between:8,12|unique:hubs,phone',
            'sup_phone' => 'required|digits_between:8,12|unique:hubs,sup_phone',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'password'    => 'required|min:8|confirmed',
            'sup_nid_pic' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_tin_pic' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'tl_picture'  => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_tin_no'  => 'required|max:20',
            'sup_nid_no'  => 'required|max:20',
            /*'thana'       => 'required',
            'district'    => 'required',
            'division' => 'required',*/
            'home_address' => 'required',
            'status' => 'required'
        ]);

        try{
            $user = $request->all();            
            $user['password'] = bcrypt($request->password);
            if($request->hasFile('sup_picture')) {
                $user['sup_picture'] = $request->sup_picture->store('hubs/supervisor');
            }
            if($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('hubs');
            }
            if($request->hasFile('sup_nid_pic')) {
                $user['sup_nid_pic'] = $request->sup_nid_pic->store('hubs/supervisor/nidpic');
            }
            if($request->hasFile('sup_tin_pic')) {
                $user['sup_tin_pic'] = $request->sup_tin_pic->store('hubs/supervisor/tinpic');
            }
            if($request->hasFile('sup_tin_pic')) {
                $user['tl_picture'] = $request->tl_picture->store('hubs/tlpicture');
            }
            $user = Hubs::create($user);  
            $user= Hubs::find($user->id);      
            $user->hbsid = '#HBS'.sprintf('%04d', $user->id);
            $user->save();
            return redirect()->route('admin.hubs.index')->with('flash_success','Hub Created Successfully');
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
            $hub = Hubs::findOrFail($id);
            $hub->total_riders = DeliveryRiders::where('hub_id',$hub->id)->count('id');
            return view('admin.hubs.details',compact('hub'));
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
            $hub = Hubs::findOrFail($id);
            return view('admin.hubs.edit',compact('hub'));
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
            'name' => 'required|max:255',            
            'supervisor_name' => 'required|max:255',            
            'address' => 'required|max:255',            
            'email' => 'required|unique:hubs,email,'.$id.',id|email|max:255',
            'phone' => 'required|digits_between:8,12|unique:hubs,phone,'.$id.',id',
            'sup_phone' => 'required|digits_between:8,12|unique:hubs,sup_phone,'.$id.',id',
            'sup_picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_nid_pic' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_tin_pic' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'tl_picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'sup_tin_no' => 'required|max:20',
            'sup_nid_no' => 'required|max:20',
            /*'thana'     => 'required',
            'district' => 'required',
            'division' => 'required',*/
            'home_address' => 'required',
            'status' => 'required'
        ]);
       

        try {
            $user = Hubs::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('hubs');
            }
            if($request->hasFile('sup_picture')) {
                Storage::delete($user->sup_picture);
                $user->sup_picture = $request->sup_picture->store('hubs/supervisor');
            }
            if($request->hasFile('sup_nid_pic')) {
                Storage::delete($user->sup_nid_pic);
                $user->sup_nid_pic = $request->sup_nid_pic->store('hubs/supervisor/nidpic');
            }
            if($request->hasFile('sup_nid_pic')) {
                Storage::delete($user->sup_nid_pic);
                $user->sup_nid_pic = $request->sup_nid_pic->store('hubs/supervisor/tinpic');
            }
            if($request->hasFile('tl_picture')) {
                Storage::delete($user->tl_picture);
                $user->tl_picture = $request->tl_picture->store('hubs/tlpicture');
            }

            $user->name = $request->name;
            $user->status = $request->status;
            $user->email = $request->email;            
            $user->supervisor_name = $request->supervisor_name;            
            $user->phone = $request->phone;            
            $user->sup_phone = $request->sup_phone;            
            $user->sup_tin_no = $request->sup_tin_no;            
            $user->sup_nid_no = $request->sup_nid_no;            
            $user->address = $request->address;            
           /* $user->thana = $request->thana;            
            $user->district = $request->district;            
            $user->division = $request->division;     */  
            $user->home_address = $request->home_address;  
            $user->latitude = $request->latitude;            
            $user->longitude = $request->longitude;            
            $user->save();
            return redirect()->route('admin.hubs.index')->with('flash_success', 'Hub Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Hub Not Found');
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
            $user = Hubs::findOrFail($id);
            $user->delete();
            return back()->with('flash_success', 'Hub deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Hub Not Found');
        }
    }
}
