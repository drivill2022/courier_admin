<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\models\admin\Permission;
use Auth;
class PermissionController extends Controller
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
        $permissions=Permission::get();     
        return view('admin.permission.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.create');
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
            'name' => 'required|unique:permissions,name|max:255',           
            'slug' => 'required|max:255'
        ]);

        try{
            $permission = $request->all();         
            $permission = Permission::create($permission);
            return redirect()->route('admin.permissions.index')->with('flash_success','Permission Created Successfully');
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
        $permission = Permission::findOrFail($id);
        return view('admin.permission.show',compact('permission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{         
        $permission = Permission::findOrFail($id);       
        return view('admin.permission.edit',compact('permission'));
       }catch(ModelNotFoundException $m){

        return redirect()->back()->with('flash_error',$m->getMessage());
       }catch(Exception $e){
        return back()->with('flash_error',$e->getMessage());
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
            'name' => 'required|unique:permissions,name,'.$id.',id|max:255',                  
            'slug' => 'required|max:255'
           
        ]);
       

        try {
            $permission = Permission::findOrFail($id);  
            $permission->name = $request->name;
            $permission->slug = $request->slug;                         
            $permission->save();           
            return redirect()->route('admin.permissions.index')->with('flash_success', 'Permission Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Permission Not Found');
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
            $user = Permission::findOrFail($id);
            $user->delete();
            return back()->with('message', 'Permission deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Permission Not Found');
        }
    }
}
