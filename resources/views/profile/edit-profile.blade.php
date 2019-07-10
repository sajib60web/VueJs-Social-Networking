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
                        <h5 class="modal-title">{{Auth::user()->name}}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="card mb-4" style="width: 100%;">
                                <img style="height: 200px;" class="card-img-top" src="{{url('/')}}/user-img/{{Auth::user()->pic}}" alt="Card image cap">
                                <div class="card-body" style="padding-bottom: 0px;">
                                    <h5 class="card-title">{{$data->city}} - {{$data->country}}</h5>
                                    <h5 class="card-title text-center"><a href="{{url('/')}}/changePhoto"  class="btn btn-primary" role="button">Change Image</a></h5>
                                </div>
                            </div><br>
                            <div class="col-md-4">
                                <form action="{{url('/updateProfile')}}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>City Name</label>
                                        <input type="text" class="form-control" placeholder="City Name" name="city" value="{{$data->city}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Country Name</label>
                                        <input type="text" class="form-control" placeholder="Country Name" name="country" value="{{$data->country}}">
                                    </div>
                                    <div class="form-group">
                                        <label>About</label>
                                        <textarea class="form-control" name="about" rows="3">
                                            {{$data->about}}
                                        </textarea>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success pull-right" value="Update Profile">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
