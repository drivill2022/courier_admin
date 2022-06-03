<?php

namespace App\Http\Controllers\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Setting;
use App\models\admin\Settings;
class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$setting='application')
    {
        return view('admin.settings.'.$setting,compact('setting'));
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
        $this->validate($request,[
                'site_title' => 'required',
                'site_icon' => 'mimes:jpeg,jpg,bmp,png,ico|max:5242880',
                'site_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
                'hub_search_radius' => 'required|min:1',
                'rider_search_radius' => 'required|min:1',
                'sos_number' => 'required',
                'contact_number' => 'required',
                'map_key' => 'required',
                'contact_email' => 'required|email',
                'site_copyright' => 'required',
            ]);

        if($request->hasFile('site_icon')) {
            $site_icon = $request->site_icon->store('settings');
            if(Setting::get('site_icon')){
                Storage::delete(Setting::get('site_icon'));
            }
            Setting::set('site_icon', $site_icon);
        }

        if($request->hasFile('site_logo')) {
            $site_logo = $request->site_logo->store('settings');
            if(Setting::get('site_logo')){
                Storage::delete(Setting::get('site_logo'));
            }
            Setting::set('site_logo', $site_logo);
        }
        Setting::set('site_title', $request->site_title);
        Setting::set('hub_search_radius', $request->hub_search_radius);
        Setting::set('rider_search_radius', $request->rider_search_radius);
        Setting::set('sos_number', $request->sos_number);
        Setting::set('contact_number', $request->contact_number);
        Setting::set('contact_number_2', $request->contact_number_2);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('site_copyright', $request->site_copyright);
        Setting::set('map_key', $request->map_key);
        Setting::save();
        return back()->with('flash_success','Settings Updated Successfully');
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
