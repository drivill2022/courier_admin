<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Services;
use Storage;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services=Services::get();
        return view('admin.services.index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.services.create');
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
            'name' => 'required|max:255|unique:services,name',            
            'description' => 'required',            
            'status' => 'required|in:Active,Blocked',            
            'picture' => 'required|mimes:jpeg,jpg,bmp,png|max:5242880',
           
        ]);

        try{
            $service = $request->all();            
            if($request->hasFile('picture')) {
                $service['picture'] = $request->picture->store('service');
            }
            Services::create($service);           
            return redirect()->route('admin.services.index')->with('flash_success','Page Created Successfully');
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
        $service = Services::findOrFail($id);
        return view('admin.services.show',compact('service'));
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
            $service = Services::findOrFail($id);
            return view('admin.services.edit',compact('service'));
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
            'description' => 'required',            
            'status' => 'required',            
            'name' => 'required|unique:services,name,'.$id.',id|max:255',
            'picture' => 'mimes:jpeg,jpg,bmp,png|max:5242880',

        ]);
       

        try {
            $service = Services::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($service->picture);
                $service->picture = $request->picture->store('service');
            }
            $service->name = $request->name;
            $service->description = $request->description;
            $service->status = $request->status;            
            $service->save();
            return redirect()->route('admin.services.index')->with('flash_success', 'Service Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Service Not Found');
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
            $service = Services::findOrFail($id);
            $service->delete();
            return back()->with('message', 'Service deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Service Not Found');
        }
    }
}
