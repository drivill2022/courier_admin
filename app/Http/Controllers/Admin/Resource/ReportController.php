<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\Shipments;
use App\models\ShipmentStatusLog;
use App\models\ShipmentAssignStatus;
use App\models\admin\Merchants;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$type='daily')
    {
        if($type=="daily")
        {
           /* $shipments = Shipments::select('shipment_no','product_detail','status','created_at')->join('shipment_assign_status','shipments.id','=','shipment_assign_status.shipment_id')->orderBy('shipments.created_at','desc')->get();*/
            $shipments = Shipments::select('shipment_no','merchant_id','product_detail','status','created_at')->orderBy('shipments.created_at','desc')->get();
            if(!empty($shipments))
            {
                foreach ($shipments as $key => $value) {
                 $merchant = Merchants::find($value->merchant_id);
                 $shipments[$key]->merchant_name =  $merchant->name;
                 $shipments[$key]->date = date('d M, Y',strtotime($value->created_at));
               }
            }
        }
        return view('admin.reports.index',compact('type','shipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
