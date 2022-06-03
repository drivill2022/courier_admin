<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use App\models\admin\VehicleCategories;
use Illuminate\Http\Request;

class VehicleCategoryController extends Controller
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
        $categories = VehicleCategories::latest()->get(); 
        return view('admin.vehicle.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.vehicle.category.create');
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
            'name' => 'required|max:255|unique:vehicle_categories,name',
            'status' => 'required'
        ]);

        try{
            $category = $request->all();
            VehicleCategories::create($category);
            return redirect()->route('admin.vehicle.categories.index')->with('flash_success','Vehicle Category Created Successfully');
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
            $category = VehicleCategories::findOrFail($id);
            return view('admin.vehicle.category.edit',compact('category'));
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
            'name'=> 'required|unique:vehicle_categories,name,'.$id.',id|max:255',
            'status'=> 'required'
        ]);
        try {
            $category = VehicleCategories::findOrFail($id);
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();
            return redirect()->route('admin.vehicle.categories.index')->with('flash_success', 'Vehicle Category Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Vehicle Category Not Found');
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
            VehicleCategories::findOrFail($id)->delete();
            return back()->with('flash_success', 'Vehicle Category deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Category Not Found');
        }
    }
}
