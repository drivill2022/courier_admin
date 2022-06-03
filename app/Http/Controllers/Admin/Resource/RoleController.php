<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Role;
use App\models\admin\Permission;
use Auth;
class RoleController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::orderBy('id','desc')->get();     
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::orderBy('id','desc')->get();
        return view('admin.roles.create', compact('permissions'));
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
            'name' => 'required|unique:roles,name|max:255',           
            'description' => 'required|max:255',
            'permissions' => 'required',
        ]);

        try{
            $role = $request->all();    
            /*if(!in_array('1', $temp['permissions'])){         
            $role['permissions']= array_merge($role['permissions'],['2','27','28','29','106']); 
            } */                  
            $permissionsIds=array_unique($role['permissions']); 
            sort($permissionsIds);
            $role['permission_ids']=implode(',', $permissionsIds);
            $role = Role::create($role);
            $role->permissions()->attach($permissionsIds);          
            return redirect()->route('admin.roles.index')->with('flash_success','Role Created Successfully');
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
        $role = Role::findOrFail($id);
        return view('admin.roles.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $role->permission_ids=explode(',', $role->permission_ids);     
        $permissions=Permission::orderBy('id','desc')->get();
        return view('admin.roles.edit',compact('role','permissions'));
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
            'name' => 'required|unique:roles,name,'.$id.',id|max:255',                  
            'description' => 'required|max:255',
            'permissions' => 'required',
        ]);
       

        try {
            $role = Role::findOrFail($id);
            $temp=$request->all();   
            /*if(!in_array('1', $temp['permissions'])){
             $temp['permissions']=array_merge($temp['permissions'],['2','27','28','29','106']);   
            }*/
            $permissionsIds=array_unique($temp['permissions']); 
            sort($permissionsIds);    
            $role->name = $request->name;
            $role->description = $request->description;   
            $role->permission_ids=implode(',', $permissionsIds);             
            $role->save();
            $role->permissions()->detach();            
            $role->permissions()->attach($permissionsIds);
            return redirect()->route('admin.roles.index')->with('flash_success', 'Role Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Role Not Found');
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
            $user = Role::findOrFail($id);
            $user->delete();
            return back()->with('message', 'Role deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Role Not Found');
        }
    }}
