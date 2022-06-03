<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use App\models\admin\VehicleRegion;
use Illuminate\Http\Request;

class VehicleRegionController extends Controller
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
        $regions = VehicleRegion::latest()->get(); 
        return view('admin.vehicle.regions.index',compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicle.regions.create');
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
            'name' => 'required|max:255|unique:vehicle_regions,name',
            'status' => 'required'
        ]);

        try{
            $model = $request->all();
            VehicleRegion::create($model);
            return redirect()->route('admin.vehicle.regions.index')->with('flash_success','Vehicle Region Created Successfully');
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
            $region = VehicleRegion::findOrFail($id);
            return view('admin.vehicle.regions.edit',compact('region'));
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
            'name'=> 'required|unique:vehicle_regions,name,'.$id.',id|max:255',
            'status'=> 'required'
        ]);
        try {
            $region = VehicleRegion::findOrFail($id);
            $region->name = $request->name;
            $region->status = $request->status;
            $region->save();
            return redirect()->route('admin.vehicle.regions.index')->with('flash_success', 'Vehicle Region Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Vehicle Region Not Found');
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
            $type = VehicleRegion::findOrFail($id)->delete();
            return back()->with('flash_success', 'Vehicle Region deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Region Not Found');
        }
    }
}
