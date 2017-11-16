@extends('layouts.app')

@section('content')
<div class="container" ng-controller="controller">
    <!--<a href="/posts/"> Create Post!</a>-->
    <div class="row">
        <div class="left-menu col-md-9 col-md-offset-0">
            <div class="friends panel panel-default">
                <div class="panel-heading">Friends</div>
                <div class="panel-body">
                    <ul class="friends-list list-group">
                        @foreach(Auth::user()->getFriends() as $friend)
                            <li class="list-group-item">
                                <a href="" ng-click="createChat('{{$friend->id}}', '{{$friend->name}}')"> {{$friend->name}}</a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="body">
        <div class="write-post">
            <form method="post" role="form" ng-submit="post();false;">
                {{csrf_field()}}
                <textarea ng-focus="showButton=true" ng-blur="showButton=mouseDown" class="post-content" name="postContent" placeholder="what are you thinking?" cols="70" rows="7"></textarea>
                <input type="hidden" value='{{Auth::user()->id}}' name="user_id" readonly>
                <input type="hidden" value='elements' name="elements" readonly>
                <input type="hidden" value='deleteds' name="deleteds" readonly>
                <div class="post-button col-md-6 col-md-offset-4" ng-show="showButton" ng-mousedown="mouseDown=true" ng-mouseup="mouseDown=false;showButton=false">
                    <button type="submit" class="btn btn-primary">
                        Post
                    </button>
                    <button type="button" ng-click="showUpload=true" class="btn btn-primary">
                        Upload
                    </button>
                </div>
                <div class="post-bar" ng-show="showButton && elements.length > 0" ng-mousedown="mouseDown=true">
                    <ul>
                        <li ng-repeat="element in elements">
                            <a href="" ng-click="removeElement($index);"><i class="glyphicon glyphicon-remove"></i></a>
                            <img ng-src='(("/files/"+element.ID+"?user_id={{Auth::user()->id}}"))'>
                        </li>
                    </ul>
                </div>
            </form>
            <div ng-show="showUpload" class="popup">
                <a ng-click="showUpload=false"><i class="glyphicon glyphicon-remove"></i></a>
                <form class="form-horizontal" role="form" method="POST" ng-submit="upload();false;" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="profile-image" class="col-md-4 control-label">profile image</label>
                        <div class="col-md-6">
                            <input id="profile-image" type="file" multiple class="form-control" name="file">
                        </div>
                    </div>
                    <input type="hidden" value='{{Auth::user()->id}}' name="user_id" readonly>
                    <input type="hidden" value='image' name="type" readonly>
                    <input type="hidden" value='post' name="reason" readonly>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <ul class="posts">
            @foreach(Auth::user()->viewablePosts() as $post)
                <li class="post">
                    <div class="post-header">

                        <a class="post-creater-image-link" id="{{"imageLink".$post->id}}" href="/users/{{$post->user->id}}">
                            <img class="img-circle post-creater-image" src="{{"/files/".$post->user->image_path."?user_id=".Auth::user()->id}}">
                        </a>
                        <div class="abbr-div" id="{{"abbr".$post->id}}">
                            <img src="{{"/files/".$post->user->image_path."?user_id=".Auth::user()->id}}">
                            <a href="/users/{{$post->user->id}}">{{$post->user->name}}</a>
                            <a href="/users/{{$post->user->id}}">((getFriendshipStatus('{{Auth::user()->id}}', '{{$post->user->id}}'); friendshipText))</a>
                            <button ng-click="createChat('{{$post->user->id}}', '{{$post->user->name}}');">Send Message</button>
                        </div>
                        <dl class="post-header-caption">
                            <dt><a href="/users/{{$post->user->id}}">{{$post->user->name}}</a></dt>
                            <dd><a href="/posts/{{$post->id}}">{{$post->created_at}}</a></dd>
                        </dl>
                    </div>
                    <div class="post-content">
                        <pre>
                            {{$post->content}}
                        </pre>
                        <ul class="post-files">
                            @foreach($post->files as $file)
                                <li>
                                    <a href="/files/{{$file->id}}?user_id={{Auth::user()->id}}">
                                        @if(strpos($file->type, "image") !== false)
                                            <img src='{{"/files/".$file->id."?user_id=".Auth::user()->id}}'>
                                        @elseif(strpos($file->type, "video") !== false)
                                            <video src='{{"/files/".$file->id."?user_id=".Auth::user()->id}}' controls autoplay></video>
                                        @else
                                            {{$file->name}}
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
<div class="footer" ng-controller="controller">
    <div class="queue dropup">
        <a data-toggle="dropdown" class="queued-toggle" role="button"><i class="glyphicon glyphicon-comment"></i></a>
        <ul class="queued-chats dropdown-menu">
            <li class="queued-chat"><a>Normal</a></li>
            <li class="queued-chat"><a>Disabled</a></li>
            <li class="queued-chat"><a>Active</a></li>
        </ul>
    </div>
    <ul class="chats">
    </ul>
</div>
@endsection
