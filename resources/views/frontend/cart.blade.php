@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Cart</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<!-- cart_section - start
            ================================================== -->
            <section class="cart_section section_space">
                <div class="container">

                    <div class="cart_table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($carts as $cart)
                                <tr>
                                    <td>
                                        <div class="cart_product">
                                            <img src="{{ asset('uploads/product/preview') }}/{{ $cart->product->preview }}" alt="image_not_found">
                                            <h3><a href="shop_details.html">{{ $cart->product->product_name }}</a></h3>
                                        </div>
                                    </td>
                                    <td class="text-center abc"><span class="price_text">{{ $cart->product->after_discount }}</span></td>
                                    <td class="text-center abc">
                                        <form action="{{ url('/cart/update') }}" method="POST">
                                            @csrf
                                            <div class="quantity_input">
                                                <button type="button" class="input_number_decrement">
                                                    <i data-price="{{ $cart->product->after_discount }}" class="fal fa-minus"></i>
                                                </button>
                                                <input name="quantity[{{ $cart->id }}]" class="input_number8" type="text" value="{{ $cart->quantity }}" />
                                                <button type="button" class="input_number_increment">
                                                    <i data-price="{{ $cart->product->after_discount }}" class="fal fa-plus"></i>
                                                </button>
                                            </div>

                                    </td>
                                    <td class="text-center abc">{{ $cart->product->after_discount*$cart->quantity }}</td>
                                    <td class="text-center"><a href="{{ route('cart.delete', $cart->id) }}" class="remove_btn"><i class="fal fa-trash-alt"></i></a></td>
                                </tr>
                                @php
                                    $total += $cart->product->after_discount*$cart->quantity;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="cart_btns_wrap">
                        <div class="row">
                            <div class="col col-lg-6">
                                <ul class="btns_group ul_li_right">
                                    <li><button class="btn border_black" type="submit">Update Cart</button></li>
                                </form>
                                    @php
                                        session([
                                            'discount'=>$discount,
                                        ])
                                    @endphp
                                    <li><a class="btn btn_dark" href="{{ route('checkout') }}">Prceed To Checkout</a></li>
                                </ul>
                            </div>
                            <div class="col col-lg-6">
                                <form action="{{ url('/cart') }}" method="GET">
                                    <div class="coupon_form form_item mb-0">
                                        <input type="text" name="coupon" value="{{ @$_GET['coupon'] }}" placeholder="Coupon Code...">
                                        <button type="submit" class="btn btn_dark">Apply Coupon</button>
                                        <div class="info_icon">
                                            <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Info Here"></i>
                                        </div>
                                    </div>
                                    @if ($message)
                                        <div class="alert alert-warning mt-3">{{ $message }}</div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">


                        <div class="col col-lg-12">
                            <div class="cart_total_table">
                                <h3 class="wrap_title">Cart Totals</h3>
                                <ul class="ul_li_block">
                                    <li>
                                        <span>Cart Subtotal</span>
                                        <span>{{ $total }}</span>
                                    </li>
                                    <li>
                                        <span>Discount %</span>
                                        <span>{{ $discount }}</span>
                                    </li>
                                    <li>
                                        <span>Discount Amount</span>
                                        <span>{{ ($total*$discount) / 100 }}</span>
                                    </li>
                                    <li>
                                        <span>Order Total</span>
                                        <span class="total_price">{{ $total - ($total*$discount) / 100 }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- cart_section - end
            ================================================== -->

@endsection

@section('footer_script')
    <script>
        let quantity_input = document.querySelectorAll('.abc')
        let arr = Array.from(quantity_input)

        arr.map(item=>{
            item.addEventListener('click', function(e){
                if(e.target.className == 'fal fa-plus'){
                   e.target.parentElement.previousElementSibling.value++
                   let quantity = e.target.parentElement.previousElementSibling.value
                   let price = e.target.dataset.price
                   item.nextElementSibling.innerHTML = price*quantity
                }
                if(e.target.className == 'fal fa-minus'){

                   if(e.target.parentElement.nextElementSibling.value > 1){
                    e.target.parentElement.nextElementSibling.value--
                    let quantity = e.target.parentElement.nextElementSibling.value
                    let price = e.target.dataset.price
                    item.nextElementSibling.innerHTML = price*quantity
                   }
                }
            })
        });


    </script>
@endsection
