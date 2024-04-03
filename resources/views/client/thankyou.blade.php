@extends('client.layout')

@section('content')

<style>
.thank-you-wraper{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.thank-you-wraper .main-content{
  display: flex;
  flex-direction: column;
  align-items: center;
}
#checkmark{
  color: #24b663 !important;
  font-size: 100px
}
</style>
<section>
    <div class="container-fluid thank-you-wraper">
      <header class="site-header" id="header">
        <h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
      </header>
    
      <div class="main-content mb-30">
        <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
        <p class="main-content__body" data-lead-id="main-content-body">Thanks a bunch for filling that out. It means a lot to us, just like you do!<br> We really appreciate you giving us a moment of your time today. Thanks for being you.</p>
      </div>
    
      <footer class="site-footer" id="footer">
        <a class="btn btn-success" href="{{route('home')}}" id="fineprint">Trở về trang chủ</a>
      </footer>
    </div>
  </section>
@endsection