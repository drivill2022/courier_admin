<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\SellerItem;
use App\models\admin\Seller;
use App\models\SellerItemCategories;
use App\models\admin\ProductType;
use Storage;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($seller)
    {
        $items=SellerItem::where('seller_id',$seller)->latest()->get();
        $seller=Seller::find($seller);
        return view('admin.sellers.items.index',compact('items','seller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($seller)
    {
        $seller=Seller::find($seller);
        $categories=SellerItemCategories::orderBy('name','asc')->get();
        $ptypes=ProductType::orderBy('name','asc')->get();
        return view('admin.sellers.items.create',compact('seller','categories','ptypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$seller)
    {
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
            return redirect()->route('admin.sellers.items.index',$seller)->with('flash_success','Item Created Successfully');
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
    public function show($seller,$id)
    {
       try {
            $item = SellerItem::findOrFail($id);
            return view('admin.sellers.items.details',compact('item'));
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
    public function edit($seller,$id)
    {
        try {
            $item = SellerItem::findOrFail($id);
            $categories=SellerItemCategories::orderBy('name','asc')->get();
            $ptypes=ProductType::orderBy('name','asc')->get();
            return view('admin.sellers.items.edit',compact('item','ptypes','categories'));
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
    public function update(Request $request,$seller,$id)
    {

        $this->validate($request, [                      
            'name' => 'required|unique:seller_items,name,'.$seller.',seller_id,'.$id.',id|max:255',
            'picture' => 'mimes:jpeg,jpg,bmp,png,webp|max:5242880',
            'category_id' => 'required',
            'sub_category_id' => 'nullable',
            'product_type' => 'required',
            'price'=>'required'          
        ]);
       

        try {
            $item = SellerItem::findOrFail($id);
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
            return redirect()->route('admin.sellers.items.index',$seller)->with('flash_success', 'Item Updated Successfully');    
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
    public function destroy($seller,$id)
    {
        try{
            $item= SellerItem::findOrFail($id);
            Storage::delete($item->picture);
            $item->delete();
            return redirect()->route('admin.sellers.items.index',$seller)->with('flash_success','Item Deleted Successfully');
        }catch(Exception $e){
            return back()->with('flash_error', $e->getMessage());
        }
    }
  
}
