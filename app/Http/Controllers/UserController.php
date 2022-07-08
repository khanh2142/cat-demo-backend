<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Users;

use App\Models\SessionModel;

use Session;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            // Session::put("test","test value test");
            $data = Session::all();

            return response()->json($data, 200);
        }
        catch (\Throwable $th){
            return response()->json(["status" => false], 400);
        }
    }

   /**
     * Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function login(Request $request)
   {
       try {
           $user = Users::get()->where("username",$request->username)->where("password",$request->password);

           if (count($user)) {
                Session::put("test","tested");
                return response()->json(["status" => true, "data" => $user], 200);     
           }

           return response()->json(["status" => false], 400);     
       }
       catch (\Throwable $th){
           return response()->json(["status" => false], 400);
       }
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
    public function signUp(Request $request)
    {
        try {

            $users = Users::where("username" , $request->username)->get();

            if (count($users) <= 0 ) {
                $data = new Users;
                $data->username = $request->username;
                $data->password = $request->password;
                $data->fullname = $request->username;
                
                $data->save();


                return response()->json(["status" => true], 200);
            }

            if ($users) {
                return response()->json(["status" => false], 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
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

        /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get_user($id)
    {
        $data = Users::where("role_id",$id)->get();
        return response()->json($data, 200);
    }
}
