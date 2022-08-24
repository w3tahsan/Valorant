@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashbaord</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Color</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Color List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Color List</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $key=>$color)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $color->color_name }}</td>
                                <td>{{ $color->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="#" class="btn btn-danger shadow btn-xs sharp mr-1">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Colors</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/color/insert') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label">color name</label>
                            <input type="text" class="form-control" name="color_name">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
