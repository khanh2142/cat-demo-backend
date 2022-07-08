<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsCategory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = ProductsCategory::all();
        return  response()->json($categories);
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
        // return response()->json($request->file("image"), 200);

        // dd($request->all());    
        $category = new ProductsCategory; 
        $category->name = $request->name;
        $category->type_id = $request->type_id;
        if ($request->file("image")) {
            $image_name = $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("public/images/categories", $image_name);
            $category->image = $image_name;    
        }
        else {
            $category->image = null;
        }
        
        $insert = $category->save();
        if ($insert) {
            return response()->json(["status" => true], 200);
        }
        else {
            return response()->json(["status" => false] , 401);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_category($id)
    {
        try {
            $result = DB::table("products_category")->where("type_id",$id)->get();
            return response()->json($result);
        } catch (\Throwable $th) {
            
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        


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
        $data = ProductsCategory::find($id);

        if ($request->file("image")){
            $image_name = $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("public/images/categories", $image_name);    
            $data->image = $image_name;
        }

        $request->name && $data->name = $request->name;
        $request->type_id && $data->type_id = $request->type_id;

        $data = $data->save();

        if ($data) {
            return response()->json("updated to db");
        }
        else {
            return response()->json("update failed");
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
        $result = ProductsCategory::find($id)->delete();
        if ($result) {
            return response()->json("deleted");
        }
        else {
            return response()->json("delete failed");
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_each_category($id)
    {
        $result = ProductsCategory::find($id);
        if ($result) {
            return response()->json($result, 200);
        }
        else {
            return response()->json(["status" => false] ,401);
        }
    }
}
