@extends('layouts.dashboard')

@section('content')
@can('show_product')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Product List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Discount</th>
                                    <th>After Discount</th>
                                    <th>Brand Name</th>
                                    <th>Description</th>
                                    <th>Preview</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $key=>$product)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ number_format($product->product_price) }}</td>
                                    <td>{{ $product->product_discount }}</td>
                                    <td>{{ number_format($product->after_discount) }}</td>
                                    <td>{{ $product->brand }}</td>
                                    <td>{{ $product->short_description}}</td>
                                    <td>
                                        <img width="50" src="{{ asset('/uploads/product/preview/') }}/{{ $product->preview }}" alt="">
                                    </td>
                                    <td class="d-flex">
                                        <a href="{{ route('inventory', $product->id) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                            <i class="fa fa-archive"></i>
                                        </a>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h3 class="text-white">Add Product</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/product/insert') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <select name="category_id" class="form-control" id="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <select name="subcategory_id" class="form-control" id="subcategory_name">
                                    <option value="">-- Select Sub Category --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_name" placeholder="Product Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_price" placeholder="Product Price">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="discount" placeholder="Product Discount %">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="brand_name" placeholder="Brand Name">
                            </div>
                            <div class="form-group">
                                <textarea name="short_description" class="form-control" placeholder="Short Description"></textarea>
                            </div>
                            <div class="form-group">
                                <textarea id="summernote" name="description" class="form-control" placeholder="Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="product_preview">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Product Thumbnails</label>
                                <input type="file" multiple class="form-control" name="product_thumbnails[]">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-warning">
                <h5>Sorry as agorib people, we can not allow to show this page, u can apply for boroloks here <a href="" class="btn btn-primary">Apply Boroloks</a></h5>
            </div>
        </div>
    </div>
</div>    
@endcan
@endsection

@section('footer_script')
<script>
    $('#category_id').change(function(){
        var category_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getCategory',
            data:{'category_id':category_id},
            success:function(data){
                $('#subcategory_name').html(data);
            }
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('#category_id').select2();
        $('#summernote').summernote();
    });
</script>
@endsection
