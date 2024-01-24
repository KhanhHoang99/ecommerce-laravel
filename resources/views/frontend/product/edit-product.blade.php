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

    @if ($product->images)
    {{-- Decode the JSON string into an array --}}

        @php
            $decodedImages = json_decode($product->images, true);
        @endphp
        @if (!empty($decodedImages) && is_array($decodedImages) && count($decodedImages) > 0)
        @php
            $img1 = preg_replace('/^' . auth()->user()->id . '\//', 'hinh50_', $decodedImages[0]);
            $img2 = $decodedImages[1];
            $img3 = $decodedImages[2];
        @endphp
        @endif

    @endif
    <div class="col-sm-9">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible">

                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1>Edit Product</h1>

        <form class="form-horizontal form-material" method="POST" action="{{ route('updateProduct', ['id' => $product->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" placeholder="Name" name="name" value="{{ $product->name }}" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Price</label>
                <div class="col-md-12">
                    <input type="text" placeholder="Price" name="price" value="{{ $product->price }}" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Brand</label>
                <div class="col-sm-12">
                    <select class="form-control form-control-line" name="id_brand">
                        @foreach($brands as $brand)
                            <option {{ $product->id_brand == $brand->id ? 'selected' : '' }} value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Brand</label>
                <div class="col-sm-12">
                    <select class="form-control form-control-line" name="id_category">
                        @foreach($categories as $category)
                            <option {{ $product->id_category == $category->id ? 'selected' : '' }} value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="file"  name="files[]" multiple class="form-control form-control-line">
                    @foreach ($decodedImages as $image)
                        @php
                            $newImageName = preg_replace('/^' . auth()->user()->id . '\//', 'hinh50_', $image);
                        @endphp
                        <div>
                            <input type="checkbox" name="selected_images[]" value="{{ $loop->index }}">
                            <img src="{{ asset("storage/products/" . auth()->user()->id . "/{$newImageName}") }}" alt="Image">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Sale</label>
                <div class="col-md-6">
                    <input type="number" class="form-control form-control-line" placeholder="Sale" value="{{ $product->sale }}" id="quantity" name="quantity" min="1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Company</label>
                <div class="col-md-12">
                    <input type="text" placeholder="Company" name="company" value="{{ $product->company }}" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Detail</label>
                <div class="col-md-12">
                    <textarea rows="5" placeholder="detail" name="detail" class="form-control form-control-line">{{ $product->detail }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button  class="btn btn-success">Update Product</button>
                </div>
            </div>
        </form>
    </div>
@stop 

@section('scripts')
<script>
    function validateForm() {
        var selectedImages = document.querySelectorAll('input[name="selected_images[]"]:checked').length;
        var uploadedFiles = document.querySelector('input[name="files[]"]').files.length;
        var maxTotal = 3;

        if (selectedImages + uploadedFiles > maxTotal) {
            alert('Total selected images and files cannot exceed ' + maxTotal);
            return false; // Prevent form submission
        }

        if (selectedImages == 0 && uploadedFiles > 0) {
            alert('Please select to delete images before update');
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }
</script>
@stop