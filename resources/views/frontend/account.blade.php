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
                        <h4 class="panel-title"><a href="{{ route('product') }}">MY PRODUCT</a></h4>
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
        <form class="form-horizontal form-material" method="POST" action="{{ route('profile.update', ['profile' => $user->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="col-md-12">Full Name</label>
                <div class="col-md-12">
                    <input type="text" placeholder="" name="name" value="{{ $user->name }}" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label for="example-email" class="col-md-12">Email</label>
                <div class="col-md-12">
                    <input type="email" name="email" placeholder="johnathan@admin.com" value="{{ $user->email }}" class="form-control form-control-line" name="example-email" id="example-email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12">Password</label>
                <div class="col-md-12">
                    <input type="password" name="password"  class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12">Avatar</label>
                <div class="col-md-12">
                    <input type="file" name="avatar" class="form-control form-control-line">
                </div>
            </div>  
            <div class="form-group">
                <label class="col-md-12">Phone Numner</label>
                <div class="col-md-12">
                    <input type="text" name="phone" value="{{ $user->phone }}" placeholder="Enter your phone number" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-12">Address</label>
                <div class="col-md-12">
                    <input type="text" name="address" value="{{ $user->address }}" placeholder="Enter your address" class="form-control form-control-line">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-12">Select Country</label>
                <div class="col-sm-12">
                    <select class="form-control form-control-line" name="id_country">
                        @foreach($countries as $country)
                            <option {{ $user->id_country == $country->id ? 'selected' : '' }} value="{{ $country->id }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-success">Update Account</button>
                </div>
            </div>
        </form>
    </div>
@stop 