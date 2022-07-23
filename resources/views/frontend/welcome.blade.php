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
          <img src="{!!asset('dist/img/-1.png')!!}" alt="slot 1" style="opacity: .8" id="slot-status-1">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary" id="btnRefreshSlot1">Refresh</a>
        </div>
      </div>
    </div>  
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 2</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/-1.png')!!}" alt="slot 2" style="opacity: .8" id="slot-status-2">
        </div>
        <div class="card-footer">
          <a href="javascript:void(0)" class="btn btn-primary" id="btnRefreshSlot2">Refresh</a>
        </div>
      </div>
    </div>  
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 3</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/-1.png')!!}" alt="slot 1" style="opacity: .8" id="slot-status-3">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary" id="btnRefreshSlot3">Refresh</a>
        </div>
      </div>
    </div>  
    <div class="col-lg-3">  
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h5 class="card-title m-0">Slot 4</h5>
        </div>
        <div class="card-body">
          <img src="{!!asset('dist/img/-1.png')!!}" alt="slot 1" style="opacity: .8" id="slot-status-4">
        </div>
        <div class="card-footer">
          <a href="#" class="btn btn-primary" id="btnRefreshSlot4">Refresh</a>
        </div>
      </div>
    </div>  
  </div>  
</div>
@endsection

@section('page-script')
<script src="{!! asset('/dist/js/pages/frontend.js')!!}"></script>
@endsection
