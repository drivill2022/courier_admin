<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\SellerItemCategories;
use Storage;
class ItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=SellerItemCategories::with('parent')->get();
        return view('admin.sellers.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=SellerItemCategories::orderBy('name','asc')->get();
        return view('admin.sellers.category.create',compact('categories'));
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
            'name' => 'required|unique:seller_item_categories,name|max:255',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png,webp|max:5242880',
            'parent_category_id' => 'required_if:type,accepted',
            'status'=>'required'
        ]);

        try{
            $category = $request->all();            
            if($request->hasFile('picture')) {
                $category['picture'] = $request->picture->store('seller/category');
            }
            $category = SellerItemCategories::create($category);           
            return redirect()->route('admin.sellers.categories.index')->with('flash_success','Category Created Successfully');
            }
        catch (Exception $e) {
            return back()->with('flash_error', $e->getMessage());
        }
    }

    /**
     * function used to fetch sub category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $ct=SellerItemCategories::where('parent_category_id',$id)->where('status', 'Active')->get();
        $op='<option value=""></option>';
        if($ct->count()==0){
            return $op='<option value="">---No Sub Category In Selected Category----</option>';
        }
        foreach($ct as $c){
            $op.='<option value="'.$c->id.'">'.ucwords($c->name).'</option>';
        }
        return $op;
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
            $category = SellerItemCategories::findOrFail($id);
            $categories=SellerItemCategories::where('id','<>',$id)->orderBy('name','asc')->get();
            return view('admin.sellers.category.edit',compact('category','categories'));
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
            'name'=> 'required|unique:seller_item_categories,name,'.$id.',id|max:255',
            'picture' => 'mimes:jpeg,jpg,bmp,png,webp|max:5242880',           
            'parent_category_id' => 'required_if:type,accepted', 
            'status'=>'required'          
        ]);
       

        try {
            $category = SellerItemCategories::findOrFail($id);
            if($request->hasFile('picture')) {
                Storage::delete($category->picture);
                $category->picture = $request->picture->store('seller/category');
            }

            $category->name = $request->name;
            $category->status = $request->status;
            $category->parent_category_id =null;
            if($request->parent_category_id && $request->type){
                $category->parent_category_id = $request->parent_category_id;
            }
            $category->save();
            return redirect()->route('admin.sellers.categories.index')->with('flash_success', 'Category Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Category Not Found');
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
        try{
            $category= SellerItemCategories::findOrFail($id);
            Storage::delete($category->picture);
            Products::where('category_id',$category->id)->delete();
            $category->delete();
            return redirect()->route('admin.sellers.categories.index')->with('flash_success','Category Deleted Successfully');
           
        }catch(Exception $e){
            return back()->with('flash_error', $e->getMessage());
        }
    }

  
}
