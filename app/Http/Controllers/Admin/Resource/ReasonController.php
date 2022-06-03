<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\ShipmentReason;

class ReasonController extends Controller
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
        $types = ShipmentReason::latest()->get(); 
        return view('admin.reasons.index',compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reasons.create');
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
            'title' => 'required|max:255|unique:shipment_reasons,title',
            'reason_for' => 'required'
        ]);

        try{
            $type = $request->all();
            ShipmentReason::create($type);
            return redirect()->route('admin.reasons.index')->with('flash_success','Reason Created Successfully');
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
            $type = ShipmentReason::findOrFail($id);
            return view('admin.reasons.edit',compact('type'));
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
            'title'=> 'required|unique:shipment_reasons,title,'.$id.',id|max:255',
            'reason_for'=> 'required'
        ]);
        try {
            $type = ShipmentReason::findOrFail($id);
            $type->title = $request->title;
            $type->reason_for = $request->reason_for;
            $type->save();
            return redirect()->route('admin.reasons.index')->with('flash_success', 'Reason Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Reason Not Found');
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
            $type = ShipmentReason::findOrFail($id)->delete();
            return back()->with('flash_success', 'Reason deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Reason Not Found');
        }
    }
}
