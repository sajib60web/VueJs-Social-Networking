@extends('profile.master')
@section('content')
    <div class="container">
        <div class="row">
            @include('profile.sidebar')

            <div class="col-md-9">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ ucwords(Auth::user()->name) }}</h5>
                        </button>
                    </div>
                    @foreach($userData as $uData)
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="card" style="width: 100%;">
                                    <h5 class="modal-title text-center pt-5">{{ ucwords($uData->name) }}</h5>
                                    <img class="card-img-top profile" src="{{url('/')}}/user-img/{{$uData->pic}}" alt="Card image cap">
                                    <h5 class="card-title text-center">
                                        @if ($uData->user_id == Auth::user()->id)
                                        <a href="{{ url('/edit-profile') }}" class="btn btn-primary">Edit Profile</a>
                                        @else
                                        <a href="{{ url('/view-profile') }}" class="btn btn-primary">View Profile</a>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h4 class=""><span class="badge badge-success">About</span></h4>
                                <p> {{$uData->about}} </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

