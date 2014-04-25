<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>
    @section('title')
      Chief
    @endsection
  </title>
  
  <meta name="description" content="A fairly minimalistic Laravel blog engine">
	<meta name="viewport" content="width=device-width">

	<!-- favicon and apple touch icon -->
  <link rel="shortcut icon" href="{{ asset('packages/bencavens/chief/favicon.ico') }}">
  
  <!-- For iPad Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('packages/bencavens/chief/icons/apple-touch-icon-144x144-precomposed.png') }}">

  <!-- For iPhone 4 Retina display: -->
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('packages/bencavens/chief/icons/apple-touch-icon-114x114-precomposed.png') }}">

  <!-- For iPad: -->
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('packages/bencavens/chief/icons/apple-touch-icon-72x72-precomposed.png') }}">

  <!-- For iPhone: -->
  <link rel="apple-touch-icon-precomposed" href="{{ asset('packages/bencavens/chief/icons/apple-touch-icon-precomposed.png') }}">

  <!-- stylesheets -->
  <link href="{{ asset('packages/bencavens/chief/css/vendor/bootstrap.min.css') }}" rel="stylesheet" media="screen">
  <link href="{{ asset('packages/bencavens/chief/js/vendor/redactor/redactor.css') }}" rel="stylesheet" />
  <link href="{{ asset('packages/bencavens/chief/css/main.css') }}" rel="stylesheet" media="screen">

</head>
<body>
   
  <div class="container">
      <div class="brand">
        <span class="brand-logo">Chief</span>
      </div>
  </div>

  <div class="main">

    <div class="container">
    
      @include('chief::_partials.messages')

      @yield('content')

    </div>

  </div>

<!-- scripts -->
<script src="{{ asset('packages/bencavens/chief/js/vendor/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('packages/bencavens/chief/js/vendor/bootstrap.min.js') }}"></script>

@yield('redactor')

<script src="{{ asset('packages/bencavens/chief/js/main.js') }}"></script>


</body>
</html>
