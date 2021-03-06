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
                    <form method="post" class="forms-sample" action="{{ route('admin.categories.store') }}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="category">Tên chuyên mục</label>
                            <input type="text" name="name" class="form-control" id="category" placeholder="tên chuyên mục">
                        </div>
                        <div class="form-group">
                            <label for="parent">Chuyên mục cha</label>
                            <select class="form-control" id="parent" name="parent">
                                <option value="0">Chọn danh mục cha...</option>
                                @foreach($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
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
    <!-- endinject -->
@endsection
