/**
 * Created by Mahmoud on 9/5/2017.
 */

var app = angular.module('callme', [])
.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('((');
    $interpolateProvider.endSymbol('))');
})
.controller("controller", function ($scope){
    $scope.elements = [];
    $scope.deleteds = [];
    $scope.showUpload = false;
    $scope.mouseDown = false;
    $scope.showAbbr = false;
    $scope.userHover = function () {
        $(document).ready(function () {
            $(".post-creater-image-link").hover(function () {
                alert("this.id");
            });
        });
    }
    $scope.sendFriendReuest = function (token, user_id, friend_id) {
        if(!$scope.showDrobdownFriendshipStatus){
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('user_id', user_id);
            formData.append('friend_id', friend_id);
            $.ajax({
                type: "POST",
                url: "/friendships",
                processData: false,
                contentType: false,
                dataType: "json",
                data: formData,
                success: function (data) {
                    $scope.getFriendshipStatus(user_id, friend_id);
                },
                error: function (data, err, status) {
                    alert(status);
                },
                async: false
            });
        }
    }
    $scope.updateFriendshipStatus = function (token, status, user_id, friend_id) {
        $.ajax({
            type: "PUT",
            url: "/friendships/"+$scope.friendshipID+"?_token="+token+"&friendship_status="+status,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                $scope.getFriendshipStatus(user_id, friend_id);
            },
            error: function (data, err, status) {
                alert(status);
            },
            async: false
        });
    }
    $scope.getFriendshipStatus = function (id1, id2) {
        $.ajax({
            type: "GET",
            url: "/friendships/"+id1+"/"+id2,
            processData: false,
            contentType: false,
            dataType: "json",
            data: "",
            success: function (data) {
                $scope.showDrobdownFriendshipStatus = true;
                $scope.showAcceptFriendship = false;
                if(data.status != 00){
                    $scope.friendshipID = data.id;
                }else{
                    $scope.friendshipID = 0;
                }
                switch (data.status){
                    case 00:
                        $scope.friendshipText = "Send Friend Request";
                        $scope.showDrobdownFriendshipStatus = false;
                        break;
                    case 01:
                        if(data.user_id == id1){
                            $scope.showAcceptFriendship = true;
                            $scope.friendshipText = "Accept Friend Request";
                            $scope.cancelRequestText = "Decline";
                        }else{
                            $scope.friendshipText = "Sending Friendship Request";
                            $scope.cancelRequestText = "Cancel Sending Request";
                        }
                        break;
                    case 10:
                        if(data.user_id == id1){
                            $scope.friendshipText = "Sending Friendship Request";
                            $scope.cancelRequestText = "Cancel Sending Request";
                        }else{
                            $scope.showAcceptFriendship = true;
                            $scope.friendshipText = "Accept Friend Request";
                            $scope.cancelRequestText = "Decline";
                        }
                        break;
                    case 11:
                        $scope.friendshipText = "Friends";
                        $scope.cancelRequestText = "Unfriend";
                        break;
                    default:
                        $scope.friendshipText = "Send Friend Request";
                        $scope.showDrobdownFriendshipStatus = false;
                }

            },
            error: function (data, err, status) {
                alert(status);
            },
            async: false
        });
    };
    $scope.removeElement = function(index){
        var e = {ID: $scope.elements[index].ID};
        $scope.deleteds.push(e);
        $scope.elements.splice(index, 1);

    };
    $scope.apply = function(){
        if($scope.mouseDown){
            return true;
        }else{
            return false;
        }
    }
    $scope.uploadProfileImage = function () {
        var files = $scope.upload();
        var user_id = $("[name='user_id']").val();
        var name = $("[name='name']").val();
        var token = $('[name="_token"]').val();
        $.ajax({
            type: "PUT",
            url: "/users/"+user_id+"?&_token="+token+"&name="+name+"&image+path="+files[0].ID,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (data) {
                alert(data.status);
            },
            error: function (data, err, status) {
                alert(status);
            },
            async: false
        });
        return files;
    }
    $scope.post = function () {
        var token = $("[name='_token']").val();
        var postContent = $("[name='postContent']").val();
        var user_id = $("[name='user_id']").val();
        var formData = new FormData();
        formData.append("_token", token);
        formData.append("postContent", postContent);
        formData.append("user_id", user_id);
        var elements = "";
        var deleteds = "";

        for(i = 0; i<$scope.elements.length; i++){
            elements += $scope.elements[i].ID+"-";
        }
        for(i = 0; i<$scope.deleteds.length; i++){
            deleteds += $scope.deleteds[i].ID+"-";
        }
        //if($scope.elements.length > 1){
            elements = elements.substring(0, elements.length-1);
        //}
        //if($scope.deleteds.length > 1) {
            deleteds = deleteds.substring(0, deleteds.length-1);
        //}
        //alert("elements: "+elements+"\ndeleteds: "+deleteds);
        formData.append("elements", elements);
        formData.append("deleteds", deleteds);
        $.ajax({
            type: "POST",
            url: "/posts",
            processData: false,
            contentType: false,
            dataType: "json",
            data: formData,
            success: function (data) {
                //alert(data.deleteds+"\n"+data.elements+"\n"+data.content);
            },
            error: function (data, err, status) {
                alert(status);
            },
            async: false
        });
        return files[0].id;
    }
    $scope.upload = function () {
        var file = $("#profile-image");
        var str = "";
        for(key in file[0].files[0]){
            str += key + " : " +file[0].files[0][key]+ "\n";
        }
        //alert(str);
        var user_id = $("[name='user_id']").val();
        var type = file[0].files[0]["type"];
        var reason = $("[name='reason']").val();
        var token = $('[name="_token"]').val();
        var files = [];
        if(file[0].files[0] == undefined){
            alert("no file selected");
        }else{
            for (i = 0; i<file[0].files.length; i++){
                var formData = new FormData();
                formData.append("_token", token);
                formData.append("file", file[0].files[i]);
                formData.append("user_id", user_id);
                formData.append("type", type);
                formData.append("reason", reason);
                $.ajax({
                    type: "POST",
                    url: "/files",
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    data: formData,
                    success: function (data) {
                        files[i] = data;
                        var e = {ID: data.ID};
                        $scope.elements.push(e);
                    },
                    error: function (data, err, status) {
                        alert(status);
                    },
                    async: false
                });
            }
            $scope.showUpload = false;
            $scope.showButton = true;
        }
        return files;
    }
});