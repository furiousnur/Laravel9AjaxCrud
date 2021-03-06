<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Institute;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = Teacher::orderBy('id','desc')->paginate(5);
        $books = Book::all();
        $institutes = Institute::active()->get();
        return view('ajax-teacher-crud',compact('teachers','books','institutes'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Teacher::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'institute_id' => $request->institute_id,
                'book_id' => $request->book_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'designation' => $request->designation,
                'status' => $request->status,
            ]);

        return response()->json(['success' => true]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $book  = Teacher::where($where)->first();

        return response()->json($book);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Teacher::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
