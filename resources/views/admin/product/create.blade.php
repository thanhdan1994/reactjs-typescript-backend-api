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
        <link rel="stylesheet" href="{{asset('admin/assets/css/custom.css')}}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{asset('admin/assets/images/favicon.png')}}" />
    </head>
@endsection

@section('content')
    <div class="page-header">
        <h3 class="page-title">Thêm sản phẩm mới</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm mới</li>
            </ol>
        </nav>
    </div>
    @include('layouts.errors-and-messages')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col-md-6 col-lg-6">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Tên sản phẩm">
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <label for="title">Giá sản phẩm</label>
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="giá sản phẩm">
                            </div>
                            <div class="col-md-3 col-lg-3">
                                <label for="title">Đơn vị tính</label>
                                <input type="text" class="form-control" name="unit" id="unit" placeholder="Đơn vị tính">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Mô tả</label>
                            <textarea type="email" class="form-control" name="excerpt" id="excerpt"
                                      placeholder="Mô tả bài viêt" row="6"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Chuyên mục</label>
                            <select class="form-control" name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Nhà sản xuất</label>
                            <select class="form-control" name="brand_id" id="brand_id">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <input type="file" name="featured_image" id="featured_image" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <span data-thumbnail="https://cuoifly.tuoitre.vn/155/0/ttc/r/2020/02/03/logo-ttc-1580721954.png" class="input-group-append file-upload-browse" style="background: url('https://cuoifly.tuoitre.vn/155/0/ttc/r/2020/02/03/logo-ttc-1580721954.png')">
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <label class="file col-12">
                                Ảnh chi tiết sản phẩm
                                <input type="file" name="images[]" id="images" multiple aria-label="File browser example">
                                <span class="file-custom"></span>
                            </label>
                        </div>
                        <div class="row form-group preview-images">
                        </div>
                        <div class="form-group">
                            <label for="content">Nội dung sản phẩm</label>
                            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Nội dung sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Thông số kỹ thuật sản phẩm</label>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Thuộc tính</th>
                                    <th scope="col">Giá trị</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody id="content-parameters">
                                </tbody>
                            </table>
                            <label class="mt-3">
                                <a class="btn btn-gradient-primary mr-2" onclick="handleAddParameters()">
                                    <span class="badge bg-purple"></span>
                                    <i class="fas fa-plus"></i> Thêm thông số
                                </a>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
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
    <!-- Custom js for this page -->
    <script src="{{asset('admin/assets/js/file-upload.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
    <script src="{{ asset('admin/ckfinder/ckfinder.js') }}"></script>
    <script>
        ClassicEditor
            .create( document.querySelector( '#content' ), {
                ckfinder: {
                    uploadUrl: '/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                    options: {
                        resourceType: 'Images'
                    }
                },
                toolbar: [ 'ckfinder', 'imageUpload', '|', 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo' , 'mediaEmbed' ]
            } )
            .catch( function( error ) {
                console.error( error );
            } );

        const contentParameters = document.getElementById('content-parameters');
        var numberRow = 100;
        function handleAddParameters() {
            numberRow += 1;
            let rowElement = document.createElement('tr');
            let columnThElement = document.createElement('th');
            columnThElement.scope = "row";
            columnThElement.innerHTML = '<input type="text" name="parameters['+ numberRow +'][key]" class="form-control" />';
            let columnTd1Element = document.createElement('td');
            columnTd1Element.innerHTML = '<input type="text" name="parameters['+ numberRow +'][value]" class="form-control" />';
            let columnTd2Element = document.createElement('td');
            let buttonRemoveElement = document.createElement('button');
            buttonRemoveElement.type = "button";
            buttonRemoveElement.className = "btn btn-sm btn-danger";
            buttonRemoveElement.innerText = "Xóa";
            buttonRemoveElement.addEventListener('click', handleRemoveProperties);
            columnTd2Element.append(buttonRemoveElement);
            rowElement.append(columnThElement);
            rowElement.append(columnTd1Element);
            rowElement.append(columnTd2Element);
            contentParameters.append(rowElement);
        }

        function handleRemoveProperties() {
            this.closest('tr').remove();
        }
    </script>
    <!-- End custom js for this page -->
@endsection