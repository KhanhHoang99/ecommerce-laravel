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

        <form class="form-horizontal form-material" method="POST" action="{{ route('addProduct') }}" enctype="multipart/form-data">
            @csrf
           
            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" placeholder="Name" name="name" value="" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" placeholder="Price" name="price" value="" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Select Category</label>
                <div class="col-sm-12">
                    <select class="form-control form-control-line" name="id_category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Select Brand</label>
                <div class="col-sm-12">
                    <select class="form-control form-control-line" name="id_brand">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-md-12">
                    <input type="file" name="files[]" multiple class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control form-control-line" name="sale" id="sale">
                        <option value="0">New</option>
                        <option value="1">Sale</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group" id="saleInput" style="display:none;">
                <label class="col-sm-12">% sale</label>
                <div class="col-md-6">
                    <input type="number" class="form-control form-control-line" value="0"  id="quantity" name="quantity" min="0">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="text" placeholder="Company" name="company" value="" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <textarea rows="5" placeholder="detail" name="detail" class="form-control form-control-line" id="editor"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-success">Add Product</button>
                </div>
            </div>
        </form>
    </div>
@stop 

@section('scripts')
    <script>
        $(document).ready(function(){
            // Initially hide the sale input field
            $("#saleInput").hide();

            // Show/hide the sale input field based on the selected value
            $("#sale").change(function(){
                if($(this).val() == "1") {
                    $("#saleInput").show();
                } else {
                    $("#saleInput").hide();
                }
            });
        });
    </script>
@stop