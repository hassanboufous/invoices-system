@extends('layouts.master')
@section('title','المنتجات')
@section('css')
<!-- Internal Data table css -->
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
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4>
                            <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2">
                                <i class="mdi mdi-filter-variant"></i></button>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger font-weight-bold">
                <li>{{$error}}</li>
            </div>
        @endforeach
    @endif
    @if (Session::has('success'))
            <div class="alert alert-success font-weight-bold">
                <li>{{Session::get('success')}}</li>
            </div>
    @endif
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <a class="modal-effect btn btn-info"
                        data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-md-nowrap" id="example1">
                                <thead>
                                    <tr>
                                        <th class="border-bottom-0">#</th>
                                        <th class="border-bottom-0">اسم المنتج</th>
                                        <th class="border-bottom-0">اسم القسم</th>
                                        <th class="border-bottom-0">الوصف</th>
                                        <th class="border-bottom-0">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?= $i=0 ?>
                                    @foreach ($products as $product)
                                    <?= $i++ ?>
                                     <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$product->product_name}}</td>
                                        <td>{{$product->section->section_name}}</td>
                                        <td>{{$product->description}}</td>
                                        <td>
                                             <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-pro_id="{{ $product->id }}" data-name="{{ $product->product_name }}"
                                                data-description="{{ $product->description }}" data-target="#edit_product"
                                                data-section_name="{{ $product->section->section_name }}" data-toggle="modal"
                                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i>
                                            </a>
                                             {{-- <button class="btn btn-outline-success btn-sm"
                                                data-name="{{ $product->product_name }}" data-pro_id="{{ $product->id }}"
                                                data-section_name="{{ $product->section->section_name }}"
                                                data-description="{{ $product->description }}" data-toggle="modal"
                                                data-target="#edit_product">تعديل</button> --}}

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $product->id }}" data-product_name="{{ $product->product_name }}" data-toggle="modal"
                                                href="#modaldemo9" title="حذف"><i class="las la-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <!--/div-->
        </div>

    <!-- Basic modal -Add new product ----------->
		<div class="modal" id="modaldemo8" style="display: none;" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header bg-warning">
						<h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
					</div>
                    <form action="{{route('products.store')}}" method="POST">
                        @csrf
                        <div class="modal-body bg-ligh">
                            <div class="from-group">
                                <label for="product_name">اسم المنتج</label>
                                <input type="text" name="product_name" id="product_name" class="form-control">
                            </div>
                            <br>
                            <div class="from-group">
                                <label for="section_id">اسم القسم</label>
                                <select name="section_id" id="section_id" class="form-control">
                                    <option selected disabled> اخترالقسم</option>
                                    @foreach ($sections as $section)
                                        <option value="{{$section->id}}">{{$section->section_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="from-group">
                                <label for="description">ملاحضات</label>
                                <textarea name="description" id="description" class="form-control">
                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn ripple btn-success" type="submit">حفض</button>
                                <button class="btn ripple btn-danger" data-dismiss="modal" type="button">اغلاق</button>
                            </div>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
{{-- ---------------------------------edit --------------------------------}}

        <!-- edit -->
        {{-- <div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='products/update' method="post">
                        @method('PATCH')
                        @csrf
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">اسم المنتج :</label>

                                <input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">

                                <input type="text" class="form-control" name="product_name" id="product_name">
                            </div>
                            <div class="form-group">
                                <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                <select name="section_name" id="section_name" class="custom-select my-1 mr-sm-2" required>
                                    @foreach ($sections as $section)
                                        <option>{{ $section->section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="des">ملاحظات :</label>
                                <textarea name="description" cols="20" rows="5" id='description'
                                    class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}

        <div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form action="products/update" method="post" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <input type="hidden" name="id" id="pro_id">
                                    <label for="recipient-name" class="col-form-label">اسم المنتج:</label>
                                    <input class="form-control" name="product_name" id="product_name" type="text" >


                                    <label for="section_id">اسم القسم</label>
                                    <select name="section_name" id="section_name" class="form-control">
                                        @foreach ($sections as $section)
                                            <option>{{$section->section_name}}</option>
                                        @endforeach
                                    </select>

                                    <label for="message-text" class="col-form-label">ملاحظات:</label>
                                    <textarea class="form-control" id="description" name="description"></textarea>
                                </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">تاكيد</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
{{-- --------------------------------- end edit -------------------------------------}}

<!-- --------------------start delete modal --------------------------------------------------->
            <div class="modal" id="modaldemo9">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">حذف المنتج</h6>
                            <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="products/destroy" method="post">
                            @method('DELETE')
                            @csrf
                            <div class="modal-body">
                                <p>هل انت متاكد من عملية الحذف ؟</p><br>
                                <input type="hidden" name="id" id="id" value="">
                                <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
    <!-- --------------------end delete modal --------------------------------------------------->
        </div>
<!------------- Container closed -->
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
<script>
 // ------------------- manipulating edit & delete modals -----------------------------------
    $('#exampleModal2').on('show.bs.modal', function(event){
        var button = $(event.relatedTarget)
        var productId = button.data('id');
        var productName = button.data('product_name');
        var description = button.data('description');
        $(this).find('.modal-body #id').val(productId);
        $(this).find('.modal-body #product_name').val(productName);
        $(this).find('.modal-body #description').val(description);
    })

        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var productName = button.data('product_name');
            var productId = button.data('id');
            $(this).find('.modal-body #id').val(productId);
            $(this).find('.modal-body #product_name').val(productName);
        });
        $('#edit_product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_name = button.data('name')
            var sectionName = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(sectionName);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })

</script>
@endsection
