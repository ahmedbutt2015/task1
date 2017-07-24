@section('content')
    <div class="container">
        @if(Session::has('exception'))
            <div class="alert alert-danger">
                {{Session::get('exception')}}
            </div>
        @endif

        <div class="col-md-3 well">
            <h3>Register User</h3>
            <form action="/register" method="post" role="form" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control"
                           placeholder="Username"
                           value="">
                </div>
                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="name" tabindex="1" class="form-control"
                           placeholder="Name"
                           value="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control"
                           placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="files">Select Image</label>
                    <input type="file" id="files" name="image" tabindex="2"
                           class="form-control"
                           placeholder="Image">
                </div>
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
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <input type="submit" name="register-submit" id="register-submit" tabindex="4"
                                   class="form-control btn btn-success" value="Register Now">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-9">
            <h3>All Users</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                @foreach($users as $user)
                    <tr data-id="{{$user->id}}">
                        <td>
                            <img class="img" height="60px" src="/img/{{$user->image}}" alt="">
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->username}}</td>
                        <td class="text-center">
                            <a class='btn btn-info btn-xs edit_button' data-toggle="modal" data-target="#editModal"
                               data-name="{{$user->name}}"
                               data-id="{{$user->id}}"
                               data-username="{{$user->username}}"
                               data-image="{{$user->image}}"
                               href="#">Edit</a>
                            <a href="#" class="delete btn btn-danger btn-xs">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                        </div>
                        <form method="post" action="/edit/user" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input class="form-control" id="edit-input-id" type="hidden" name="user_id">
                                <div class="form-group">
                                    <label for="">Name : </label>
                                    <input class="form-control" id="edit-input-name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Username : </label>
                                    <input class="form-control" id="edit-input-username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Password :
                                        <small>(optional)</small>
                                    </label>
                                    <input class="form-control" name="pass" type="password">
                                </div>
                                <div class="form-group">
                                    <img class="img" height="60px" id="edit-img" src="" alt="">
                                    <br>
                                    <label for="">Change Image : </label>
                                    <input class="form-control" type="file" name="image">
                                </div>
                                {{csrf_field()}}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('a.delete').click(function () {
            var parent = $(this).parent().parent();
            $.ajax({
                type: 'get',
                url: '/delete/user/' + $(parent).attr('data-id'),
                success: function (res) {
                    if (!res.error) {
                        parent.slideUp(1000, function () {
                            parent.remove();
                        });
                    }
                }
            });
        })

        $(document).on("click", '.edit_button', function (e) {
            var name = $(this).data('name');
            var id = $(this).data('id');
            var username = $(this).data('username');
            var image = $(this).data('image');

            $("#edit-input-id").val(id);
            $("#edit-input-name").val(name);
            $("#edit-input-username").val(username);
            $("#edit-img").attr('src', '/img/' + image);
        });
    </script>
@endsection