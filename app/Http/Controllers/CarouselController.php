<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carousels;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Carousels::all();
        dd($data);
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
        $data = new Carousels;
        if ($request->file("image")) {
            $image_name = $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("public/images/carousels", $image_name);
            $data->image = $image_name;    
        }
        else {
            $data->image = null;
        }

        $result = $data->save();

        if ($result) {
            return response()->json(["status" => "inserted successfully"]);
        }
        else {
            return response()->json(["status" => "insert failed"]);
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
        $data = Carousels::find($id);

        if ($request->file("image")){
            $image_name = $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("public/images/categories", $image_name);    
            $data->image = $image_name;
        }

        $result = $data->save();

        if ($result) {
            return response()->json(["status" => "updated to db"]);
        }
        else {
            return response()->json(["status" => "update failed"]);
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
        $result = Carousels::find($id)->delete();
        if ($result) {
            return response()->json(["status" => "deleted"]);
        }
        else {
            return response()->json(["status" => "delete failed"]);
        }
    }
}
