<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\PostFile;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Post;
use App\File;
use App\User;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $redirectTo = '/posts';
    public function __construct(){
        $this->middleware('host');
    }
    public function index()
    {
        //
        /*$user = User::find(1);
        $friends1 = $user->friends;
        $friends2 = $user->myFriends;
        $str = "";
        foreach ($friends1 as $friend){
            $str .= $friend->name . "<br>";
        }
        foreach ($friends2 as $friend){
            $str .= $friend->name . "<br>";
        }
        return $str;*/
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
        $post = new Post();
        $post->content = $request->postContent;
        $post->user_id = $request->user_id;
        $post->save();
        $elements = [];
        $deleteds = [];
        if(strpos($request->elements, "-") != false) {
            $elements = explode("-", $request->elements);
        }else if(strlen($request->elements) > 0){
            $elements[0] = $request->elements;
        }
        if(strpos($request->deleteds, "-") != false) {
            $deleteds = explode("-", $request->deleteds);
        }else if(strlen($request->deleteds) > 0){
            $deleteds[0] = $request->deleteds;
        }
        for ($i= 0; $i<count($elements); $i++){
            $post_file = new PostFile();
            $post_file->post_id = $post->id;
            $post_file->file_id = $elements[$i];
            $post_file->save();
            $m = true;
        }
        if(count($deleteds) > 0){
            File::destroy($deleteds);
        }
        $response = array("elements"=>count($elements), "deleteds"=>$request->deleteds, "content"=>$request->postContent);
        return response()->json($response);
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
}
