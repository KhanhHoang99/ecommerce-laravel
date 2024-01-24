@extends('frontend.layouts.header-left-menu')

@section('content')

    <div class="col-sm-9">
                
        <div class="blog-post-area">
            <h2 class="title text-center">Latest From our Blog</h2>
            @foreach($blogs as $blog)
            
                <div class="single-blog-post">
                    <h3>{{ $blog->title }}</h3>
                    <div class="post-meta">
                        <ul>
                            <li><i class="fa fa-user"></i> Mac Doe</li>
                            <li><i class="fa fa-clock-o"></i>{{ $blog->created_at->format('H:i') }}</li>
                            <li><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d-m-Y') }}</li>
                        </ul>
                        <span>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                        </span>
                    </div>
                    <a href="">
                        <img src="{{ asset('storage/' . $blog->image) }}" alt="">
                    </a>
                    <p>{{ $blog->description }}</p>
                    <a  class="btn btn-primary" href={{ route('blogDetail', ['id' => $blog->id]) }}>Read More</a>
                </div>
                        
            @endforeach       
        </div>

        {{ $blogs->links('pagination::bootstrap-4') }}

    </div>
   
@stop 