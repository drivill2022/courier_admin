<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\SellerItem;
use App\models\admin\Seller;
use App\models\SellerItemCategories;
use App\models\admin\ProductType;
use Storage;
use Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller=Auth::guard('seller')->user()->id;
        $items=SellerItem::where('seller_id',$seller)->latest()->get();
        return view('seller.items.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories=SellerItemCategories::orderBy('name','asc')->get();
        $ptypes=ProductType::orderBy('name','asc')->get();
        return view('seller.items.create',compact('categories','ptypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller=Auth::guard('seller')->user()->id;
        $this->validate($request, [            
            'name' => 'required|unique:seller_items,name,NULL,id,seller_id,'.$seller.'|max:255',
            'picture' => 'required|mimes:jpeg,jpg,bmp,png,webp|max:5242880',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'product_type' => 'required',
            'price'=>'required'
        ]);

        try{
            $item = $request->all();  
            if(!$request->add_more){
              $item['weight'] = $item['length'] = $item['size'] =$item['color']=null;
            }          
            if($request->hasFile('picture')) {
                $item['picture'] = $request->picture->store('seller/items');
            }
            $item = SellerItem::create($item);           
            return redirect()->route('seller.items.index',$seller)->with('flash_success','Item Created Successfully');
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
            $seller=Auth::guard('seller')->user()->id;
            $item = SellerItem::where('id',$id)->where('seller_id',$seller)->firstOrFail();
            return view('seller.items.details',compact('item'));
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
           $seller=Auth::guard('seller')->user()->id;
           $item = SellerItem::where('id',$id)->where('seller_id',$seller)->firstOrFail();
            $categories=SellerItemCategories::orderBy('name','asc')->get();
            $ptypes=ProductType::orderBy('name','asc')->get();
            return view('seller.items.edit',compact('item','ptypes','categories'));
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
    public function update(Request $request,$id)
    {
         $seller=Auth::guard('seller')->user()->id;
        $this->validate($request, [                      
            'name' => 'required|unique:seller_items,name,'.$id.',id,seller_id,'.$seller.'|max:255',
            'picture' => 'mimes:jpeg,jpg,bmp,png,webp|max:5242880',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'product_type' => 'required',
            'price'=>'required'          
        ]);
       

        try {
            $item = SellerItem::where('id',$id)->where('seller_id',$seller)->firstOrFail();
            if($request->hasFile('picture')) {
                Storage::delete($item->picture);
                $item->picture = $request->picture->store('seller/items');
            }

            $item->name = $request->name;
            $item->price = $request->price;
            $item->status = $request->status;
            $item->weight = $item->length = $item->size =$item->color=null;
            if($request->add_more){
                $item->weight = $request->weight;
                $item->color = $request->color;
                $item->length = $request->length;
                $item->size =$request->size;
            }
            $item->category_id =$request->category_id;
            $item->product_type =$request->product_type;
            $item->sub_category_id = $request->sub_category_id?:null;
            $item->save();
            return redirect()->route('seller.items.index',$seller)->with('flash_success', 'Item Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Item Not Found');
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
            $seller=Auth::guard('seller')->user()->id;
            $item = SellerItem::where('id',$id)->where('seller_id',$seller)->firstOrFail();
            Storage::delete($item->picture);
            $item->delete();
            return redirect()->route('seller.items.index',$seller)->with('flash_success','Item Deleted Successfully');
        }catch(Exception $e){
            return back()->with('flash_error', $e->getMessage());
        }
    }



    /**
    * function used to fetch sub category.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function subcategory($id)
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
  
}
