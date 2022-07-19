<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SCP | @yield('title')</title>
  @include('panels/styles')
</head>
<body class="hold-transition layout-top-nav">
  <div class="wrapper">  
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
      <div class="container">
        <a href="{{route('frontend-dashboard.index')}}" class="navbar-brand">
          <img src="{!!asset('dist/img/logo.png')!!}" alt="SCP" class="brand-image" style="opacity: .8">
          <span class="brand-text font-weight-light">&nbsp;</span>
        </a>
  
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a href="{{route('frontend-dashboard.index')}}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">Login</a>
            </li>            
          </ul> 
        </div>  
      </div>
    </nav>
    <!-- /.navbar -->
  
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">
                @yield('page-title')
              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              @yield('page-breadcrumb')
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->
  
      <!-- Main content -->
      <div class="content">
        @yield('page-content')
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  
    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">
        Smart Car Parking STT Indonesia Tanjungpinang
      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; 2022-2025 <a href="https://carparking.sttindonesia.ac.id">SCPv1</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->
  @include('panels/scripts')
</body>
</html>