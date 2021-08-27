@extends('layouts.admin.app')

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
    <form class="forms-sample" method="post" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-12 col-lg-12">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Tên sản phẩm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Mô tả</label>
                            <textarea type="email" class="form-control" name="excerpt" id="excerpt"
                                        placeholder="Mô tả bài viêt" row="6">{{ old('excerpt') }}</textarea>
                        </div>
                        <div class="form-group">
                            <ul id="sortable-images">
                                <li class="pb-3 d-flex" id="itemUpload">
                                    <input type="file" name="files[]" multiple id="fileUpload" style="display:none"/> 
                                    <button type="button" id="openFileUploadButton" class="btn btn-gradient-danger btn-icon-text">
                                        <i class="mdi mdi-upload btn-icon-prepend"></i> chọn ảnh 
                                    </button>
                                </li>
                            </ul>
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
                    </div>
                </div>
            </div>
            <div class="col-lg-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <input type="file" name="featured_image" id="featured_image" class="file-upload-default" value="{{ old('featured_image') }}">
                            <div class="input-group col-xs-12">
                                <span data-thumbnail="https://cuoifly.tuoitre.vn/155/0/ttc/r/2020/02/03/logo-ttc-1580721954.png" class="input-group-append file-upload-browse" style="background: url('https://cuoifly.tuoitre.vn/155/0/ttc/r/2020/02/03/logo-ttc-1580721954.png')">
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 col-lg-12">
                                <label for="title">Giá sản phẩm</label>
                                <input type="text" class="form-control" name="amount" id="amount"  value="{{ old('amount') }}" placeholder="giá sản phẩm">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 col-lg-12">
                                <label for="title">Đơn vị tính</label>
                                <input type="text" class="form-control" name="unit" id="unit"  value="{{ old('unit') }}" placeholder="Đơn vị tính">
                            </div>
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
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                            <input type="checkbox" name="status" class="form-check-input" checked> Đang hiển thị<i class="input-helper"></i></label>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <!-- plugins:js -->
    <script src="{{asset('admin/assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

        $( function() {
            $( "#sortable-images" ).sortable();
            $( "#sortable-images" ).disableSelection();
        });
    </script>
    <!-- End custom js for this page -->
@endsection
