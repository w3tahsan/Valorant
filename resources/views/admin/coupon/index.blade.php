@extends('layouts.dashboard')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon List</h3>
                </div>

                <div class="card-body">
                    <form action="{{url('/mark/delete')}}" method="POST">
                        @csrf
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Coupon Code</th>
                            <th>Discount</th>
                            <th>Validity</th>
                            <th>Created At</th>
                        </tr>

                        @foreach ($coupons as $key=>$coupons)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$coupons->coupon_code}}</td>
                            <td>{{$coupons->discount}}</td>
                            <td>{{$coupons->validity}}</td>
                            <td>{{$coupons->created_at->diffForhumans()}}</td>
                        </tr>
                        @endforeach
                    </table>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Coupon</h3>
                </div>

                <div class="card-body">
                    <form action="{{url('/coupon/insert')}}" method="POST">
                        @csrf
                        <div class="mt-3">
                            <label for="" class="form-label">Coupon coded</label>
                            <input type="text" class="form-control" name="coupon_code">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Discount %</label>
                            <input type="text" class="form-control" name="discount">
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Validity</label>
                            <input type="date" class="form-control" name="validity">
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Add Coupon</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
