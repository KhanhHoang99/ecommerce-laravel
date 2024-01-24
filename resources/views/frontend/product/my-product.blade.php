@extends('frontend.layouts.main')

@section('left-menu')
    <div class="col-sm-3">
        <div class="left-sidebar">
            <h2>Account</h2>
            <div class="panel-group category-products" id="accordian"><!--category-productsr-->
            
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a href="{{ route('account') }}">ACCOUNT</a></h4>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><a  href="{{ route('product') }}">MY PRODUCT</a></h4>
                    </div>
                </div>
            
            
            </div>
        </div>
    </div>
         
@stop 

@section('content')
    <div class="col-sm-9">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Image</th>
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Products as $Product)
                                <tr>
                                    <td>{{ $Product->id }}</td>
                                    <td>{{ $Product->name }}</td>
                                    <td>
                                        @if ($Product->images)
                                        {{-- Decode the JSON string into an array --}}
                                            @php
                                                $decodedImages = json_decode($Product->images, true);
                                                $newImageName = preg_replace('/^' . auth()->user()->id . '\//', 'hinh50_', $decodedImages[0]);
                                            @endphp

                                            @if ($decodedImages && is_array($decodedImages) && count($decodedImages) > 0)
                                                {{-- Display the first image in the array --}}
                                                <img src="{{ asset("storage/products/" . auth()->user()->id . "/{$newImageName}") }}" alt="Product Image"
                                                style="height: 50px; width: 50px; object-fit: cover;">
                                            @endif
                                        
                                        @endif
                                        
                                    </td>
                                    <td>
                                        <a type="button" href="{{ route('editProduct', ['id' => $Product->id]) }}" class="btn btn-success">Edit</a>
                                        <form method="POST"  action="{{ route('deleteProduct', ['id' => $Product->id]) }}" onsubmit="return confirm('Are you sure you want to delete this Product?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
    
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a  type="button" class="btn btn-primary" href="{{ route('addProduct') }}">
            Add Product
        </a>
    </div>
@stop 