@extends('profile.master')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profile</a></li>
                <li class="breadcrumb-item"><a href="">Edit Profile</a></li>
            </ol>
        </nav>
        <div class="row">
            @include('profile.sidebar')
            <div class="col-md-9">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{Auth::user()->name}} , Your Friends</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                @if(Session::has('msg'))
                                    <div class="alert alert-success" role="alert">
                                        {{ Session::get('msg') }}
                                    </div>
                                @endif
                            </div>
                            @foreach($friends as $friend)
                                <div class="col-sm-3">
                                    <div class="card" style="width: 100%;">
                                        <img class="card-img-top" src="{{url('/')}}/user-img/{{ $friend->pic }}" height="150px" alt="Card image cap">
                                        <div class="card-body" style="padding-bottom: 0;">
                                            <h5 class="card-title text-center"><a href="{{url('/profile')}}/{{$friend->slug}}">{{ucwords($friend->name)}}</a></h5>
                                            <p class="text-center">
                                                <a href="{{url('/un-friend/'.$friend->id)}}"  class="btn btn-info btn-sm">UnFriend</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

