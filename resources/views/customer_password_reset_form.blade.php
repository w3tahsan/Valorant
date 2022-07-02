@extends('frontend.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="card my-5">
                    <div class="card-header">
                        <h3>Send Reset Link</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('customer_pass_update')}}" method="POST">
                            @csrf
                            <div class="mt-3">
                                <input type="text" name="token" class="form-control" value="{{$token}}">
                                <input type="password" name="password" class="form-control" placeholder="password">
                            </div>
                            <div class="mt-3">
                                <input type="password" name="conpassword" class="form-control" placeholder="Con password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection