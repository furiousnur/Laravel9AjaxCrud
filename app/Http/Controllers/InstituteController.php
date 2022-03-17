<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $institutes = Institute::orderBy('id','desc')->paginate(5);
        return view('ajax-institute-crud',compact('institutes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Institute::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'name' => $request->name,
                'institute_code' => $request->institute_code,
                'status' => $request->status,
            ]);

        return response()->json(['success' => true]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $book  = Institute::where($where)->first();

        return response()->json($book);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Institute::findOrFail($request->id)->delete();

        return response()->json(['success' => true]);
    }
}
