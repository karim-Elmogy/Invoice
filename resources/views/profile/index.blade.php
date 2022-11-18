@extends('layouts.master')
@section('title')
    تعديل الملف الشخصي
@stop
@section('css')
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الملف الشخصي</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل الملف الشخصي</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col">
            <div class="card mg-b-20">
                <div class="card-body" >
                    <div class="pl-0">


                        <div class="main-profile-overview" >

                                <div class="profile-user mb-3" style="text-align: center;">
                                    @if($user->image == '')
                                        <img  alt="" src="{{URL::asset('assets/img/faces/user.png')}}" width="150" height="150" style="border-radius: 50%">
                                    @else
                                        <img src="/storage/{{$user->image}}" alt="{{$user->image}}" class="img-tumbnail" width="150" height="150" style="border-radius: 50%">
                                    @endif

                                </div>
                                <div class="d-flex justify-content-between mg-b-20">
                                    <div style="text-align: center;margin: 0 auto">
                                        <h5 class="main-profile-name mb-2" >{{Auth::user()->name}}</h5>

                                        @if ($user->Status == 'مفعل')
                                            <span class="label text-success d-flex">

                                                <div class="text-center" style="margin: 0 auto">
                                                    <div class="dot-label bg-success ml-1"></div>
                                                    <label class="badge badge-success"> {{ $user->Status }}</label>
                                                </div>


                                            </span>
                                        @else
                                            <span class="label text-danger d-flex">
                                                <div class="text-center" style="margin: 0 auto">
                                                   <div class="dot-label bg-danger ml-1"></div>
                                                     <label class="badge badge-danger"> {{ $user->Status }}</label>
                                                </div>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            <!-- main-profile-bio -->

                            <hr class="mg-y-30">
                            <form role="form" action="{{route('profiles.update','test')}}"  method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('patch') }}
                                <div class="form-group">
                                    <label for="Email">تعديل صورة الملف الشخصي : </label>
                                    <input type="file" class="form-control" id="" name="image" required>
                                </div>


                                <button class="btn btn-primary " type="submit">حفظ</button>
                            </form>


                        </div>
                        <!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->

@endsection
@section('js')
@endsection
