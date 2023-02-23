<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="{{asset('assets/images/favicon.svg')}}"
      type="image/x-icon"
    />
    <title>Elbadr</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/lineicons.css')}}" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
    <script
    src="https://code.jquery.com/jquery-3.6.3.min.js"
    integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="
    crossorigin="anonymous"></script>
  
    
  </head>
  <body>
    <!-- ======== sidebar-nav start =========== -->
    @include('includes.side-nav')
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
      <!-- ========== section start ========== -->
      <section class="section">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          @yield('content')
          <!-- ========== title-wrapper end ========== -->
        </div>
        <!-- end container -->
      </section>
      <!-- ========== section end ========== -->

    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

    @yield('scripts')

    @yield('modals')
  </body>
</html>
