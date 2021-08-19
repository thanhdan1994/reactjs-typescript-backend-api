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
                            <th> STT </th>
                            <th> Chuyên mục </th>
                            <th> Chuyên mục cha</th>
                            <th> Ngày tạo </th>
                            <th> Ngày cập nhật </th>
                            <th> Hành động </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td class="py-1">
                                    @if(isset($_GET['page']))
                                        #{{(($_GET['page'] * config('constants.admin.paginate')) - config('constants.admin.paginate')) + ($key + 1)}}
                                    @else
                                        #{{$key + 1}}
                                    @endif
                                </td>
                                <td>{!! $category->name !!}</td>
                                <td>
                                    {{ $category->parent_name }}
                                </td>
                                <td> {!! $category->created_at !!} </td>
                                <td> {!! $category->updated_at !!} </td>
                                @if(\Illuminate\Support\Facades\Auth::user()->isSuperAdmin())
                                <td>
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" type="button" class="btn btn-outline-info">Sửa</a>
                                    <form method="post" action="{{route('admin.categories.destroy', $category->id)}}"
                                          onsubmit="return confirm('Bạn chắc chắn muốn xóa chuyên mục này?');">
                                        {{method_field('delete')}}
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-outline-danger">Xóa</button>
                                    </form>
                                </td>
                                @else
                                <td>Bạn đếu có quyền chỉnh sửa nhé</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($categories instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="pagination-box pt-5 pb-5">
                            <div class="col-md-12">
                                <div class="pull-center">{{ $categories->links('vendor.pagination.custom-pager') }}</div>
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
