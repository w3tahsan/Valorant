@extends('layouts.dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>

                <div class="card-body">
                    <form action="{{url('/mark/delete')}}" method="POST">
                        @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th><input type="checkbox" class="checkall"> check all</th>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($categories as $key=>$category)
                        <tr>
                            <td>
                                <input type="checkbox" name="mark[]" class="checkme" value="{{$category->id}}">
                            </td>
                            <td>{{$key+1}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>{{$category->user->name}}</td>
                            <td><img width="50" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                            <td>{{$category->created_at < now()->subDays(30)?$category->created_at:$category->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('category.edit', $category->id)}}" class="btn btn-success shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                                <a href="{{route('category.delete', $category->id)}}" class="btn btn-danger shadow btn-xs sharp mr-1"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @if($categories->count() != 0)
                        <button type="submit" class="btn btn-danger">Delete checked</button>
                    @endif
                    </form>
                </div>
            </div>


            <div class="card mt-5">
                <div class="card-header">
                    <h3>Trash Category List</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th><input type="checkbox" class="checkall2"> check all</th>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($trash_categories as $key=>$category)
                        <tr>
                            <td>
                                <input type="checkbox" name="mark[]" class="checkme2" value="{{$category->id}}">
                            </td>
                            <td>{{$key+1}}</td>
                            <td>{{$category->category_name}}</td>
                            <td>{{App\Models\User::find($category->added_by)->name}}</td>
                            <td><img width="50" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                            <td>{{$category->created_at < now()->subDays(30)?$category->created_at:$category->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('category.restore', $category->id)}}" class="btn btn-success">restore</a>
                                <a href="{{route('category.force_delete', $category->id)}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No data found</td>
                        </tr>
                        @endforelse

                    </table>
                </div>
            </div>


        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Category</h3>
                </div>

                <div class="card-body">
                    <form action="{{url('/category/insert')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3">
                            @php
                                $fonts = array (
                                    'fa-500px',
                                    'fa-address-book',
                                    'fa-address-book-o',
                                    'fa-address-card',
                                    'fa-address-card-o',
                                    'fa-adjust',
                                    'fa-yahoo',
                                    'fa-youtube',
                                    'fa-youtube-play',
                                    'fa-youtube-square',
                                    );
                             
                            @endphp 

                            @foreach ($fonts as $icon)
                                <i style="font-size:30px; margin:10px;" class="fa {{$icon}}"></i>
                            @endforeach        
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Icon</label>
                            <input type="text" id="icon" style="color:transparent" class="form-control " name="icon">
                            <i id="abc"></i>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category_name">
                            @error('category_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="category_image">
                            @error('category_image')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Category</button>
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

    @if (session('dad'))
        <script>
            Swal.fire(
            'Good job!',
            '{{session('dad')}}',
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
        <script>
           
            $('.fa').click(function(){
                let icon_class = $(this).attr('class');
                $('#icon').val(icon_class)
                $('#abc').attr('class', icon_class)
            });
        </script>

@endsection
