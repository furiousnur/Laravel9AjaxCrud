<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class AjaxBOOKCRUDController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id','desc')->paginate(5);
        return view('ajax-book-crud',compact('books'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Book::updateOrCreate(
            [
                'id' => $request->id
            ],
            [
                'title' => $request->title,
                'code' => $request->code,
                'author' => $request->author,
            ]);

        return response()->json(['success' => true]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $book  = Book::where($where)->first();

        return response()->json($book);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $book = Book::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
