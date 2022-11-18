@extends('layouts.master')
@section('title')
   قائمة الفواتير
@stop

@section('css')
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الفواتير</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong  class="pr-4">{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('no_archive'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم استعادة الفاتورة بنجاح",
                    type: "success"
                })
            }

        </script>
    @endif

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong  class="pr-4">{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    @if (session()->has('delete_invoice'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم حذف الفاتورة بنجاح",
                    type: "success"
                })
            }

        </script>
    @endif
    @if (session()->has('delete_archive'))
        <script>
            window.onload = function() {
                notif({
                    msg: "تم ارشيف الفاتورة بنجاح",
                    type: "warning"
                })
            }

        </script>
    @endif

    <!-- row -->
                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                @can('اضافة فاتورة')
                                    <a href="{{route('invoices.create')}}" class="modal-effect btn  btn-primary" style="color:white"><i
                                            class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
                                @endcan


                                @can('تصدير EXCEL')
                                    <a class="modal-effect btn btn-primary" href="{{ url('export_invoices') }}"
                                       style="color:white"><i class="fas fa-file-download ml-2"></i>&nbsp;تصدير اكسيل</a>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1" data-page-length='50'>

                                        <thead>
                                        <tr>
                                            <th class="border-bottom-0">#</th>
                                            <th class="border-bottom-0">رقم الفاتورة</th>
                                            <th class="border-bottom-0">تاريخ القاتورة</th>
                                            <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                            <th class="border-bottom-0">المنتج</th>
                                            <th class="border-bottom-0">القسم</th>
                                            <th class="border-bottom-0">الخصم</th>
                                            <th class="border-bottom-0">نسبة الضريبة</th>
                                            <th class="border-bottom-0">قيمة الضريبة</th>
                                            <th class="border-bottom-0">الاجمالي</th>
                                            <th class="border-bottom-0">الحالة</th>
                                            <th class="border-bottom-0">ملاحظات</th>
                                            <th class="border-bottom-0">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
                                        <?php $i=1 ?>
                                        @foreach($invoices as $invoice)
                                            <tr>
                                                <td>{{$i++}}</td>
                                                <td>{{$invoice->invoice_number}}</td>
                                                <td>{{$invoice->invoice_date}}</td>
                                                <td>{{$invoice->due_date}}</td>
                                                <td>{{$invoice->product->product_name}}</td>
                                                <td>
                                                    <a href="{{url('InvoicesDetails')}}/{{$invoice->id}}"> {{$invoice->section->section_name}}</a>
                                                </td>
                                                <td>{{$invoice->discount}}</td>
                                                <td>{{$invoice->value_vat}}</td>
                                                <td>{{$invoice->rate_vat}}</td>
                                                <td>{{$invoice->total}}</td>
                                                <td>
                                                    @if($invoice->value_status=="1")
                                                        <span class="badge badge-success">{{$invoice->status}}</span>
                                                    @elseif($invoice->value_status=="2")
                                                        <span class="badge badge-danger">{{$invoice->status}}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{$invoice->status}}</span>
                                                    @endif
                                                </td>
                                                <td>{{$invoice->note}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true"
                                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                                type="button">العمليات<i class="fas fa-caret-down mr-2"></i></button>
                                                        <div class="dropdown-menu tx-13">
                                                            @can('تعديل الفاتورة')
                                                                <a class="dropdown-item"
                                                                   href=" {{ route('invoices.edit',$invoice->id) }}"><i class="text-primary fas fa-edit ml-2"></i>تعديل
                                                                    الفاتورة</a>
                                                            @endcan

                                                            @can('حذف الفاتورة')
                                                                <a class="dropdown-item" href="#"
                                                                   data-toggle="modal" data-target="#delete_invoice{{ $invoice->id }}"><i
                                                                        class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
                                                                    الفاتورة</a>
                                                            @endcan

                                                            @can('تغير حالة الدفع')
                                                                <a class="dropdown-item"
                                                                   href="{{ URL::route('invoices.show', [$invoice->id]) }}"><i
                                                                        class=" text-success fas
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    fa-money-bill"></i>&nbsp;&nbsp;تغير
                                                                    حالة
                                                                    الدفع</a>
                                                            @endcan

                                                            @can('ارشفة الفاتورة')
                                                                   <a class="dropdown-item" href="#"
                                                                   data-toggle="modal" data-target="#Transfer_invoice{{ $invoice->id }}"><i
                                                                        class="text-warning fas fa-exchange-alt ml-2"></i> نقل الي الارشيف</a>
                                                            @endcan

                                                            @can('طباعةالفاتورة')
                                                                <a class="dropdown-item" href="Print_invoice/{{ $invoice->id }}"><i
                                                                        class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
                                                                    الفاتورة
                                                                </a>
                                                            @endcan
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            <!-- حذف الفاتورة -->
                                            <div class="modal fade" id="delete_invoice{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                                                            {{ method_field('delete') }}
                                                            {{ csrf_field() }}
                                                        </div>
                                                        <div class="modal-body">
                                                            هل انت متاكد من عملية الحذف ؟
                                                            <input type="hidden" name="id" id="id" value="{{$invoice->id}}">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>




                                            <!-- ارشف الفاتورة -->
                                            <div class="modal fade" id="Transfer_invoice{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                 aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">ارشف الفاتورة</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            <form action="{{ route('invoices.destroy', 'test') }}" method="post">
                                                            {{ method_field('delete') }}
                                                            {{ csrf_field() }}
                                                        </div>
                                                        <div class="modal-body">
                                                            هل انت متاكد من عملية ارشف الفاتورة ؟
                                                            <input type="hidden" name="id" id="id" value="{{$invoice->id}}">
                                                            <input type="hidden" name="id_page" id="id_page" value="2">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                            <button type="submit" class="btn btn-warning">تاكيد</button>
                                                        </div>
                                                        </form>
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
                    <!--/div-->






                </div>
				<!-- row closed -->
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
    <!--Internal  Notify js -->
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection

