<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\ProductsImage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Products::get();
        return response()->json($data);
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
    * 
    *
    * @param  int  $id
    * @param array $arr
    * @return \Illuminate\Http\Response
    */

    public function storeMultipleImages($id , $arr) {
        foreach($arr as $item) {
            $name = $item->getClientOriginalName();
            $item->storeAs("public/images/products", $name);
            $data = new ProductsImage;
            $data->product_id = $id;
            $data->image = $name;
            $data->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $data = new Products;   
            $data->name = $request->name;
            $data->content = $request->content;
            $data->color = $request->color;
            $data->age = $request->age;
            $data->gender = $request->gender;
            $data->price_root = $request->price_root;
            $data->price_sale = $request->price_sale;
            $data->quantity = $request->quantity;
            $data->category_id = $request->category_id;
            $data->save();

            $file = $request->file("image");

            if ($file) {
                    $images = new ProductsImage;
                    $name = $file->getClientOriginalName();
                    $file->storeAs("public/images/products", $name);
                    $images->product_id = $data->id;
                    $images->image = $name;
                    $images->save();
                }
            else {
                return response()->json(["status"=>false]);
            }

            return response()->json(["status"=>true]);
    }

    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail_product($id)
    {
        $data = Products::find($id);
        $data->image = ProductsImage::where("product_id" , "=" , $id)->first()->image;
        return response()->json($data , 200);
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
        $data = Products::find($id);

        $request->name && $data->name = $request->name;
        $request->content && $data->content = $request->content;
        $request->color && $data->color = $request->color;
        $request->age && $data->age = $request->age;
        $request->gender && $data->gender = $request->gender;
        $request->price_root && $data->price_root = $request->price_root;
        $request->price_sale && $data->price_sale = $request->price_sale;
        $request->quantity && $data->quantity = $request->quantity;
        $request->category_id && $data->category_id = $request->category_id;

        if ($request->file("image")){
            $image_name = $request->file("image")->getClientOriginalName();
            $request->file("image")->storeAs("public/images/products", $image_name);    
            $data->image = $image_name;
        }

        $result = $data->save();

        if ($result) {
            return response()->json(["status" => "updated"]);
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
        $data = Products::find($id)->delete();
        if ($data) {
            return response()->json(["status" => true]);
        }
        else {
            return response()->json(["status" => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_product_by_category($id)
    {
        $data = Products::where("category_id","=",$id)->get();
        foreach($data as $item){
            $item->images = ProductsImage::where("product_id", "=" , $item->id)->get();
        }

        if ($data) {
            return response()->json($data , 200);
        }
        else {
            return response()->json(["status" => false],401);
        }
    }

    public function get_images_by_product($id){
        $data = ProductsImage::where("product_id" , "=" , $id)->get();

        return response()->json($data , 200);
    }

    public function get_random_product($id){
        switch ($id){
            case "cats":
                $data = Products::where("category_id","<=",21)->get()->random(10);
                foreach($data as $item){
                    $item->image = ProductsImage::where("product_id","=",$item->id)->first()->image;
                }        
                break;
            case "dogs":
                    $data = Products::where("category_id",">",21)->where("category_id","<=",44)->get()->random(10);
                    foreach($data as $item){
                        $item->image = ProductsImage::where("product_id","=",$item->id)->first()->image;
                    }        
                    break;
            case "accessories":
                $data = Products::where("category_id",">",44)->get()->random(10);
                foreach($data as $item){
                    $item->image = ProductsImage::where("product_id","=",$item->id)->first()->image;
                }        
                break;
            default:
                return response()->json(["status" => false], 400);
        }
        
        return response()->json($data , 200);
    }

    public function get_hot_product(){
        $data = Products::all();
        foreach($data as $item){
            $item->sale = 100 - ($item->price_sale * 100 / $item->price_root);
            $item->image = ProductsImage::where("product_id","=",$item->id)->first()->image;
        }
        $data->sortByDesc("sale")->take(20);
        return response()->json($data , 200);
    }
}
