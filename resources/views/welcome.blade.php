@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div style="margin-top:50px;"
                 class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">User Login Box</div>
                    </div>

                    <div style="padding-top:30px" class="panel-body">

                        <form method="post" action="/login" class="form-horizontal" role="form">

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input required id="login-username" type="text" class="form-control" name="username"
                                       value=""
                                       placeholder="username">
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <input required id="login-password" type="password" class="form-control" name="password"
                                       placeholder="password">
                            </div>
                            {{csrf_field()}}

                            @if(Session::has('status'))
                                <div class="alert alert-danger">
                                    {{Session::get('status')}}
                                </div>
                            @endif
                            @if (count($errors) >0 && session('type') == 'login')
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div style="margin-top:10px" class="form-group">
                                <!-- Button -->
                                <div class="col-sm-12 controls">
                                    <button id="btn-login" href="#" class="btn btn-success">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection