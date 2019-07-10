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
                    <div class="modal-body">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="{{url('/')}}/user-img/{{Auth::user()->pic}}" alt="Card image cap">
                            <div class="card-body">
                                <form action="{{url('/')}}/uploadPhoto" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="pic" class="form-control-file"/><br>
                                    <button type="submit" class="btn btn-success" name="btn">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
