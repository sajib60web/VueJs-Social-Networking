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
                        <div class="col-sm-12 col-md-12">
                        @if ( session()->has('msg') )
                            <p class="alert alert-success">
                                {{ session()->get('msg') }}
                            </p>
                        @endif
                        @foreach($notes as $note)
                            <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                                <ul>
                                    <li>
                                        <p>
                                            <a href="{{url('/profile')}}/{{$note->slug}}" style="font-weight: bold; color:green">
                                                {{$note->name}}</a> {{$note->note}}
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

