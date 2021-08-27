@extends('layouts.admin.app')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Danh sách chuyên mục</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách chuyên mục</li>
            </ol>
        </nav>
    </div>
    @include('layouts.errors-and-messages')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Thương hiệu</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td class="py-1">
                                    <a href="{{ route('admin.brands.edit', $brand->id) }}">
                                        <img src="{!! $brand->logoUrl !!}" style="width: 149px; height: 40px"/>
                                    </a>
                                </td>
                                <td><a href="{{ route('admin.brands.edit', $brand->id) }}">{!! $brand->name !!}</a></td>
                                <td> {!! $brand->created_at !!} </td>
                                <td> {!! $brand->updated_at !!} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($brands instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="pagination-box pt-5 pb-5">
                            <div class="col-md-12">
                                <div class="pull-center">{{ $brands->links('vendor.pagination.custom-pager') }}</div>
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
