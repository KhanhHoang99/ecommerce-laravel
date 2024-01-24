@extends('frontend.layouts.header-left-menu')

@section('content')

    <div class="col-sm-9 padding-right">
        <h1>Cart Page</h1>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <td scope="col">Image</td>
                    <td scope="col">Quantity</td>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                    
                </tr>
            </thead>
            <tbody>
                @if(count($cart) > 0)
                     
                    @foreach($cart as $product)

                        @php
                            $decodedImages = json_decode($product['images'], true);
                        @endphp
                        @if (!empty($decodedImages) && is_array($decodedImages) && count($decodedImages) > 0)
                            @php
                                $imgMain = $decodedImages[0];
                                $img1 = preg_replace('/^(\d+)\\//', '$1/hinh50_', $decodedImages[0]);
                                $img2 = preg_replace('/^(\d+)\\//', '$1/hinh50_', $decodedImages[1]);
                                $img3 = preg_replace('/^(\d+)\\//', '$1/hinh50_', $decodedImages[2]);
                            @endphp
                        @endif

                        <tr>
                            <td>{{ $product['name']}}</td>
                            <td class="cart_image"><img src="{{ asset("storage/products/" .  "/{$img1}") }}" alt=""></td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <a class="cart_quantity_up" product_id="{{ $product['id'] }}"> + </a>
                                    <input class="cart_quantity_input" type="text" name="quantity" value="{{ $product['quantity'] }}"  autocomplete="off" size="2">
                                    <a class="cart_quantity_down" product_id="{{ $product['id'] }}"> - </a>
                                </div>
                            </td>
                            <td class="cart_price">${{ $product['price'] }}</td>
                            <td class="cart_total_price">${{ number_format($product['quantity'] * $product['price']) }}</td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" product_id="{{ $product['id'] }}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">Your cart is empty.</td>
                    </tr>
                @endif
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="total_price">$ {{ $totalPrice }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
    </div>
    


    
@endsection


@section('scripts')
    <script>
        
        $(document).ready(function(){


            $("a.cart_quantity_up").click(function(){
                
                let product_id =$(this).attr("product_id");
                let quantityValue = $(this).siblings('.cart_quantity_input').val();
                let up_quantity = parseInt(quantityValue) + 1;
                $(this).siblings('.cart_quantity_input').val(up_quantity)

                console.log('up_quantity: ', up_quantity)
                
                let itemPrice = parseFloat($(this).closest('tr').find('.cart_price').text().replace('$', ''));
                let cartTotalPrice = parseFloat($(this).closest('tr').find('.cart_total_price').text().replace('$', ''));

                let newTotalPrice = up_quantity * itemPrice;

                $(this).closest('tr').find('.cart_total_price').text('$' + newTotalPrice);

                console.log('newTotalPrice: ', newTotalPrice)
                
                
                // cập nhật tổng tiền của tất cả sản phẩm
                let total_product_values = $(".cart_total_price").map(function() {
                    return parseFloat($(this).text().replace('$', ''));
                }).get();
                
                let total_price = 0;
                total_product_values.forEach( num => {
                    total_price += num;
                })
                
                let total = $("td.total_price").text('$' + total_price);



                // total quantity
                let all_quantity = $("input.cart_quantity_input").map(function() {
                        return parseFloat($(this).val());
                }).get();

                let total_quantity = 0;

                all_quantity.forEach( num => {
                    total_quantity += num;
                })

                console.log('total quantity: ', total_quantity);

                $(".total-cart").text(total_quantity)


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // ajax(va nó chạy ngầm , giong form:)
                $.ajax({
                    method: "POST",
                    url: "{{ route('cartUp') }}", 
                    data: {
                        product_id: product_id,

                    },
                    success : function(res){
                        // ket qua ben php tra ve lai
                        console.log(res)
                        // $("a")
                        
                    }


                });
            })
           

          
			$("a.cart_quantity_down").click(function(){
	
                let product_id =$(this).attr("product_id");

                let quantityValue = $(this).siblings('.cart_quantity_input').val();

                if(parseInt(quantityValue) > 1) {

                    let dow_quantity = parseInt(quantityValue) - 1;
                    $(this).siblings('.cart_quantity_input').val(dow_quantity)

                    
                    let itemPrice = parseFloat($(this).closest('tr').find('.cart_price').text().replace('$', ''));
                    let cartTotalPrice = parseFloat($(this).closest('tr').find('.cart_total_price').text().replace('$', ''));
                    
                    
                    let newTotalPrice = dow_quantity * itemPrice;

                    // Update total price
                    $(this).closest('tr').find('.cart_total_price').text('$' + newTotalPrice);


                    // cập nhật tổng tiền của tất cả sản phẩm
                    let total_product_values = $(".cart_total_price").map(function() {
                        return parseFloat($(this).text().replace('$', ''));
                    }).get();
                    
                    let total_price = 0;
                    total_product_values.forEach( num => {
                        total_price += num;
                    })
                    
                    let total = $("td.total_price").text('$' + total_price);
                    
                }


                
                // total quantity
                let all_quantity = $("input.cart_quantity_input").map(function() {
                        return parseFloat($(this).val());
                }).get();

                let total_quantity = 0;

                all_quantity.forEach( num => {
                    total_quantity += num;
                })

                console.log('total quantity: ', total_quantity);

                $(".total-cart").text(total_quantity)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // ajax(va nó chạy ngầm , giong form:)
                $.ajax({
                    method: "POST",
                    url: "{{ route('cartDown') }}", 
                    data: {
                        product_id: product_id,

                    },
                    success : function(res){
                        // ket qua ben php tra ve lai
                        console.log(res)
                        // $("a")
                        
                    }
                });
            })
            
            $("a.cart_quantity_delete").click(function(){
	
                let product_id =$(this).attr("product_id");

                $(this).closest('tr').remove();

                // cập nhật tổng tiền của tất cả sản phẩm

                // lấy value của tất cả các thẻ có class cart_total_price ra 1 mảng
                let total_product_values = $(".cart_total_price").map(function() {
                    return parseFloat($(this).text().replace('$', ''));
                }).get();
                
                // tính tổng của cart_total_price
                let total_price = 0;
                total_product_values.forEach( num => {
                    total_price += num;
                })
                
                // cập nhật nó
                let total = $("td.total_price").text('$' + total_price);


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // // ajax(va nó chạy ngầm , giong form:)
                $.ajax({
                    method: "POST",
                    url: "{{ route('cartDelete') }}", 
                    data: {
                        product_id: product_id,

                    },
                    success : function(res){
                        // ket qua ben php tra ve lai
                        console.log(res)
                        // $("a")
                        
                    }
                });
            })

        });
    </script>
@stop