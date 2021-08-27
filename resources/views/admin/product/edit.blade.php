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
    <form class="forms-sample" method="post" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-lg-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row form-group">
                            <div class="col-md-12 col-lg-12">
                                <label for="name">Tên sản phẩm</label>
                                <input type="text" class="form-control" value="{!! $product->name !!}" name="name" id="name" placeholder="Tên sản phẩm">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="excerpt">Mô tả</label>
                            <textarea type="email" class="form-control" name="excerpt" id="excerpt"
                                        placeholder="Mô tả bài viêt" row="6">{!! $product->excerpt !!}</textarea>
                        </div>
                        <div class="form-group">
                            <ul id="sortable-images">
                                @foreach ($product->images as $image)
                                    <li class="pb-3">
                                        <i class="mdi mdi-close-box js-close-product-image"></i>
                                        <input type="text" name="ProductImages[]" value={{ $image->id }} style="display:none">
                                        <img src={!! $image->url !!}>
                                    </li>
                                @endforeach
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
                            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Nội dung sản phẩm">{!! $product->content !!}</textarea>
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
                                @if(is_array($product->parameters))
                                    @foreach($product->parameters as $key => $parameter)
                                        <tr>
                                            <th scope="row">
                                                <input type="text" name="parameters[{{$key}}][key]" class="form-control" value="{{$parameter['key']}}">
                                            </th>
                                            <td>
                                                <input type="text" name="parameters[{{$key}}][value]" class="form-control" value="{{$parameter['value']}}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove();">Xóa</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <label class="mt-3">
                                <a class="btn btn-gradient-primary mr-2" onclick="handleAddParameters()">
                                    <span class="badge bg-purple"></span>
                                    <i class="fas fa-plus"></i> Thêm thông số
                                </a>
                            </label>
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between">
                                <span class="card-title">Mẫu mã</span>
                                <span>
                                    <a href={{ route('admin.variants.create', ['product_id'=> $product->id]) }}>Thêm mẫu mã</a>
                                </span>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Kích thước</th>
                                        <th>Màu</th>
                                        <th>Giá</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($product->variants as $variant)
                                        <tr>
                                            <td>
                                                <img src={{ $variant->thumbnailUrl50x50 }} />
                                            </td>
                                            <td>{{ $variant->size }}</td>
                                            <td>{{ $variant->color }}</td>
                                            <td>{{ $variant->amount }}</td>
                                            <td>
                                                <span class="p-1"><a class="text-warning" href={{ route('admin.variants.edit',  ['product_id' => $product->id, 'id' => $variant->id]) }}>Sửa</a></span>
                                                <span class="p-1"><a class="text-danger" href={{ route('admin.variants.destroy', ['product_id' => $product->id, 'id' => $variant->id]) }}><i class="mdi mdi-delete"></i></a></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
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
                                <span data-thumbnail="{!! $product->thumbnailUrl !!}" class="input-group-append file-upload-browse" style="background: url({!! $product->thumbnailUrl !!})">
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 col-lg-12">
                                <label for="title">Giá sản phẩm</label>
                                <input type="text" class="form-control" value="{!! $product->amount !!}" name="amount" id="amount" placeholder="giá sản phẩm">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-12 col-lg-12">
                                <label for="title">Đơn vị tính</label>
                                <input type="text" class="form-control" value="{!! $product->unit !!}" name="unit" id="unit" placeholder="Đơn vị tính">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Chuyên mục</label>
                            <select class="form-control" name="category_id" id="category_id">
                                @foreach($categories as $category)
                                    <option value="{!! $category->id !!}" @if ($category->id == $product->category_id) selected @endif>{!! $category->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="brand_id">Nhà sản xuất</label>
                            <select class="form-control" name="brand_id" id="brand_id">
                                @foreach($brands as $brand)
                                    <option value="{!! $brand->id !!}" @if ($brand->id == $product->brand_id) selected @endif>{!! $brand->name !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                            <input type="checkbox" name="status" class="form-check-input" @if ($product->status) checked @endif> bật/tắt hiển thị<i class="input-helper"></i></label>
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
