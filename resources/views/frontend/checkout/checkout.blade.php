@extends('frontend.layouts.header-left-menu')

@section('content')

    <div class="col-sm-9 padding-right">
        <h1>Check Out Page</h1>
        @if(auth()->check())
            <li><a href="{{ route('account') }}"><i class="fa fa-user"></i> Account</a></li>
            <button type="button" class="btn btn-primary">Continue</button>
        @else
        <div class="row">

            <!--login form-->
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <h2>Login to your account</h2>
                    <form method="POST" action="{{ route('userLogin') }}">
                        @csrf
                        <input type="email" name="email" placeholder="Email Address"/>
                        <input type="password" name="password" placeholder="Password"/>
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Keep me signed in
                        </span>
                        <button type="submit" class="btn btn-default">Login</button>
                    </form>
                </div>
            </div>

            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>

            <!--sign up form-->
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Sign up!</h2>
                    <form method="POST" action="{{ route('userRegister') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="name" placeholder="Name"/>
                        <input type="email" name="email" placeholder="Email Address"/>
                        <input type="file" name="avatar">
                        <input type="text" name="phone"  placeholder="Enter your phone number">
                        <input type="password" name="password" placeholder="Password"/>
                        <input type="password" name="password_confirmation" placeholder="Confirm Password" />
                        <select class="form-control form-control-line" name="id_country">
                            {{-- @foreach($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->name }}
                                </option>
                            @endforeach --}}
                        </select>
                        <button type="submit" class="btn btn-default">Signup</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        
       
        
    </div>
    


    
@endsection


@section('scripts')
    <script>
        
      
    </script>
@stop