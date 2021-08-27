@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Tạo chuyên mục mới</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tạo chuyên mục mới</li>
            </ol>
        </nav>
    </div>
    @include('layouts.errors-and-messages')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="forms-sample" action="{{ route('admin.brands.store') }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="category">Tên thương hiệu</label>
                            <input type="text" name="name" class="form-control" placeholder="tên thương hiệu">
                        </div>
                        <div class="form-group">
                            <label>Logo thương hiệu</label>
                            <input type="file" name="logo" id="featured_image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <span data-thumbnail="https://cuoifly.tuoitre.vn/155/0/ttc/r/2020/02/03/logo-ttc-1580721954.png" class="input-group-append file-upload-browse" style="background: url('https://cuoifly.tuoitre.vn/155/0/ttc/r/2020/02/03/logo-ttc-1580721954.png')">
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Lưu</button>
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
