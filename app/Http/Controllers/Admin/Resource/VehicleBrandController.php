<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use App\models\admin\VehicleBrand;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
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
        $brands = VehicleBrand::latest()->get(); 
        return view('admin.vehicle.brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicle.brands.create');
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
            'name' => 'required|max:255|unique:vehicle_brands,name',
            'status' => 'required'
        ]);

        try{
            $brand = $request->all();
            VehicleBrand::create($brand);
            return redirect()->route('admin.vehicle.brands.index')->with('flash_success','Vehicle Brand Created Successfully');
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
            $brand = VehicleBrand::findOrFail($id);
            return view('admin.vehicle.brands.edit',compact('brand'));
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
            'name'=> 'required|unique:vehicle_brands,name,'.$id.',id|max:255',
            'status'=> 'required'
        ]);
        try {
            $brand = VehicleBrand::findOrFail($id);
            $brand->name = $request->name;
            $brand->status = $request->status;
            $brand->save();
            return redirect()->route('admin.vehicle.brands.index')->with('flash_success', 'Vehicle Brand Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Vehicle Brand Not Found');
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
            $type = VehicleBrand::findOrFail($id)->delete();
            return back()->with('flash_success', 'Vehicle brand deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Brand Not Found');
        }
    }
}
