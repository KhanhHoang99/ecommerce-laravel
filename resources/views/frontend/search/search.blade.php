@extends('frontend.layouts.header-left-menu')

@section('content')

    <div class="col-sm-9 padding-right">
        <div class="features_items"><!--features_items-->

            <h2 class="title text-center">Features Items</h2>
            @foreach($results as $product)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                                <div class="productinfo text-center">
                                    @if ($product->images)
                                        {{-- Decode the JSON string into an array --}}
                                            @php
                                                $decodedImages = json_decode($product->images, true);
                                            @endphp

                                            @if ($decodedImages && is_array($decodedImages) && count($decodedImages) > 0)
                                                {{-- Display the first image in the array --}}
                                                <img src="{{ asset("storage/products/" . "/{$decodedImages[1]}") }}" alt="Product Image"
                                                >
                     
                                            @endif
                                        
                                    @endif
                                    <h2>${{ $product->price }}</h2>
                                    <p>{{ $product->name }}</p>
                                    <button class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                </div>
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <h2>${{ $product->price }}</h2>
                                        <p>{{ $product->name }}</p>
                                        <button id="{{ $product->id }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                    </div>
                                </div>
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                <li><a href="{{ route('productDetail', ['id' => $product->id]) }}"><i class="fa fa-plus-square"></i>Detail</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
            
        </div><!--features_items-->
        
    </div>
@stop 

@section('scripts')
    <script>
        
   
    </script>
@stop
 
