<?php

namespace App\Http\Controllers;

use App\Friendship;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function __construct(){
        $this->middleware('host');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
        //
        $status = '10';
        $friendship = new Friendship();
        $friendship->user_id = $request->user_id;
        $friendship->friend_id = $request->friend_id;
        $friendship->status = $status;
        $friendship->save();
        return $friendship;
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
    public function getFriendship($id1, $id2){
        $friendship = Friendship::where('user_id', $id1)->where('friend_id', $id2)->get();
        $friendship1 = Friendship::where('friend_id', $id1)->where('user_id', $id2)->get();
        if(count($friendship) > 0){
            return $friendship[0];
        }else if(count($friendship1) > 0){
            return $friendship1[0];
        }else{
            $response = array("status"=>'00');
            return response()->json($response);
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
        $friendship = Friendship::find($id);
        if($request->friendship_status == '00'){
            $friendship->forceDelete();
            $response = array(["status"=>'00']);
            return response()->json($response);
        }else{
            $friendship->update(["status"=>$request->friendship_status]);
            return $friendship;
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
        //
    }
}
