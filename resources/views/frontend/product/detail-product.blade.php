@extends('frontend.layouts.header-left-menu')


@section('content')

  @if ($product->images)
  {{-- Decode the JSON string into an array --}}

      @php
          $decodedImages = json_decode($product->images, true);
      @endphp
      @if (!empty($decodedImages) && is_array($decodedImages) && count($decodedImages) > 0)
        @php
            $imgMain = $decodedImages[0];
            $img1 = preg_replace('/^(\d+)\\//', '$1/hinh50_', $decodedImages[0]);
            $img2 = preg_replace('/^(\d+)\\//', '$1/hinh50_', $decodedImages[1]);
            $img3 = preg_replace('/^(\d+)\\//', '$1/hinh50_', $decodedImages[2]);
        @endphp
      @endif

  @endif

    <div class="col-sm-9 padding-right">
        <div class="product-details"><!--product-details-->
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{ asset('storage/products/' . $imgMain) }}" alt="" />
                    <a href="{{ asset('storage/products/' . $imgMain) }}" rel="prettyPhoto"><h3>ZOOM</h3></a>
                    
                </div>
                <div id="similar-product" class="carousel slide" data-ride="carousel">
                    
                      <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                              <a rel="prettyPhoto" src="{{ asset("storage/products/" .  "/{$img1}") }}"><img src="{{ asset("storage/products/" .  "/{$img1}") }}" alt=""></a>
                              <a href=""><img src="{{ asset("storage/products/" .  "/{$img2}") }}" alt=""></a>
                              <a href=""><img src="{{ asset("storage/products/" .  "/{$img3}") }}" alt=""></a>
                            </div>
                            <div class="item">
                              <a rel="prettyPhoto" src="{{ asset("storage/products/" .  "/{$img1}") }}"><img src="{{ asset("storage/products/" .  "/{$img1}") }}" alt=""></a>
                              <a href=""><img src="{{ asset("storage/products/" .  "/{$img2}") }}" alt=""></a>
                              <a href=""><img src="{{ asset("storage/products/" .  "/{$img3}") }}" alt=""></a>
                            </div>
                            <div class="item">
                              <a rel="prettyPhoto" src="{{ asset("storage/products/" .  "/{$img1}") }}"><img src="{{ asset("storage/products/" .  "/{$img1}") }}" alt=""></a>
                              <a href=""><img src="{{ asset("storage/products/" .  "/{$img2}") }}" alt=""></a>
                              <a href=""><img src="{{ asset("storage/products/" .  "/{$img3}") }}" alt=""></a>
                            </div>
                            
                        </div>

                      <!-- Controls -->
                      <a class="left item-control" href="#similar-product" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                      </a>
                      <a class="right item-control" href="#similar-product" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                      </a>
                </div>

            </div>
            <div class="col-sm-7">
                <div class="product-information"><!--/product-information-->
                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                    <h2>{{ $product->name }}</h2>
                    <p>Web ID: 1089772</p>
                    <img src="images/product-details/rating.png" alt="" />
                    <span>
                        <span>$ {{ $product->price }}</span>
                        <label>Quantity:</label>
                        <input type="text" value="3" />
                        <button type="button" class="btn btn-fefault cart">
                            <i class="fa fa-shopping-cart"></i>
                            Add to cart
                        </button>
                    </span>
                    <p>
                        <b>Availability:</b> 
                        @if ($product->status)
                          In Stock 
                        @else 
                          Sold Out                    
                        @endif
                    </p>
                    <p><b>Condition:</b> New</p>
                    <p><b>Brand:</b> {{ $brand->name }}</p>
                    <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
                </div><!--/product-information-->
            </div>
        </div><!--/product-details-->
        
    </div>
@stop 
