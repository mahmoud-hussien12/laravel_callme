@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-md-offset-0">
                <div class="panel panel-default">
                    <div class="panel-heading">users</div>
                    <div class="panel-body">
                        <ul>
                            @foreach($users as $user)
                                <li>
                                    <a href={{"/users/".$user->id}}><img class="img-circle user_image" width="50px" height="50px" src="{{"/files/".$user->image_path."?user_id=".Auth::user()->id}}"> {{$user->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
