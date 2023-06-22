@extends('layouts.master')
@section('css')
<!---Internal  Prism css-->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{URL::asset('assets/plugins/inputtags/inputtags.css')}}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css')}}" rel="stylesheet">
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
   @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
        <!-- row opened -->
            <div class="row row-sm">
					<div class="col-lg-12 col-md-12">
						<div class="card" id="basic-alert">
							<div class="card-body">
								<div class="text-wrap">
									<div class="example">
										<div class="panel panel-primary tabs-style-1">
											<div class=" tab-menu-heading">
												<div class="tabs-menu1">
													<!-- Tabs -->
													<ul class="nav panel-tabs main-nav-line">
														<li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab">معلومات الفاتورة</a></li>
														<li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab">التفاصيل</a></li>
														<li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab">المرفقات</a></li>
													</ul>
												</div>
											</div>
											<div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
												<div class="tab-content">
													<div class="tab-pane active" id="tab1">
                                                        <table class="table text-md-nowrap table-hover">
                                                            <thead>
                                                                <tr class="text-primary font-weight-bold text-center">
                                                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                                                    <th class="border-bottom-0">تاريخ الفاتورة</th>
                                                                    <th class="border-bottom-0">تاريخ الاستحقاق</th>
                                                                    <th class="border-bottom-0">المنتج </th>
                                                                    <th class="border-bottom-0">القسم</th>
                                                                    <th class="border-bottom-0">الاجمالي</th>
                                                                    <th class="border-bottom-0">ملاحضات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr class="text-primary text-center">
                                                                <td>{{$invoices->invoice_number}}</td>
                                                                <td>{{$invoices->invoice_date}}</td>
                                                                <td>{{$invoices->due_date}}</td>
                                                                <td>{{$invoices->product}}</td>
                                                                <td> {{$invoices->section->section_name}}</td>
                                                                <td>{{$invoices->total}}</td>
                                                                <td>{{$invoices->note}}</td>
                                                                </tr>
                                                            </tbody>
                                                         </table>
													</div>

													<div class="tab-pane" id="tab2">
                                                          <table class="table text-md-nowrap table-hover">
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th class="border-bottom-0">رقم الفاتورة</th>
                                                                    <th class="border-bottom-0">المنتج </th>
                                                                    <th class="border-bottom-0">الحالة</th>
                                                                    <th class="border-bottom-0">المستخدم</th>
                                                                    <th class="border-bottom-0">ملاحضات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($details as $detail)
                                                                    <tr class="text-primary text-center">
                                                                        <td>{{$detail->invoice_number}}</td>
                                                                        <td>{{$detail->product}}</td>
                                                                        <td>
                                                                            @if ($detail->value_status == 2)
                                                                            <span class="badge bg-danger text-white p-2">{{$detail->status}}</span>
                                                                            @elseif ($detail->value_status == 3)
                                                                            <span class="badge bg-warning text-white p-2">{{$detail->status}}</span>
                                                                            @else
                                                                            <span class="badge bg-success text-white p-2">{{$detail->status}}</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>{{$detail->user}}</td>
                                                                        <td>{{$detail->note}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                         </table>
													</div>
													<div class="tab-pane" id="tab3">
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="card">
                                                                    <div class="card-title">
                                                                        <p>صيغة المرفق :  pdf,png,jpg,jpeg<span class="text-danger font-weight-bold">*</span> </p>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <form action="{{route('add-attachments.store')}}" method="POST" enctype="multipart/form-data" class="form">
                                                                            @csrf
                                                                            <div>اضافة مرفقات</div>
                                                                             <div class="col-sm-12 col-md-12">
                                                                                <input type="file" name="attachmentFile" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                                                data-height="70" />
                                                                             </div><br>
                                                                            <input type="hidden" name="invoice_number" id="invoice_number" value="{{$invoices->invoice_number}}" >
                                                                            <input type="hidden" class="form-control" id="invoiceId" name="invoiceId" value="{{$invoices->id}}">
                                                                            <input type="submit" value="اضافة" class="btn btn-success">
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                         <table class="table text-md-nowrap table-hover">
                                                            <thead class="text-center">
                                                                <tr>
                                                                <th class="border-bottom-0">رقم الفاتورة</th>
                                                                <th class="border-bottom-0">الملفات</th>
                                                                <th class="border-bottom-0">المستخدم</th>
                                                                <th class="border-bottom-0">العمليات</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($attachments as $attachment)
                                                                    <tr class="text-primary text-center bg-light">
                                                                        <td>{{$attachment->invoice_number}}</td>
                                                                        <td>{{$attachment->file_name}}</td>
                                                                        <td>{{$attachment->created_by}}</td>
                                                                        <td>
                                                                        <a class="modal-effect btn btn btn-danger" data-effect="effect-scale"
                                                                            data-id="{{$attachment->id}}"
                                                                            data-invoice-number="{{$attachment->invoice_number}}" data-file-name="{{$attachment->file_name}}" data-toggle="modal"
                                                                            href="#deleteModal" title="حذف" >حدف
                                                                        </a>
                                                                            <a href="{{route('downloadFile',$attachment->invoice_number)}}" class="btn btn-success">تحميل</a>
                                                                            <a href="{{route('ShowFileFile',$attachment->invoice_number)}}" class="btn btn-warning">عرض</a>
                                                                        </td>
                                                                    </tr>
                                                                  @endforeach
                                                            </tbody>
                                                         </table>
													</div>
                                                    {{-- start delete modal --}}
                                                        <div class="modal" id="deleteModal">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content modal-content-demo">
                                                                    <div class="modal-header">
                                                                        <h6 class="modal-title">حذف المنتج</h6>
                                                                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{route('deleteFile')}}" method="POST">
                                                                        @csrf
                                                                        <div class="modal-body">
                                                                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                                                            <input type="hidden" name="id" id="id" value="">
                                                                            <label for="product_name">رقم الفاتورة</label>
                                                                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                                                                            <label for="attachment">المرفق</label>
                                                                            <input class="form-control" name="file_name" id="attachment" type="text" readonly>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                                            <button type="submit" class="btn btn-danger">تاكيد</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    {{-- end delete modal --}}
												</div>
											</div>
										</div>
									</div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /div -->
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Datepicker js -->
<script src="{{URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
<!-- Internal Select2 js-->
<script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<!-- Internal Jquery.mCustomScrollbar js-->
<script src="{{URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Internal Input tags js-->
<script src="{{URL::asset('assets/plugins/inputtags/inputtags.js')}}"></script>
<!--- Tabs JS-->
<script src="{{URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js')}}"></script>
<script src="{{URL::asset('assets/js/tabs.js')}}"></script>
<!--Internal  Clipboard js-->
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>
<!-- Internal Prism js-->
<script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
<script>
    $('#deleteModal').on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var attachmentId = button.data('id');
        var invoiceNumber = button.data('invoice-number');
        var fileName = button.data('file-name');

        $(this).find('.modal-body #id').val(attachmentId);
        $(this).find('.modal-body #product_name').val(invoiceNumber);
        $(this).find('.modal-body #attachment').val(fileName);
    })
</script>
@endsection
