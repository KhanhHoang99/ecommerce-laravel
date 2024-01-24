@extends('admin.layouts.main')

@section('content')

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">

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

        <div class="col-12">
            <h1>Create Blog</h1>

            <div class="col-lg-8 col-xlg-9 col-md-7">
                <div class="card">
                    <div class="card-body">
                       
                        <form class="form-horizontal form-material" method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data">
                            @csrf
                        
                            <!-- Other form fields -->
                        
                            <div class="form-group">
                                <label class="col-md-12">Title</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="" name="title" value="{{ old('title', $blog->title ?? '') }}" class="form-control form-control-line">
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-md-12">Image</label>
                                <div class="col-md-12">
                                    <input type="file" name="image" class="form-control form-control-line">
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-md-12">Description</label>
                                <div class="col-md-12">
                                    <textarea rows="3" name="description" class="form-control form-control-line">{{ old('description', $blog->description ?? '') }}</textarea>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <label class="col-md-12">Content</label>
                                <div class="col-md-12">
                                    <textarea rows="8" name="content" class="form-control form-control-line" id="editor">{{ old('content', $blog->content ?? '') }}</textarea>
                                </div>
                            </div>
                        
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success">Save Content</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            {{-- <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                               
        
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

   

  </div>

<!-- footer -->
<!-- ============================================================== -->
    <footer class="footer text-center">
        All Rights Reserved by Nice admin. Designed and Developed by
        <a href="https://wrappixel.com">WrapPixel</a>.
    </footer>

@stop 

