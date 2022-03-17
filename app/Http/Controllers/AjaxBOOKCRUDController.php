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
        $data['books'] = Book::orderBy('id','desc')->paginate(5);

        return view('ajax-book-crud',$data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book   =   Book::updateOrCreate(
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
     * @param  \App\Product  $product
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $book = Book::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
