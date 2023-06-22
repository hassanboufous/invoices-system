@extends('layouts.master')
@section('css')
<style>
    .container{
        font-size: 20px;
        font-weight: 600;
        color:#04012b;
    }
    @media print {
        #printBtn {
            display: none;
        }
    }
</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">

					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
                <div class="container">
                    <div class="row row-sm">
                        <div class="col-md-12 col-xl-12">
                            <div class=" main-content-body-invoice" id="invoiceData">
                                <div class="card card-invoice">
                                    <div class="card-body">
                                        <div class="invoice-header">
                                            <h1 class="invoice-title">فاتورة التحصيل</h1>
                                            <div class="billed-from">
                                                <h6>{{$user->name}}</h6>
                                                <p>201 Something St., Something Town, YT 242, Country 6546<br>
                                                Tel No: 324 445-4544<br>
                                                Email: {{$user->email}}</p>
                                            </div><!-- billed-from -->
                                        </div><!-- invoice-header -->
                                        <div class="row mg-t-20">
                                            <div class="col-md">
                                                <label class="tx-gray-600">Billed To</label>
                                                <div class="billed-to">
                                                    <h6>Juan Dela Cruz</h6>
                                                    <p>4033 Patterson Road, Staten Island, NY 10301<br>
                                                    Tel No: 324 445-4544<br>
                                                    Email: youremail@companyname.com</p>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <h3 class="text-primary">معلومات الفاتورة</h3>
                                                <p class="invoice-info-row" style="font-size: 18px;"><span >رقم الفاتورة</span> <span>GHT-673-00</span></p>
                                                <p class="invoice-info-row" style="font-size: 18px;"><span> تاريخ الفاتورة </span> <span>32334300</span></p>
                                                <p class="invoice-info-row" style="font-size: 18px;"><span>تاريخ الاستحقاق</span> <span>November 21, 2017</span></p>
                                            </div>
                                        </div>
                                        <div class="table-responsive mg-t-40">
                                           <table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="wd-20p">#</th>
													<th class="wd-40p">Description</th>
													<th class="tx-center">QNTY</th>
													<th class="tx-right">Unit Price</th>
													<th class="tx-right">Amount</th>
												</tr>
											</thead>
											<tbody>

												<tr>
													<td>Android App</td>
													<td class="tx-12">{{$invoice->product}}</td>
													<td class="tx-center">3</td>
													<td class="tx-right">$850.00</td>
													<td class="tx-right">$2,550.00</td>
												</tr>
												<tr>
													<td class="valign-middle" colspan="2" rowspan="4">
														<div class="invoice-notes">
															<label class="main-content-label tx-13">Notes</label>
															<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
														</div><!-- invoice-notes -->
													</td>
													<td class="tx-right">Sub-Total</td>
													<td class="tx-right" colspan="2">$5,750.00</td>
												</tr>
												<tr>
													<td class="tx-right">Tax (5%)</td>
													<td class="tx-right" colspan="2">$287.50</td>
												</tr>
												<tr>
													<td class="tx-right">Discount</td>
													<td class="tx-right" colspan="2">-$50.00</td>
												</tr>
												<tr>
													<td class="tx-right tx-uppercase tx-bold tx-inverse">Total Due</td>
													<td class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold">$5,987.50</h4>
													</td>
												</tr>
											</tbody>
										</table>
                                        </div>
                                        <hr class="mg-b-40">
                                        <button id="printBtn" class="btn btn-danger float-left mt-3 mr-2" onclick="printInvoice()">
                                            <i class="mdi mdi-printer ml-1"></i>طباعة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- COL-END -->
                    </div>
                </div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>

<script>
    function printInvoice(){
        var invoiceData = document.getElementById('invoiceData').innerHTML;
        var OriginContent = document.body.innerHTML;
        document.body.innerHTML = invoiceData;
        window.print();
        document.body.innerHTML = OriginContent;
        location.reload();
    }

</script>
@endsection
