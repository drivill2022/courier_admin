<?php

namespace App\Http\Controllers\Admin\Resource;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\admin\Pages;
use Illuminate\Support\Str;
class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages=Pages::get();
        return view('admin.pages.index',compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.create');
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
            'title' => 'required|max:255|unique:pages,title',            
            'content' => 'required',            
            'status' => 'required|in:Active,Blocked',            
           
        ]);

        try{
            $page = $request->all();            
            $page['slug']=Str::slug($page['title']);
            Pages::create($page);           
            return redirect()->route('admin.pages.index')->with('flash_success','Page Created Successfully');
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
        $page = Pages::findOrFail($id);
        return view('admin.pages.details',compact('page'));
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
            $page = Pages::findOrFail($id);
            return view('admin.pages.edit',compact('page'));
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
            'content' => 'required',            
            'status' => 'required',            
            'title' => 'required|unique:pages,title,'.$id.',id|max:255'
        ]);
       

        try {
            $page = Pages::findOrFail($id);
            $page->title = $request->title;
            $page->content = $request->content;
            $page->status = $request->status;            
            $page->save();
            return redirect()->route('admin.pages.index')->with('flash_success', 'Page Updated Successfully');    
        } 
        catch (ModelNotFoundException $e) {
            return back()->with('flash_error', 'User Not Found');
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
            $page = Pages::findOrFail($id);
            $page->delete();
            return back()->with('message', 'Page deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'Page Not Found');
        }
    }
}
