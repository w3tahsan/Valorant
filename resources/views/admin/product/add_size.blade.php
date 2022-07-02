@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashbaord</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Size</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Size List</h3>
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
                            @foreach ($sizes as $key=>$size)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $size->size_name }}</td>
                                <td>{{ $size->created_at->diffForHumans() }}</td>
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
                    <h3>Add Size</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/size/insert') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="" class="form-label">Size name</label>
                            <input type="text" class="form-control" name="size_name">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
