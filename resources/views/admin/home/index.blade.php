@extends('layouts.admin.main',['request' => $request])
@section('content')
<section class="content">
    <!-- Small boxes (Stat box) -->
    @if(Auth::user()->role->role_slug == "super_admin" || Auth::user()->role->role_slug == "admin" )
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Total Records </h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3> {{ $totaluser }} </h3>
                    <p> Total Users</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users"></i>
                </div>
                <a href="{{ url('admin/users') }}" class="small-box-footer"> More Info<i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    @else
    <h1>Welcome to admin dashboard !</h1>
    @endif
</section><!-- /.content -->

@stop

@section("styles")
@stop
@section("scripts")
@stop