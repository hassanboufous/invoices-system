<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    public function index($id){

        $details = InvoiceDetails::where('invoice_id',$id)->get();
        $attachments = InvoiceAttachment::where('invoice_id',$id)->get();
        $invoices = Invoice::where('id',$id)->first();
        return view('invoices.details',compact('details','attachments','invoices'));
    }

    public function downloadFile($invoice){

        $attachment = invoiceAttachment::where('invoice_number',$invoice)->first();
        $file_name = public_path("storage/".$attachment->file_name);
    	return response()->download($file_name);
    }

    public function ShowFile($invoice){

        $attachment = invoiceAttachment::where('invoice_number',$invoice)->first();
        $file_name = public_path("storage/".$attachment->file_name);
    	return response()->file($file_name);
    }

    public function deleteFile(Request $request) {

        $invoice = InvoiceAttachment::findOrFail($request->id);
        $invoice->delete();
        if(Storage::exists($request->file_name)){
             Storage::delete($request->file_name);
             return back();
            }
        return back();
    }



}
