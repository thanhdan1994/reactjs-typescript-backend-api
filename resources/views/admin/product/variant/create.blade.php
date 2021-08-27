@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Thêm mẫu mã</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Trang chính</a></li>
                <li class="breadcrumb-item active" aria-current="page">Thêm mẫu mã</li>
            </ol>
        </nav>
    </div>
    @include('layouts.errors-and-messages')
    <div class="row">
        <div class="col-lg-5 grid-margin stretch-card d-flex flex-column">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="form-group d-flex">
                        <div class="col-4 pr-0 pl-0">
                            <span><img class="" src={{ $product->thumbnailUrl }} style="max-width: 100%" /></span>
                        </div>
                        <div class="info-product d-flex flex-column col-8 pr-0">
                            <span>{{ $product->name }}</span>
                            <span><a href={{ route('admin.products.edit', $product->id) }}>Quay lại sản phẩm</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="form-group d-flex flex-column variants">
                        <h4>Mẫu mã</h4>
                        <ul class="list-variants">
                            @foreach ($product->variants as $productVariant)
                                <li class="item">
                                    <a href={{ route('admin.variants.edit', ['product_id' => $product->id, 'id' => $productVariant->id]) }}>
                                        <span class="variant-image"><img src={{ $productVariant->thumbnailUrl50x50 }} /></span>
                                        <span>{{ $productVariant->size }} / {{ $productVariant->color }}</span>
                                    </a>
                                <li>
                            @endforeach
                        <ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4>Thông tin mẫu mã</h4>
                    <form class="forms-sample" method="post" action={{ route('admin.variants.store', ['product_id'=> $product->id]) }} enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="col-12">
                                <label for="name">Kích cỡ</label>
                                <input type="text" class="form-control" name="size" placeholder="mẫu mã">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <label for="name">Màu sắc</label>
                                <input type="text" class="form-control" name="color" placeholder="Màu sắc">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <label for="name">Số lượng</label>
                                <input type="number" class="form-control" name="quantity" placeholder="Số lượng">
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-6">
                                <label for="name">Giá bán</label>
                                <input type="text" class="form-control" name="amount" placeholder="giá bán">
                            </div>
                            <div class="col-6">
                                <label for="name">Giá gốc</label>
                                <input type="text" class="form-control" name="amount_root" placeholder="giá gốc">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ảnh đại diện</label>
                            <input type="file" name="featured_image" id="featured_image" class="file-upload-default" value="{{ old('featured_image') }}">
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
