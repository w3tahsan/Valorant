@extends('layouts.dashboard')

@section('content')
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Category</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{url('/category/update')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mt-3">
                                <label for="" class="form-label">Category Name</label>
                                <input type="hidden" class="form-control" name="id" value="{{$category_info->id}}">
                                <input type="text" class="form-control" name="category_name" value="{{$category_info->category_name}}">
                                @error('category_name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="" class="form-label">Category Image</label>
                                <input type="file" class="form-control" name="category_image">
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
