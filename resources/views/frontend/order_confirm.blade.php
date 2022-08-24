@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>My Account</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-8 m-auto">
            @if (session('order_success'))
                <div class="alert alert-success">
                    <h2>{{ session('order_success') }}</h2>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
