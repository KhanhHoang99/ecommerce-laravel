@extends('frontend.layouts.header-left-menu')

@section('content')


    <div class="col-sm-9">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible">

                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
         @endif
        <div class="blog-post-area">
            <h2 class="title text-center">Latest From our Blog</h2>
                <h3>{{ $blog->title }}</h3>
                <div class="post-meta">
                    <ul>
                        <li><i class="fa fa-user"></i> Mac Doe</li>
                        <li><i class="fa fa-clock-o"></i>{{ $blog->created_at->format('H:i') }}</li>
                        <li><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d-m-Y') }}</li>
                    </ul>
                </div>
                <a href="">
                    <img class="img-responsive" src="{{ asset('storage/' . $blog->image) }}" alt="">
                </a>

                {!! $blog->content !!}
                
                <div class="pager-area">
                    <ul class="pager pull-right">
                        @if($previous)
                            <li class="blogPrev"><a href="{{ route('blogDetail', ['id' => $previous]) }}">Pre</a></li>
                        @endif

                        @if($next)
                            <li class="blogNext"><a href="{{ route('blogDetail', ['id' => $next]) }}">Next</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div><!--/blog-post-area-->

        <div class="rating-area">
            <div class="rate">
                <div class="vote">
                    <div class="star_1 ratings_stars"><input value="1" type="hidden"></div>
                    <div class="star_2 ratings_stars"><input value="2" type="hidden"></div>
                    <div class="star_3 ratings_stars"><input value="3" type="hidden"></div>
                    <div class="star_4 ratings_stars"><input value="4" type="hidden"></div>
                    <div class="star_5 ratings_stars"><input value="5" type="hidden"></div>
                    <span class="rate-np">{{$averageRate}}</span>   
                </div> 
            </div>
            <ul class="tag">
                <li>TAG:</li>
                <li><a class="color" href="">Pink <span>/</span></a></li>
                <li><a class="color" href="">T-Shirt <span>/</span></a></li>
                <li><a class="color" href="">Girls</a></li>
            </ul>
        </div><!--/rating-area-->

        <div class="socials-share">
            <a href=""><img src="{{ asset('frontend/images/blog/socials.png')}}" alt=""></a>
        </div><!--/socials-share-->

        <div class="response-area">
            <h2>3 RESPONSES</h2>
            <ul class="media-list">

                @foreach($comments as $comment)
                    @if((int)$comment->level == 0)
                        <li class="media">                
                            <a class="pull-left" href="#">
                                <img class="media-object" style="width: 120px; height: 80px; object-fit: cover;" src="{{ asset('storage/' . $comment->avatar) }}" alt="">
                            </a>
                            <div class="media-body">
                                <ul class="sinlge-post-meta">
                                    <li class="name">
                                        <i class="fa fa-user"></i>
                                        <span>{{ $comment->name }}</span>
                                    </li>
                                    <li><i class="fa fa-clock-o"></i> {{ $comment->created_at->format('h:i A') }}</li>
                                    <li><i class="fa fa-calendar"></i>  {{ $comment->created_at->format('d-m-Y') }}</li>
                                </ul>
                                <p>{{ $comment->comment }}</p>
                                <button type="button" class="btn btn-primary reply" data-toggle="modal" data-target="#modalReply"><i class="fa fa-reply"></i>Replay</button>
                                <input type="hidden" class="id_comment" value="{{ $comment->id }}">
                            </div>
                        </li>
                        <?php $comment_id = (int)$comment->id; ?>
                        @foreach($comments as $comment)
                            @if((int)$comment->level == $comment_id)
                             <li class="media second-media">
                                <a class="pull-left" href="#">
                                    <img class="media-object" style="width: 120px; height: 80px; object-fit: cover;" src="{{ asset('storage/' . $comment->avatar) }}" alt="">
                                </a>
                                <div class="media-body">
                                    <ul class="sinlge-post-meta">
                                        <li><i class="fa fa-user"></i> <span>{{ $comment->name }}</span></li>
                                        <li><i class="fa fa-clock-o"></i> {{ $comment->created_at->format('h:i A') }}</li>
                                        <li><i class="fa fa-calendar"></i>  {{ $comment->created_at->format('d-m-Y') }}</li>
                                    </ul>
                                    <p>{{ $comment->comment }}</p>
                                    {{-- <button type="button" class="btn btn-primary reply" data-toggle="modal" data-target="#modalReply"><i class="fa fa-reply"></i>Replay</button>
                                     <input type="hidden" class="id_comment" value="{{ $comment->id }}"> --}}
                                </div>
                            </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
               
                
            </ul>					
        </div><!--/Response-area-->

        <div class="replay-box">
            <div class="row">

                @if(auth()->check())
                                   
                    <div class="col-sm-12">
                        <h2>Leave a replay</h2>
                        <div class="text-area">
                            <div class="blank-arrow">
                                <label>Your Name</label>
                            </div>
                            <span>*</span>
                            <form action="{{ route('comment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="level" value="0">
                                <input type="hidden" name="id_blog" value="{{ $blog->id }}">
                                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="avatar" value="{{ auth()->user()->avatar}}">
                                <textarea name="comment" rows="5"></textarea>
                                <button class="btn btn-primary" type="submit">post comment</button>
                            </form>
                        </div>
                    </div>                         
                                            
                @else
                    <div class="col-sm-12">
                    <!-- User is not logged in -->
                        <div class="alert alert-success">
                            Hãy Đăng Nhập Để Bình Luận
                        </div>
                    </div>
                @endif

                
                
            </div>
        </div><!--/Repaly Box-->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalReply" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyName">Reply</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('comment') }}" method="POST">
                    @csrf
                    <input type="hidden" class="level-comment" name="level" value="0">
                    <input type="hidden" name="id_blog" value="{{ $blog->id }}">
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="avatar" value="{{ auth()->user()->avatar}}">
                    <textarea name="comment" style="background-color: white; border: 1px solid #e5e5e5;" rows="5"></textarea>
                    <button type="submit" class="btn btn-primary">Reply</button>
                </form>
            </div>
        </div>
        </div>
    </div>
   
@stop 


@section('scripts')

    <script>
            
        $(document).ready(function(){

            let averageRate = {{$averageRate}}; 


           


            // Loop qua tất cả input rating và so sánh value của nó với averageRate
            $('.ratings_stars input').each(function () {
                var inputValue = parseInt($(this).val());

                if (inputValue <= averageRate) {
                    $(this).parent().addClass('ratings_over');
                }
            });


            $.ajaxSetup({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //vote
			$('.ratings_stars').hover(
	            // Handles the mouseover
	            function() {
	                $(this).prevAll().andSelf().addClass('ratings_hover');
	                // $(this).nextAll().removeClass('ratings_vote'); 
	            },
	            function() {
	                $(this).prevAll().andSelf().removeClass('ratings_hover');
	                // set_votes($(this).parent());
	            }
	        );

            
			$('.ratings_stars').click(function(){

                // // goi php vao 
                let checkLogin = "{{Auth::Check()}}";
                
                if(checkLogin){
                    
                    let rate =  $(this).find("input").val();
                    
                    if ($(this).hasClass('ratings_over')) {
                        $('.ratings_stars').removeClass('ratings_over');
                        $(this).prevAll().andSelf().addClass('ratings_over');
                    } else {
                        $(this).prevAll().andSelf().addClass('ratings_over');
                    }


                      // dung ajax gui qua controller va insert table rate
                      $.ajax({
                        type:'POST',
                        url: '{{ route('rate', ['id' => $blog->id]) }}',
                        data:{
                            rate:rate,
                            id_blog: {{ $blog->id }},
                        },
                        success:function(data){
                            console.log(data.success);
                        }
                    });

                    

                }else{
                    alert("vui long login danh gia");
                }

            });


            $('button.reply').click(function () {
                let replyName = $(this).prev().prev().find('li.name span').text();
                
                $('#replyName').text(`Reply ${replyName}`);

                let id_comment = $(this).next().val()

                $('.level-comment').val(id_comment);
                


            });



           

           
        });
    </script>

@stop