<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\admin\Admin;
use App\models\admin\Role;
use Auth;
use Storage;
use Illuminate\Validation\Rule;

class AdminUser extends Controller
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
        $users=Admin::has('role')->where('id','<>',Auth::guard('admin')->user()->id)->orderBy('id','desc')->get(); 
        return view('admin.subadmin.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles=Role::all();
        return view('admin.subadmin.create',compact('roles'));
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
            //'email' => 'required|unique:admins,email|email|max:255',
            'email' => ['required', Rule::unique('admins')->whereNull('deleted_at')],
            //'mobile' => 'digits_between:10,10|unique:admins,mobile',
            'mobile' => ['required','digits_between:10,10', Rule::unique('admins')->whereNull('deleted_at')],
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|numeric|exists:roles,id',
        ]);

        try{
            $user = $request->all();            
            $user['password'] = bcrypt($request->password);
            if($request->hasFile('picture')) {
                $user['picture'] = $request->picture->store('admin/profile');
            }
            $user = Admin::create($user);           
            return redirect()->route('admin.sub-admins.index')->with('flash_success','User Created Successfully');
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
        $user = Admin::findOrFail($id);
        return view('admin.subadmin.show',compact('user'));
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
            $user = Admin::findOrFail($id);
            $roles=Role::all();
            return view('admin.subadmin.edit',compact('user','roles'));
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
            'address' => 'required|max:255',            
            //'email' => 'required|unique:admins,email,'.$id.',id|email|max:255',
            'email' => ['required', Rule::unique('admins')->ignore($id)->whereNull('deleted_at')],
            //'mobile' => 'required|digits_between:10,10|unique:admins,mobile,'.$id.',id',
            'mobile' => ['required','digits_between:10,10', Rule::unique('admins')->ignore($id)->whereNull('deleted_at')],
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',            
            'role_id' => 'required|numeric|exists:roles,id',
        ]);
       

        try {
            $user = Admin::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($user->picture);
                $user->picture = $request->picture->store('admin/profile');
            }

            $user->name = $request->name;
            $user->role_id = $request->role_id;
            $user->email = $request->email;            
            $user->mobile = $request->mobile;            
            $user->address = $request->address;            
            $user->save();
            return redirect()->route('admin.sub-admins.index')->with('flash_success', 'User Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'User Not Found');
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
            $user = Admin::findOrFail($id);
            $user->delete();
            return back()->with('message', 'User deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }
}
