@extends('layouts.app')

@section('content')
    <div class="container profile" ng-controller="controller">
        @if($data->id == Auth::user()->id)
            <div class="profile-image">
                <a href="" class="image_link"><img class="profile_img" src='{{"/files/".Auth::user()->image_path."?user_id=".Auth::user()->id}}' width="100x"></a>
                <a ng-click="showUpload=true" class="image-update-link">
                    update image
                </a>
            </div>
            <div class="profile-secondary-nav">
                <button class="btn btn-primary">Send Message</button>
            </div>
            <!--<form action="/files" class="dropzone">
                <div class="fallback">
                    <input name="file" class="form-control" type="file" multiple />
                </div>
            </form>-->
            <div ng-show="showUpload" class="popup">
                <a ng-click="showUpload=false"><i class="glyphicon glyphicon-remove"></i></a>
                <form class="form-horizontal" role="form" method="POST" ng-submit="uploadProfileImage();false;" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="profile-image" class="col-md-4 control-label">profile image</label>
                        <div class="col-md-6">
                            <input id="profile-image" type="file" multiple class="form-control" name="file">
                        </div>
                    </div>

                    <input type="hidden" value='{{Auth::user()->id}}' name="user_id" readonly>
                    <input type="hidden" value='image' name="type" readonly>
                    <input type="hidden" value='profile' name="reason" readonly>
                    <input type="hidden" value='{{Auth::user()->name}}' name="name" readonly>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                upload
                            </button>
                        </div>
                    </div>
                    <img ng-src="((source))" width="50px" height="50px">
                </form>
            </div>
            <table class="table table-condensed data-table">
                <tr>
                    <td><h2>Name</h2></td>
                    <td><h2>{{Auth::user()->name}}</h2></td>
                    <td><a href=""><h5>edit<i class="glyphicon glyphicon-edit"></i></h5></a></td>
                </tr>
                <tr>
                    <td><h3>email</h3></td>
                    <td><h3>{{Auth::user()->email}}</h3></td>
                    <td><a href=""><h5>edit<i class="glyphicon glyphicon-edit"></i></h5></a></td>
                </tr>
                <tr>
                    <td><h4>Created at</h4></td>
                    <td><h4>{{Auth::user()->created_at}}</h4></td>
                    <td><a href=""><h5>edit<i class="glyphicon glyphicon-edit"></i></h5></a></td>
                </tr>
            </table>
        @else
            <img class="profile_img" src='{{"/files/".$data->image_path."?user_id=".$data->id}}' width="100x">
            <div class="profile-secondary-nav">
                <button class="btn btn-primary dropdown-toggle" ng-click="sendFriendReuest('{{csrf_token()}}', '{{Auth::user()->id}}', '{{$data->id}}');" data-toggle="dropdown" ng-init="getFriendshipStatus('{{Auth::user()->id}}', '{{$data->id}}')">((friendshipText))</button>
                <ul ng-show="showDrobdownFriendshipStatus" class="dropdown-menu">
                    <li><a href="" ng-show="showAcceptFriendship" ng-click="updateFriendshipStatus('{{csrf_token()}}', '11',  '{{Auth::user()->id}}', '{{$data->id}}');">Accept</a></li>
                    <li><a href="" ng-click="updateFriendshipStatus('{{csrf_token()}}', '00', '{{Auth::user()->id}}', '{{$data->id}}');">((cancelRequestText))</a></li>
                </ul>
                <button class="btn btn-primary">Send Message</button>
                <button class="btn btn-primary">Follow</button>
            </div>
            <table class="table table-condensed data-table">
                <tr>
                    <td><h2>Name</h2></td>
                    <td><h2>{{$data->name}}</h2></td>
                </tr>
                <tr>
                    <td><h3>email</h3></td>
                    <td><h3>{{$data->email}}</h3></td>
                </tr>
                <tr>
                    <td><h4>Created at</h4></td>
                    <td><h4>{{$data->created_at}}</h4></td>
                </tr>
            </table>
        @endif
    </div>
@endsection
