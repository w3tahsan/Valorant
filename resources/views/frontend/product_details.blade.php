@extends('frontend.master')
@section('content')
 <!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Product Details</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->


<!-- product_details - start
            ================================================== -->
            <section class="product_details section_space pb-0">
                <div class="container">
                    <div class="row">
                        <div class="col col-lg-6">
                            <div class="product_details_image">
                                <div class="details_image_carousel">
                                    @foreach ($product_info->rel_to_thumbnail as $thumb)
                                    <div class="slider_item">
                                        <img src="{{ asset('/uploads/product/thumbnails') }}/{{ $thumb->product_thumbnails }}" alt="image_not_found">
                                    </div>
                                    @endforeach
                                </div>

                                <div class="details_image_carousel_nav">
                                    @foreach ($product_info->rel_to_thumbnail as $thumb)
                                    <div class="slider_item">
                                        <img src="{{ asset('/uploads/product/thumbnails') }}/{{ $thumb->product_thumbnails }}" alt="image_not_found">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @php

                            $avg = 0;
                            if(count($review) > 0){
                                $avg = round($review->sum('star')/count($review));
                            }
                        @endphp
                        <div class="col-lg-6">
                            <div class="product_details_content">
                                <h2 class="item_title">{{ $product_info->product_name }}</h2>
                                <p>{{ $product_info->short_description }}</p>
                                <div class="item_review">
                                    <ul class="rating_star ul_li">
                                        @for($i=1; $i<=$avg; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                        @endfor
                                    </ul>
                                    <span class="review_value">{{$avg}} Rating(s)</span>
                                </div>

                                <div class="item_price">
                                    <span>TK <span id="price">{{ $product_info->after_discount }}</span></span>
                                    @if ($product_info->product_discount)
                                    <del>TK {{ $product_info->product_price }}</del>
                                    @endif
                                </div>
                                <hr>

                                <div class="item_attribute">
                                    <form action="{{ url('/cart/insert') }}" method="POST">
                                        @csrf

                                        <div class="row">
                                            <div class="col-lg-6 my-3">
                                                @if (App\Models\Inventory::where('product_id', $product_info->id)->where('color_id', 11)->exists())
                                                <input type="hidden" name="color_id" value="{{ App\Models\Inventory::where('product_id', $product_info->id)->first()->color_id}}">
                                                @else
                                                <div class="form-group ">
                                                    <select id="color_id" name="color_id" class="form-select">
                                                        <option value="">Select Color</option>
                                                        @foreach ($available_colors as $colors)
                                                            <option value="{{ $colors->color_id }}">{{ $colors->rel_to_color->color_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-lg-6 my-3">
                                                @if (App\Models\Inventory::where('product_id', $product_info->id)->where('color_id', $available_colors->first()->color_id)->where('size_id', 6)->exists())
                                                <input type="hidden" name="size_id" value="{{ App\Models\Inventory::where('product_id', $product_info->id)->first()->size_id}}">
                                                @else
                                                <div class="form-group" >
                                                    <select id="size_id" name="size_id" class="form-select">
                                                        <option value="">Select Size</option>
                                                    </select>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="quantity_wrap">
                                        <div class="quantity_input">
                                            <button type="button" class="input_number_decrement">
                                                <i class="fal fa-minus"></i>
                                            </button>
                                            <input class="input_number" name="quantity" type="text" value="1">
                                            <button type="button" class="input_number_increment">
                                                <i class="fal fa-plus"></i>
                                            </button>
                                        </div>
                                        <div class="total_price">Total: TK <span id="total">{{ $product_info->after_discount }}</span></div>
                                    </div>

                                    <ul class="default_btns_group ul_li">
                                        <input class="" name="product_id" type="hidden" value="{{ $product_info->id }}">
                                        @auth('customerlogin')
                                        <li><button type="submit" class="btn btn_primary addtocart_btn">Add To Cart</button></li>
                                        @if (session('stockout'))
                                            <div class="alert alert-warning">{{session('stockout')}}</div>
                                        @endif
                                        @else
                                        <li><a class="btn btn_primary addtocart_btn" href="{{ route('register') }}">Add To Cart</a></li>
                                        @endauth
                                    </ul>

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="details_information_tab">
                        <ul class="tabs_nav nav ul_li" role=tablist>
                            <li>
                                <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button" role="tab" aria-controls="description_tab" aria-selected="true">
                                Description
                                </button>
                            </li>
                            <li>
                                <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button" role="tab" aria-controls="additional_information_tab" aria-selected="false">
                                Additional information
                                </button>
                            </li>
                            <li>
                                <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab" aria-controls="reviews_tab" aria-selected="false">
                                Reviews({{count($review)}})
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                                <p> {!! $product_info->long_description !!} </p>
                            </div>

                            <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                                <p>
                                Return into stiff sections the bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked what's happened to me he thought It wasn't a dream. His room, a proper human room although a little too small
                                </p>

                                <div class="additional_info_list">
                                    <h4 class="info_title">Additional Info</h4>
                                    <ul class="ul_li_block">
                                        <li>No Side Effects</li>
                                        <li>Made in USA</li>
                                    </ul>
                                </div>

                                <div class="additional_info_list">
                                    <h4 class="info_title">Product Features Info</h4>
                                    <ul class="ul_li_block">
                                        <li>Compatible for indoor and outdoor use</li>
                                        <li>Wide polypropylene shell seat for unrivalled comfort</li>
                                        <li>Rust-resistant frame</li>
                                        <li>Durable UV and weather-resistant construction</li>
                                        <li>Shell seat features water draining recess</li>
                                        <li>Shell and base are stackable for transport</li>
                                        <li>Choice of monochrome finishes and colourways</li>
                                        <li>Designed by Nagi</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="reviews_tab" role="tabpanel">
                                <div class="average_area">
                                    <div class="row align-items-center">
                                        <div class="col-md-12 order-last">
                                            <div class="average_rating_text">
                                                <ul class="rating_star ul_li_center">
                                                    @for($i=1; $i<=$avg; $i++)
                                                        <li><i class="fas fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                                <p class="mb-0">
                                                Average Star Rating: <span>{{round($avg)}} out of 5</span> ({{count($review)}} vote)
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="customer_reviews">
                                    <h4 class="reviews_tab_title">{{count($review)}} reviews for this product</h4>
                                    @foreach ($review as $rev)
                                    <div class="customer_review_item clearfix">
                                        <div class="customer_image">
                                            <img src="{{asset('front/images/team/team_1.jpg')}}" alt="image_not_found">
                                        </div>
                                        <div class="customer_content">
                                            <div class="customer_info">
                                                <ul class="rating_star ul_li">
                                                    @for ($i=1; $i<=$rev->star; $i++)
                                                        <li><i class="fas fa-star"></i></li>
                                                    @endfor

                                                </ul>
                                                <h4 class="customer_name">{{$rev->rel_to_user->name}}</h4>
                                                <span class="comment_date">{{$rev->updated_at}}</span>
                                            </div>
                                            <p class="mb-0">{{$rev->review}}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>


                                @auth('customerlogin')
                                @if(App\Models\OrderProductDetails::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->id)->exists())

                                @if (App\Models\OrderProductDetails::where('user_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->id)->where('review', '!=', null)->first() == false)

                                <div class="customer_review_form">
                                    <h4 class="reviews_tab_title">Add a review</h4>
                                    <form action="{{route('product.review', $product_info->id)}}" method="POST">
                                        @csrf
                                        <div class="form_item">
                                            <input type="text" readonly placeholder="Your name*" value="{{Auth::guard('customerlogin')->user()->name}}">
                                        </div>
                                        <div class="form_item">
                                            <input type="email" readonly value="{{Auth::guard('customerlogin')->user()->email}}" placeholder="Your Email*">
                                        </div>
                                        <div class="your_ratings">
                                            <h5>Your Ratings:</h5>
                                            <button type="button" data-star="1" class="star_amount"><i class="fal fa-star"></i></button>
                                             <button type="button" data-star="2" class="star_amount"><i class="fal fa-star"></i></button>
                                            <button type="button" data-star="3" class="star_amount"><i class="fal fa-star"></i></button>
                                            <button type="button" data-star="4" class="star_amount"><i class="fal fa-star"></i></button>
                                            <button type="button" data-star="5" class="star_amount"><i class="fal fa-star"></i></button>
                                            <input type="hidden" name="star" id="star">
                                        </div>
                                        <div class="form_item">
                                            <textarea name="review" placeholder="Your Review"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn_primary">Submit Now</button>
                                    </form>
                                </div>
                                @else
                                <div href="" class="alert alert-info pb-3">
                                    Already Reviewed
                                </div>
                                @endif
                                @else
                                <div href="" class="alert alert-info pb-3">
                                    You have not buy this product yet
                                </div>
                                @endif

                                @else
                                <div href="" class="alert alert-info pb-3">
                                    Please Login to Review
                                    <a href="{{route('customer.register.form')}}" class="btn btn-primary float-end ">Login Here</a>
                                </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- product_details - end
            ================================================== -->

            <!-- related_products_section - start
            ================================================== -->
            <section class="related_products_section section_space">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="best-selling-products related-product-area">
                                <div class="sec-title-link">
                                    <h3>Related products</h3>
                                    <div class="view-all"><a href="#">View all<i class="fal fa-long-arrow-right"></i></a></div>
                                </div>
                                <div class="product-area row clearfix">
                                    @foreach ($related_product as $related)
                                    <div class="grid col-lg-3">
                                        <div class="product-pic">
                                            <img src="{{ asset('/uploads/product/preview') }}/{{ $related->preview }}" alt>
                                            <div class="actions">
                                                <ul>
                                                    <li>
                                                        <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Favourite</title> <path d="M12,21 L10.55,19.7051771 C5.4,15.1242507 2,12.1029973 2,8.39509537 C2,5.37384196 4.42,3 7.5,3 C9.24,3 10.91,3.79455041 12,5.05013624 C13.09,3.79455041 14.76,3 16.5,3 C19.58,3 22,5.37384196 22,8.39509537 C22,12.1029973 18.6,15.1242507 13.45,19.7149864 L12,21 Z"/> </svg></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><svg role="img" xmlns="http://www.w3.org/2000/svg" width="48px" height="48px" viewBox="0 0 24 24" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Shuffle</title> <path d="M21 16.0399H17.7707C15.8164 16.0399 13.9845 14.9697 12.8611 13.1716L10.7973 9.86831C9.67384 8.07022 7.84196 7 5.88762 7L3 7"/> <path d="M21 7H17.7707C15.8164 7 13.9845 8.18388 12.8611 10.1729L10.7973 13.8271C9.67384 15.8161 7.84196 17 5.88762 17L3 17"/> <path d="M19 4L22 7L19 10"/> <path d="M19 13L22 16L19 19"/> </svg></a>
                                                    </li>
                                                    <li>
                                                        <a class="quickview_btn" data-bs-toggle="modal" href="#quickview_popup" role="button" tabindex="0"><svg width="48px" height="48px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#2329D6" stroke-width="1" stroke-linecap="square" stroke-linejoin="miter" fill="none" color="#2329D6"> <title>Visible (eye)</title> <path d="M22 12C22 12 19 18 12 18C5 18 2 12 2 12C2 12 5 6 12 6C19 6 22 12 22 12Z"/> <circle cx="12" cy="12" r="3"/> </svg></a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <h4><a href="{{ route('product.details', $related->id) }}">{{ $related->product_name }}</a></h4>
                                            <p><a href="{{ route('product.details', $related->id) }}">{{ $related->short_description }} </a></p>
                                            <div class="rating">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                            <span class="price">
                                                <ins>
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi>
                                                            <span class="woocommerce-Price-currencySymbol">TK </span>{{ $related->after_discount }}
                                                        </bdi>
                                                    </span>
                                                </ins>
                                            </span>
                                            <div class="add-cart-area">
                                                <button class="add-to-cart">Add to cart</button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- related_products_section - end
            ================================================== -->
            @endsection
            @section('footer_script')
            <script>
                $('.input_number_increment').click(function(){
                    var input_number = $('.input_number').val();
                    var total = $('#price').html();
                    var total_amount = total*input_number;
                    $('#total').html(total_amount);
                })
                $('.input_number_decrement').click(function(){
                    var input_number = $('.input_number').val();
                    var total = $('#price').html();
                    var total_amount = total*input_number;
                    $('#total').html(total_amount);
                })
            </script>
            <script>
                $('#color_id').change(function(){
                    var color_id = $(this).val();
                    var product_id = '{{ $product_info->id }}';

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type:'POST',
                        url:'/getSize',
                        data:{'color_id':color_id, 'product_id':product_id},
                        success:function(data){
                            $('#size_id').html(data);
                        }
                    });


                });
            </script>

            @if (session('cart'))
                <script>
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('cart') }}',
                    showConfirmButton: false,
                    timer: 1500
                    })
                </script>
            @endif

    <script>
        $('.star_amount').click(function(){
            let star = $(this).attr('data-star');
            $('#star').val(star);
        })
    </script>


@endsection
