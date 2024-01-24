<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>mail</title>
</head>
<body>

    
     Hey {{ $data['body'] }},

    
    <p>You have ordered {{ $data['totalQuantity'] }} products.</p>
    <p>The total amount you need to pay is ${{ $data['totalPrice'] }}.</p>
    
    <p>Details of your order:</p>
    
    @foreach($data['products'] as $product)
        <p>Product Name: {{ $product['name'] }}</p>
        <p>Product Price: ${{ $product['price'] }}</p>
        <p>Quantity: {{ $product['quantity'] }}</p>
    @endforeach
   
</body>
</html>