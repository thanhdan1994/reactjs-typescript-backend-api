@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Danh sách bài viết</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách bài viết</li>
            </ol>
        </nav>
    </div>
    @include('layouts.errors-and-messages')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{route('admin.products.index')}}">
                        <div class="form-group">
                            <label for="search">Tìm kiếm bài viết</label>
                            <input type="text" class="form-control" name="q" id="search" placeholder="tìm kiếm bài viết theo tiêu đề bài viết, người tạo">
                        </div>
                    </form>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th> Trạng thái </th>
                            <th> Tiêu đề </th>
                            <th> Ảnh </th>
                            <th> Chuyên mục </th>
                            <th> Thương hiệu </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $key => $product)
                            <tr>
                                <td>
                                    @if ($product->status)
                                        <label class="badge badge-success">Đang hiển thị</label>
                                    @else
                                        <label class="badge badge-danger">Nháp</label>
                                    @endif
                                </td>
                                <td class="product-name">
                                    <a href="{{ route('admin.products.edit', $product->id) }}">{!! $product->name !!}</a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}">
                                        <img src="{!! $product->thumbnailUrl !!}" style="width: 60px; height: 60px"/>
                                    </a>
                                </td>
                                <td>
                                    {{ $product->category->name }}
                                </td>
                                <td>
                                    {{ $product->brand->name }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="pagination-box pt-5 pb-5">
                            <div class="col-md-12">
                                <div class="pull-center">{{ $products->links('vendor.pagination.custom-pager') }}</div>
                            </div>
                        </div>
                    @endif
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
