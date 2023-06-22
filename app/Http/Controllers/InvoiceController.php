<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Exports\InvoiceExport;
use App\Models\InvoiceDetails;
use App\traits\UploadImageTrait;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    use UploadImageTrait;

    public function index()
    {
       $invoices = Invoice::all();
       return view('invoices.invoices',compact('invoices'));
    }


    public function create()
    {
        $sections = Section::all();
        return view('invoices.create', compact('sections'));
    }


    public function store(Request $request)
    {

        // Models Invoices - invoice attachments - invoice details -------
        Invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2, // unpaid status value => 2
            'note' => $request->note,
        ]);

        // add invoice details
        $invoice_id = Invoice::latest()->pluck('id')->first();
        InvoiceDetails::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->pluck('id')->first();
            $invoice_number = $request->invoice_number;

            // upload file to public storage
            $file_name =  $this->UploadImg('Attachments/'.$request->invoice_number,$request->pic);

            // Add invoice attachments
            $attachments = new InvoiceAttachment();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

        }
         return back()->with(['success'=> 'تم اضافة الفاتورة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    public function edit($id)
    {
       $invoice = Invoice::findOrFail($id);
       $sections = Section::all();
       return view('invoices.edit',compact('invoice','sections'));
    }


     public function update(Request $request,$id)
     {
         $invoice = Invoice::findOrFail($id);
            $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);
        return redirect()->route('invoices.index')->with(['success'=> 'تم تعديل الفاتورة بنجاح']);
    }


    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
         $invoice->delete();
         return back()->with(['success'=>'تم نقل الفاتورة الى الارشيف بنجاح']);
    }
    //     $id = $request->invoice_id;
    //     $invoices = invoices::where('id', $id)->first();

    //      $id_page =$request->id_page;


    //     if (!$id_page==2) {

    //     if (!empty($Details->invoice_number)) {

    //         Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
    //     }

    //     $invoices->forceDelete();
    //     session()->flash('delete_invoice');
    //     return redirect('/invoices');

    //     }

    //     else {

    //         $invoices->delete();
    //         session()->flash('archive_invoice');
    //         return redirect('/Archive');
    //     }



    public function getProduct($id) {

         $products = Product::where('section_id',$id)->pluck('product_name','id');
         return $products;
    }


    public function EditStatus($id)
    {
        $sections = Section::all();
        $invoice = invoice::where('id',$id)->first();
        return view('invoices.payment',compact('invoice','sections'));
    }
    public function UpdateStatus(Request $request ,$id)
    {
        $invoice = invoice::where('id',$id)->first();
        if($request->status === 'مدفوعة'){
            $invoice->update([
                'value_status'=>1,
                'status'=>$request->status,
                'payment_date'=>$request->payment_date
            ]);
             InvoiceDetails::create([
            'invoice_id' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->status,
            'Value_Status' => 1,
            'note' => $request->note,
            'payment_date' => $request->payment_date,
            'user' => (Auth::user()->name),
            ]);
        }
        elseif($request->status === 'غير مدفوعة'){
               $invoice->update([
                'value_status'=>3,
                'status'=>$request->status,
                'payment_date'=>null
            ]);
             InvoiceDetails::create([
            'invoice_id' => $id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => $request->status,
            'Value_Status' => 3,
            'note' => $request->note,
            'payment_date' => null,
            'user' => (Auth::user()->name),
            ]);
        }
        return redirect()->route('invoices.index')->with(['success'=>'تم حفض المعلومات بنجاح']);
    }

//Invoices : paid => 1 ,  partially paid => 3,unpaid => 2 ,
     public function paidInvoices()
    {
        $invoices = Invoice::where('Value_Status', 1)->get();
        return view('invoices.paid',compact('invoices'));
    }

    public function UnpaidInvoices()
    {
        $invoices = Invoice::where('Value_Status',2)->get();
        return view('invoices.unpaid',compact('invoices'));
    }

    public function PartialPaidInvoices()
    {
        $invoices = Invoice::where('Value_Status',3)->get();
        return view('invoices.partial_paid',compact('invoices'));
    }

    public function archive()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive',compact('invoices'));
    }

    public function forceDelete($id)
    {
        $invoices = Invoice::withTrashed()->where('id',$id)->first();
         $attachment = invoiceAttachment::where('invoice_id', $id)->first();
        if(!empty($attachment->invoice_number)){
            Storage::deleteDirectory('Attachments/'.$attachment->invoice_number);
         }
        $invoices->forceDelete();
        return back();
    }

    public function restore($id)
    {
        $invoices = Invoice::onlyTrashed()->where('id',$id)->first();
        $invoices->restore();
        return redirect()->route('invoices.archive')->with(['success'=> 'تم استرجاع الفاتورة بنجاح']);
    }

    public function print($id) {
        $user = Auth::user();
         $invoice = invoice::where('id', $id)->first();
        return view('invoices.print',compact('invoice','user'));
    }

    // public function Print_invoice($id)
    // {
    //     $invoices = invoices::where('id', $id)->first();
    //     return view('invoices.Print_invoice',compact('invoices'));
    // }

    public function export()
    {
       return Excel::download(new InvoiceExport, 'invoices.xlsx');
    }


    // public function MarkAsRead_all (Request $request)
    // {

    //     $userUnreadNotification= auth()->user()->unreadNotifications;

    //     if($userUnreadNotification) {
    //         $userUnreadNotification->markAsRead();
    //         return back();
    //     }


    // }


    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification){

        return $notification->data['title'];

        }

    }



}
