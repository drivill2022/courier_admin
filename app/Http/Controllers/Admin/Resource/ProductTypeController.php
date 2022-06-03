<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\ProductType;

class ProductTypeController extends Controller
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
        $types = ProductType::latest()->get(); 
        return view('admin.sellers.product-type.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sellers.product-type.create');
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
            'name' => 'required|max:255|unique:product_types,name',
            'status' => 'required'
        ]);

        try{
            $type = $request->all();
            ProductType::create($type);
            return redirect()->route('admin.product-types.index')->with('flash_success','Type Created Successfully');
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
            $type = ProductType::findOrFail($id);
            return view('admin.sellers.product-type.edit',compact('type'));
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
            'name'=> 'required|unique:product_types,name,'.$id.',id|max:255',
            'status'=> 'required'
        ]);
        try {
            $type = ProductType::findOrFail($id);
            $type->name = $request->name;
            $type->status = $request->status;
            $type->save();
            return redirect()->route('admin.product-types.index')->with('flash_success', 'Type Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Type Not Found');
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
            $type = ProductType::findOrFail($id)->delete();
            return back()->with('flash_success', 'Type deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Type Not Found');
        }
    }
}
