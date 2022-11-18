@extends('layouts.master')
@section('title')
    الاقسام - برنامج الفواتير
@stop
@section('css')
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">



@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ الاقسام</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong class="pr-4">{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong class="pr-4">{{ session()->get('edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong class="pr-4">{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif
				<!-- row -->
				<div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                @can('اضافة قسم')
                                    <a class="modal-effect btn btn-primary " data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">إضافة قسم</a>
                                @endcan


                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <table class="table text-md-nowrap" id="example1" data-page-length='50'>

                                        <thead>
                                        <tr>
                                            <th class="text-center border-bottom-0">#</th>
                                            <th class="text-center border-bottom-0">اسم القسم</th>
                                            <th class="text-center border-bottom-0">الوصف</th>
                                            <th class="text-center border-bottom-0">المستخدم</th>
                                            <th class="text-center border-bottom-0">العمليات</th>

                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        <?php $i=1; ?>
                                        @foreach($sections as $section)

                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$section->section_name}}</td>
                                                <td>{{$section->descr}}</td>
                                                <td>{{$section->created_by}}</td>
                                                <td>
                                                    @can('تعديل قسم')
                                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#edit{{ $section->id }}"
                                                                title="تعديل"><i class="las la-pen"></i>
                                                        </button>
                                                    @endcan
                                                        @can('حذف قسم')
                                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                                    data-target="#delete{{ $section->id }}"
                                                                    title="حذف"><i
                                                                    class="las la-trash"></i>
                                                            </button>
                                                        @endcan

                                                </td>
                                            </tr>


                                            <!-- edit_modal_Grade -->
                                            <div class="modal fade" id="edit{{ $section->id }}" tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                                id="exampleModalLabel">
                                                                تعديل القسم
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form action="{{ route('sections.update', 'test') }}" method="post">
                                                                {{ method_field('patch') }}
                                                                @csrf

                                                                <input id="id" type="hidden" name="id" class="form-control"
                                                                       value="{{ $section->id }}">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="exampleInputEmail1">اسم القسم</label>
                                                                        <input type="text" class="form-control" id="section_name" name="section_name" value="{{$section->section_name}}">
                                                                    </div>

                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                                                                        <textarea class="form-control" id="descr" name="descr" rows="3">{{$section->descr}}</textarea>
                                                                    </div>
                                                                </div>

                                                                <br><br>

                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">الغاء</button>
                                                                    <button type="submit"
                                                                            class="btn btn-success">تاكيد</button>
                                                                </div>
                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                            <!-- delete_modal-->
                                            <div class="modal fade" id="delete{{ $section->id }}" tabindex="-1" role="dialog"
                                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('sections.destroy', 'test') }}" method="post">
                                                                {{ method_field('Delete') }}
                                                                @csrf
                                                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                                               قسم  {{ $section->section_name }}
                                                                <br>  <br>
                                                                <input id="id" type="hidden" name="id" class="form-control"
                                                                       value="{{ $section->id }}">
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">الغاء</button>
                                                                    <button type="submit"
                                                                            class="btn btn-danger">تاكيد</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- row closed -->






                <!-- Add modal -->
                <div class="modal" id="modaldemo8">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content modal-content-demo">
                            <div class="modal-header">
                                <h6 class="modal-title">إضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('sections.store') }}" method="post">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">اسم القسم</label>
                                        <input type="text" class="form-control" id="section_name" name="section_name" placeholder="إسم القسم">
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">ملاحظات</label>
                                        <textarea class="form-control" id="descr" name="descr" rows="3"></textarea>
                                    </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                        <button type="submit" class="btn btn-success">تاكيد</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End Basic modal -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
    <!--Internal  Datatable js -->
    <script src="{{URL::asset('assets/js/table-data.js')}}"></script>



    <!-- Internal Modal js-->
    <script src="{{URL::asset('assets/js/modal.js')}}"></script>
@endsection
