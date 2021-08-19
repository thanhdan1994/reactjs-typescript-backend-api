@extends('layouts.admin.app')

@section('head')
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Trang quản trị Du Lịch Cổ Thạch</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/assets/vendors/css/vendor.bundle.base.css')}}">
        <!-- endinject -->
        <!-- Plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- endinject -->
        <!-- Layout styles -->
        <link rel="stylesheet" href="{{asset('admin/assets/css/style.css')}}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.png')}}" />
    </head>
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">Chỉnh sửa chuyên mục</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa chuyên mục</li>
            </ol>
        </nav>
    </div>
    @include('layouts.errors-and-messages')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="forms-sample" action="{{ route('admin.brands.update', $brand->id) }}" enctype="multipart/form-data">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="brand">Tên thương hiệu</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="tên thương hiệu" value="{!! $brand->name !!}">
                        </div>
                        <div class="form-group">
                            <label>Logo thương hiệu</label>
                            <input type="file" name="featured_image" id="featured_image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <span data-thumbnail="{!! $brand->logoUrl !!}" class="input-group-append file-upload-browse" style="background: url({!! $brand->logoUrl !!})">
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- plugins:js -->
    <script src="{{asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="{{asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/assets/js/misc.js')}}"></script>
    <script src="{{asset('admin/assets/js/file-upload.js')}}"></script>
    <!-- endinject -->
@endsection
