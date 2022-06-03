<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use App\models\admin\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
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
        $models = VehicleModel::latest()->get(); 
        return view('admin.vehicle.models.index',compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicle.models.create');
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
            'name' => 'required|max:255|unique:vehicle_models,name',
            'status' => 'required'
        ]);

        try{
            $model = $request->all();
            VehicleModel::create($model);
            return redirect()->route('admin.vehicle.models.index')->with('flash_success','Vehicle Model Created Successfully');
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
            $model = VehicleModel::findOrFail($id);
            return view('admin.vehicle.models.edit',compact('model'));
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
            'name'=> 'required|unique:vehicle_models,name,'.$id.',id|max:255',
            'status'=> 'required'
        ]);
        try {
            $model = VehicleModel::findOrFail($id);
            $model->name = $request->name;
            $model->status = $request->status;
            $model->save();
            return redirect()->route('admin.vehicle.models.index')->with('flash_success', 'Vehicle Model Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Vehicle Model Not Found');
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
            $type = VehicleModel::findOrFail($id)->delete();
            return back()->with('flash_success', 'Vehicle model deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Model Not Found');
        }
    }
}
