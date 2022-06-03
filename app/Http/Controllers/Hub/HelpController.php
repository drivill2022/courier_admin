<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Help;
use App\models\Shipments;
use App\models\admin\Merchants;
use Storage;
use Auth;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list=Help::select('helps.*','shipments.shipment_no','merchants.name as merchant_name')->join('shipments','shipments.id','=','helps.shipment_id')->join('merchants','merchants.id','=','helps.merchant_id')->orderBy('helps.id','desc')->get();
        return view('admin.help.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shipment_list = Shipments::whereIn('status',['6','7'])->get();
        $marchants = Merchants::where('status','Active')->get();
        $title="Add New Complain";
        return view('hub.help.create',compact('shipment_list','marchants','title'));
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
            'shipment_id' => 'required',            
            'merchant_id' => 'required',            
            'complain' => 'required',            
        ]);

        try{

            $already = Help::where('shipment_id',$request->shipment_id)->where('merchant_id',$request->merchant_id)->get();
            /*if(!empty($already))
            {
                return back()->with('flash_error', 'Complain already sent for these shipment');
            }*/

            $help = $request->all();  
            $help['created_by'] = Auth::guard('hub')->user()->id;       
            Help::create($help);           
            return redirect()->route('hub.shipments.index')->with('flash_success','Complain Added Successfully');
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
        $service = Help::findOrFail($id);
        return view('admin.help.show',compact('service'));
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
            $list = Help::findOrFail($id);
            $shipment_list = Shipments::whereIn('status',['6','7'])->get();
            $marchants = Merchants::where('status','Active')->get();
            return view('admin.help.edit',compact('list','shipment_list','marchants'));
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
            'shipment_id' => 'required',            
            'merchant_id' => 'required',            
            'complain' => 'required',            
        ]);

        try {
            $help = Help::findOrFail($id);
            $help->shipment_id = $request->shipment_id;
            $help->merchant_id = $request->merchant_id;
            $help->complain = $request->complain;     
            $help->status = $request->status;  
            if($request->has('status') && $request->status == "1")
            {
                $help->updated_by = Auth::guard('hub')->user()->id;         
            }   
            $help->save();
            return redirect()->route('admin.help.index')->with('flash_success', 'Complain Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'Complain Not Found');
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
            $service = Help::findOrFail($id);
            $service->delete();
            return back()->with('message', 'Complain deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Complain Not Found');
        }
    }

    public function report_claim($shipment_id)
    {
        $shipment = Shipments::find($shipment_id);
        $title = "Report Claim";
        return view('hub.help.create',compact('shipment','title'));
    }
}
