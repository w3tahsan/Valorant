@extends('layouts.dashboard')

@section('content')

<div class="container-fluid">
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashbaord</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Inventory</a></li>
        </ol>
    </div>
    @can('add_inventory')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Inventory List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Color Name</th>
                                <th>Size Name</th>
                                <th>Quantity</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inventories as $key=>$inventory)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $inventory->rel_to_product->product_name }}</td>
                                <td>{{ $inventory->rel_to_color->color_name }}</td>
                                <td>{{ $inventory->rel_to_size->size_name }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>{{ $inventory->created_at->diffForHumans() }}</td>
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
                    <h3>Add Inventory</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('/inventory/insert') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" readonly class="form-control" value="{{ $product_info->product_name }}">
                        </div>
                        <div class="form-group">
                           <input type="hidden" name="product_id" value="{{ $product_info->id }}">
                            <select name="color_id" class="form-control">
                                <option value="">-- Select Color --</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="size_id" class="form-control">
                                <option value="">-- Select Color --</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Add Inventory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endcan
</div>
@endsection
