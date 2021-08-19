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
        <h3 class="page-title">Danh sách tài khoản</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
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
                            <th> Tên người dùng </th>
                            <th> Email </th>
                            <th> Ngày tạo </th>
                            <th> Vai trò </th>
                            <th> Hành động </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td class="py-1">
                                    @if(isset($_GET['page']))
                                        #{{(($_GET['page'] * config('constants.admin.paginate')) - config('constants.admin.paginate')) + ($key + 1)}}
                                    @else
                                        #{{$key + 1}}
                                    @endif
                                </td>
                                <td>{!! $user->name !!}</td>
                                <td>{!! $user->email !!}</td>
                                <td>{!! $user->created_at !!}</td>
                                <td> vai trò </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" type="button" class="btn btn-outline-info">Sửa</a>
                                    <form method="post" action="{{route('admin.users.destroy', $user->id)}}"
                                          onsubmit="return confirm('Bạn chắc chắn muốn xóa người dùng này?');">
                                        {{method_field('delete')}}
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-outline-danger">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($users instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                        <div class="pagination-box pt-5 pb-5">
                            <div class="col-md-12">
                                <div class="pull-center">{{ $users->links('vendor.pagination.custom-pager') }}</div>
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
    <!-- Plugin js for this page -->
    <script src="{{asset('admin/assets/vendors/chart.js/Chart.min.js')}}"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('admin/assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('admin/assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('admin/assets/js/misc.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
@endsection
