@extends('layouts/FrontLayout')

@section('title', 'DASHBOARD')

@section('page-title')
  <i class="fas fa-home"></i> DASHBOARD
@endsection

@section('page-breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"
    ><a href="{!! route('frontend-dashboard.index') !!}">Home</a>
  </li>
  <li class="breadcrumb-item active">
    Dashboard
  </li>  
</ol>
@endsection
@section('page-content')
<div class="container">
  <div class="row">    
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 1</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/-1.png')!!}" alt="slot 1" style="opacity: .8">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary">Refresh</a>
        </div>
      </div>
    </div>  
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 2</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/-1.png')!!}" alt="slot 1" style="opacity: .8">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary">Refresh</a>
        </div>
      </div>
    </div>  
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 3</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/0.png')!!}" alt="slot 1" style="opacity: .8">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary">Refresh</a>
        </div>
      </div>
    </div>  
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 4</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/1.png')!!}" alt="slot 1" style="opacity: .8">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary">Refresh</a>
        </div>
      </div>
    </div>  
  </div>  
</div>
@endsection

@section('page-script')

@endsection