<?php

namespace App\Imports;

use App\models\Shipments;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\models\admin\Division;
use App\models\admin\District;
use App\models\admin\Thana;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Facades\Validator;

class ShipmentsImport implements ToCollection, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }

  /*  public function model(array $row)
    {
        $data = $this->data;
        //$slast = Shipments::orderBy('id','desc')->first();
        //$slast = $slast->id+1;

        $d_division = Division::where('name',$row['d_division'])->first();
        $d_district = District::where('name',$row['d_district'])->first();
        $d_thana = Thana::where('name',$row['d_thana'])->first();

        $shipment_data = [
            'merchant_id'     => $data['merchant_id'],
            'receiver_name'     => $row['receiver_name'],
            'contact_no'    => $row['contact_no'],
            's_address'    => $data['s_address'],
            's_latitude'    => $data['s_latitude'],
            's_longitude'    => $data['s_longitude'],
            's_thana'    => $data['s_thana'],
            's_district'    => $data['s_district'],
            's_division'    => $data['s_division'],
            'd_address'    => $row['d_address'],
            'd_thana'    => $d_thana->id,
            'd_district'    => $d_district->id,
            'd_division'    => $d_division->id,
            'd_latitude'    => $row['d_latitude'],
            'd_longitude'    => $row['d_longitude'],
            'product_detail'    => $row['product_detail'],
            'product_weight'    => $row['product_weight'],            
            'product_type'    => $data['product_type'],
            'cod_amount'    => $row['cod_amount'],
            'note'    => @$row['note'],
            'status'    => 1,
            //'shipment_no' => '#DC'.sprintf('%04d', $slast),
            'pickup_date' => $row['pickup_date'],
        ];
        //print_r($shipment_data);die;
        $response = new Shipments($shipment_data);
        //$shipment_id = Shipments::insertGetId($shipment_data);
        //$shipment_update = Shipments::find($shipment_id);
        //$shipment_update->shipment_no ='#DC'.sprintf('%04d', $shipment_id);
        //$shipment_update->save();

        return $response;
        //return new Shipments($shipment_data);
    }*/

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $data = $this->data;
            $d_division = Division::where('name',@$row['d_division'])->first();
            $d_district = District::where('name',@$row['d_district'])->first();
            $d_thana = Thana::where('name',@$row['d_thana'])->first();

            $shipment_data = [
                'merchant_id'     => $data['merchant_id'],
                'receiver_name'     => $row['receiver_name'],
                'contact_no'    => $row['contact_no'],
                's_address'    => $data['s_address'],
                's_latitude'    => $data['s_latitude'],
                's_longitude'    => $data['s_longitude'],
                's_thana'    => $data['s_thana'],
                's_district'    => $data['s_district'],
                's_division'    => $data['s_division'],
                'd_address'    => $row['d_address'],
                'd_thana'    => @$d_thana->id,
                'd_district'    => @$d_district->id,
                'd_division'    => @$d_division->id,
                /*'d_latitude'    => $row['d_latitude'],
                'd_longitude'    => $row['d_longitude'],*/
                'product_detail'    => @$row['product_detail'],
                'product_weight'    => trim(strtoupper($row['product_weight'])),            
                'product_type'    => $data['product_type'],
                'cod_amount'    => $row['cod_amount'],
                'note'    => @$row['note'],
                'status'    => 1,
                //'shipment_no' => '#DC'.sprintf('%04d', $slast),
                //'pickup_date' => Date('Y-m-d H:i:s',strtotime($row['pickup_date'] )),
                //'pickup_date' => $row['pickup_date']
                'pickup_date' => $this->transformDate($row['pickup_date'])
            ];
            $response = Shipments::create($shipment_data);
            //print_r($response);die;
            $shipment_update = Shipments::find($response->id);
            $shipment_update->shipment_no ='#DC'.sprintf('%04d', $response->id);
            $shipment_update->save();
        }
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
        } catch (\ErrorException $e) {
           // return \Carbon\Carbon::createFromFormat($format, $value);
            return Date('Y-m-d H:i:s',strtotime($value));
        }

     /*   $value = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        return $this->transformDatetoformat($value);*/
       /*  $value = str_replace('/', '-', $value);
        //return Date('Y-m-d',strtotime($value));
       return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));;*/
       
    }

    /*public function transformDatetoformat($value, $format = 'Y-m-d')
    {
        if(strpos('/', $value->date) != false)
         {
            $value->date = str_replace('/', '-', $value->date);
            return Date('Y-m-d',strtotime($value->date));
         }
         else
         {
            return Date('Y-m-d',strtotime($value->date));
         }
    }
*/
      public function rules(): array
    {
        $this->allProductWeight=array(
                                        '500 GM' => '500 GM',
                                        '1 KG' => '1 KG',
                                        '2 KG' => '2 KG',
                                        '3 KG' => '3 KG',
                                        '4 KG' => '4 KG',
                                        '5 KG' => '5 KG',
                                        '6 KG' => '6 KG',
                                        '7 KG' => '7 KG',
                                        'Upto 7 KG' => 'Upto 7 KG',
                                      ); 

        return [
            'receiver_name' => 'Required',
            'contact_no' => 'Required',
            'pickup_date' => ['Required',
                function ($attribute,$value, $fail)
                {
                     try {
                           return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
                        } catch (\ErrorException $e) {
                           //$fail($attribute. ' is invalid.The date format should be dd-mm-YYYY');
                          if(date('d-m-Y', strtotime($value)) == date($value)) 
                            {
                              return $value;
                            }
                            else
                            {
                                 $fail($attribute. ' is invalid.The date format should be dd-mm-YYYY');;
                            }
                          
                        }
                },
            ],
            'd_address' => 'Required',
            /*'d_thana' => 'Required|exists:thanas,name',
            'd_district' => 'Required|exists:districts,name',
            'd_division' => 'Required|exists:divisions,name',*/
            'd_thana' => 'nullable|exists:thanas,name',
            'd_district' => 'nullable|exists:districts,name',
            'd_division' => 'nullable|exists:divisions,name',
            /*'d_latitude' => 'Required',
            'd_longitude' => 'Required',*/
            'product_detail' => 'nullable',
             'cod_amount' => 'Required',
            'product_weight' => ['Required',
              function ($attribute, $value, $fail) {
                 $value = strtoupper($value);
                  $allProductWeight=array(
                                        '500 GM' => '500 GM',
                                        '1 KG' => '1 KG',
                                        '2 KG' => '2 KG',
                                        '3 KG' => '3 KG',
                                        '4 KG' => '4 KG',
                                        '5 KG' => '5 KG',
                                        '6 KG' => '6 KG',
                                        '7 KG' => '7 KG',
                                        'Upto 7 KG' => 'Upto 7 KG',
                                      ); 
                  if(!in_array($value, $allProductWeight))
                  {
                     $fail($attribute. ' is invalid.');
                  }
                 /*if($value === strtoupper($value))
                 {
                    $fail($attribute. ' is invalid.');
                 }*/
                },
                //Rule::in($this->allProductWeight),
             ],
           
        ];
    }
}
