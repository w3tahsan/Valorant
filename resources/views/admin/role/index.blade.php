@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Permission List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Permission Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($permissions as $key=>$permission)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$permission->name}}</td>
                            <td>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>Role List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($roles as $key=>$role)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$role->name}}</td>
                            <td>
                                @foreach ($role->getPermissionNames() as $permission)
                                    <span class="badge badge-primary mb-1">{{$permission}}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <br>
            <div class="card">
                <div class="card-header">
                    <h3>Users Assigned Role</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>User</th>
                            <th>Role</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$user->name}}</td>
                            <td>
                                @if (count($user->getRoleNames()) != 0)
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="badge badge-primary mb-1">{{$role}}</span>
                                    @endforeach
                                @else
                                Not Assign Yet
                                @endif
                            </td>
                            <td>
                                @if (count($user->getAllPermissions()) != 0)
                                @foreach ($user->getAllPermissions() as $permission)
                                        <span class="badge badge-primary mb-1">{{$permission->name}}</span>
                                @endforeach
                                @else
                                Not Assign Yet
                                @endif
                            </td>
                            <td>
                                <a href="{{route('role.edit', $user->id)}}" class="btn btn-success">edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Permission</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('permission.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label">Permission Name</label>
                            <input type="text" class="form-control" name="permission_name">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <br>

            <div class="card">
                <div class="card-header">
                    <h3>Add Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('role.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label">Role Name</label>
                            <input type="text" class="form-control" name="role_name">
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Assign Permission</label>
                            @foreach ($permissions as $permission)
                            <br>
                                <input type="checkbox" value="{{$permission->name}}" name="permission[]"> {{$permission->name}}
                            @endforeach
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Assign Role</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('role.assign')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <select name="user_id" class="form-control">
                                <option value="">-- Select User --</option>
                                @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="role" class="form-control">
                                <option value="">-- Select Role --</option>
                                @foreach ($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection