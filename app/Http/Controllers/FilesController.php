<?php

namespace App\Http\Controllers;

use App\File;
use App\User;
use Storage;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;
use Psy\Util\Json;
use Symfony\Component\HttpFoundation\FileBag;

class FilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $input = $request->all();
        $file = $input['file'];
        $name = $file->getClientOriginalName();
        $path = $file->move('cfkEWKVEHDCrxjwf;45478r\\imgs', $name);
        //\Illuminate\Support\Facades\File::delete(''.$path);
        $file_entity = new File();
        $file_entity->user_id = $request->user_id;
        $file_entity->name = $name;
        $file_entity->path = $path;
        $file_entity->type = $request->type;
        $file_entity->reason = $request->reason;
        $id = $file_entity->save();
        $response = array("ID"=>$file_entity->id, "path"=>"".$file_entity->path);
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
        //$this->middleware('file');
        $file = File::find($id);
        return response()->download($file->path, null, [], null);
    }
    public function getMetaDataFile($id){
        $file = File::find($id);
        return $file;
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
