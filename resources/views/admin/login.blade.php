@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="center-block" id="wellcome-header">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2>Welcome to Clickgo Admin Panel</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="well col-md-6" id="well-box">
                    <div class="alert alert-info">
                        Please login with your Username and Password.
                    </div>
                    <form method="post" action="/login" class="form-horizontal" role="form">

                        <input type="hidden" name="admin" value="true">
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
                        @if (count($errors) >0 )
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
                                <button id="btn-login" href="#" class="btn btn-success btn-block">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection