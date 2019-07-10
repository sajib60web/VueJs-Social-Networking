<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .breadcrumb-item+.breadcrumb-item:before {
            display: inline-block;
            padding-right: .5rem;
            color: #6c757d;
            content: "";
        }
        a{
            text-decoration: none !important;
        }
        .msg_main{
            background-color:#ffff;
            border-left:5px solid #F5F8FA;
            position: absolute;
            left: calc(25%);
        }
        .msg_right{
            background-color:#ffff;
            border-left:5px solid #F5F8FA;
            min-height:600px;
            position:fixed;
            right:0px
        }
        .msgDiv{
            position:fixed; left:0
        }
        .left-sidebar li { padding:10px;
            border-bottom:1px solid #ddd;
            list-style:none; margin-left:-20px}
        .msgDiv li:hover{
            cursor:pointer;
        }
        .jobDiv{border:1px solid #ddd; margin:10px; width:30%; float:left; padding:10px; color:#000}
        .caption li {list-style:none !important; padding:5px}
        .jobDiv .company_pic{width:50px; height:50px; margin:5px}
        .jobDetails h4{border:1px solid green; width:60%;
            padding:5px; margin:0 auto; text-align:center; color:green}
        .jobDetails .job_company{padding-bottom:10px; border-bottom:1px solid #ddd; margin-top:20px}
        .jobDetails .job_point{color:green; font-weight:bold}
        .jobDetails .email_link{padding:5px; border:1px solid green; color:green}
        .profile {
            height: 300px;
            padding: 30px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @auth
                        <li><a class="navbar-brand" href="{{url('/findFriends')}}">Find Friends </a></li>
                        <li>
                            <a class="navbar-brand" href="{{url('/requests')}}">Friend Request
                                <span style="color:green; font-weight:bold; font-size:16px">
                                    ({{App\Friendship::where('status', 0)
                                      ->where('user_requested', Auth::user()->id)
                                      ->count()}})
                                </span>
                            </a>
                        </li>
                    @endauth
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown" href="{{url('/friends')}}" title="friends">
                                <i class="fas fa-users fa-2x"></i>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-globe-asia fa-2x"></i>
                                <span class="badge" style="background:red; position: relative; top: -15px; left:-10px">
                                    {{App\Notifications::where('status', 1)
                                     ->where('user_hero', Auth::user()->id)
                                      ->count()}}
                                </span>
                            </a>
                            <?php
                                $notes = DB::table('users')
                                    ->leftJoin('notifications', 'users.id', 'notifications.user_logged')
                                    ->where('user_hero', Auth::user()->id)
                                    ->orderBy('notifications.created_at', 'desc')
                                    ->get();
                            ?>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="min-width: 320px;">
                                @foreach($notes as $note)
                                <a class="dropdown-item" href="{{url('/notifications')}}/{{$note->id}}">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <img src="{{url('/')}}/user-img/{{$note->pic}}" style="width:50px; padding:5px; background:#fff; border:1px solid #eee" class="img-rounded">
                                        </div>
                                        <div class="col-sm-10">
                                            <b style="color:green; font-size:90%">{{ucwords($note->name)}}</b>
                                            <span style="color:#000; font-size:90%">{{$note->note}}</span>
                                            <br/>
                                            <small style="color:#90949C"> <i aria-hidden="true" class="fa fa-users"></i>
                                                {{date('F j, Y', strtotime($note->created_at))}}
                                                at {{date('H: i', strtotime($note->created_at))}}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                </a>
                                @endforeach
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <img src="{{ url('/')}}/user-img/{{Auth::user()->pic}}" width="30px" height="30px" style="border-radius: 50%;" />
                                <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('profile') }}/{{ Auth::user()->slug }}">
                                    {{ __('Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ url('edit-profile') }}">
                                    {{ __('Edit Profile') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
