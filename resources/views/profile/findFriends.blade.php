@extends('profile.master')
@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Profile</a></li>
                <li class="breadcrumb-item"><a href="">Find Friends</a></li>
            </ol>
        </nav>
        <div class="row">
            @include('profile.sidebar')
            <div class="col-sm-9">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{Auth::user()->name}}</h5>
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
                                        <?php
                                        $check = DB::table('friendships')
                                            ->where('user_requested', '=', $friend->id)
                                            ->where('requester', '=', Auth::user()->id)
                                            ->first();
                                        ?>
                                        @if ($check == '')
                                            <p style="text-align: center;">
                                                <a href="{{url('/addFriend/'.$friend->id)}}" class="btn btn-info btn-sm">Add to Friend</a>
                                            </p>
                                        @else
                                            <p style="text-align: center;">
                                                <a href="{{url('/requested-cancel/'.$friend->id)}}" class="btn btn-danger btn-sm">Request Sent</a>
                                            </p>
                                        @endif
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

