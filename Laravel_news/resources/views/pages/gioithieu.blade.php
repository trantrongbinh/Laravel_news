@extends('layout.index')

@section('content')
<!-- Page Content -->
    <div class="container">

    	<!-- slider -->
    	@include('layout.slide')
        <!-- end slide -->

        <div class="space20"></div>


        <div class="row main-left">
            @include('layout.menu')

            <div class="col-md-9">
	            <div class="panel panel-default">            
	            	<div class="panel-heading" style="background-color:#337AB7; color:white;" >
	            		<h2 style="margin-top:0px; margin-bottom:0px;">Giới thiệu</h2>
	            	</div>

	            	<div class="panel-body">
	            		<!-- item -->
					   <p>
					   	Với sự bùng nổ thông tin trên internet, vai trò của các trang thông tin điện tử trực tuyến càng trở nên quan trọng. 
					   	<br>Khác với báo chí truyền thông có giới hạn thời gian cập nhật tin tức, các tờ báo trực tuyến đã cung cấp được sự tiện lợi trong việc cập nhật và phát hành thông tin. Về phía người dùng, họ có thể xem thông tin mọi lúc mọi nơi. 
					   	<br>Về phía những người cung cấp thông tin, các nhà báo, họ có thể dễ dàng cập nhật những tin tức mới nhất, thời sự nhất. Do đó việc sử dụng các trang thông tin trực tuyến luôn là điều cần thiết hiện nay nhằm đáp ứng nhu cầu cập nhật thông tin của mỗi người. 
					   	<br>Hệ thống website Tin tức được thực hiện bằng ngôn ngữ HTML,CSS,JavaScript,PHP framework Laravel và sử dụng hệ Quản trị CSDL MySql.
					   	<br>SVTH: Mai Văn Toàn
					   </p>
					</div>
	            </div>
        	</div>
        </div>
        <!-- /.row -->
    </div>
    <!-- end Page Content -->
@endsection