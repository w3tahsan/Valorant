@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Sub Category List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($subcategories as $key=>$subcategory)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{!!($subcategory->rel_to_category->deleted_at == NULL?$subcategory->rel_to_category->category_name:$subcategory->rel_to_category->category_name.' <span class="badge bg-secondary"> soft Deleted</span>')!!}</td>
                                <td>{{$subcategory->subcategory_name}}</td>
                                <td>{{$subcategory->created_at->diffForHumans()}}</td>
                                <td>
                                    <a href="{{route('subcategory.delete', $subcategory->id)}}" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
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
                    <h3>Add Sub Category</h3>
                </div>

                <div class="card-body">
                    <form action="{{url('/subcategory/insert')}}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Sub Category Name</label>
                            <input type="text" class="form-control" name="subcategory_name">
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add SubCategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    @if (session('success'))
        <script>
            Swal.fire(
            'Good job!',
            '{{session('success')}}',
            'success'
            )
        </script>
    @endif

    @if (session('delete'))
        <script>
            Swal.fire(
            'Good job!',
            '{{session('delete')}}',
            'success'
            )
        </script>
    @endif

        <script>
           $(function(){
            $('.checkall').click(function(){
                var checked = $(this).prop('checked');
                $('.checkme').prop('checked', checked);
            });
           })
        </script>

        <script>
            $(function(){
            $('.checkall2').click(function(){
                var checked = $(this).prop('checked');
                $('.checkme2').prop('checked', checked);
            });
            })
        </script>

@endsection
