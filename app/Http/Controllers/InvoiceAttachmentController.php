<?php

namespace App\Http\Controllers;

use App\Models\InvoiceAttachment;
use App\traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceAttachmentController extends Controller
{
    use UploadImageTrait;
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'attachmentFile'=>'mimes:png,jpg,pdf,jpeg'
        // ]);

        if ($request->hasFile('attachmentFile')) {
            $fileName = $this->UploadImg('Attachments'.'/'.$request->invoice_number,$request->attachmentFile);
            $attachment = new InvoiceAttachment();
            $attachment->file_name = $fileName;
            $attachment->invoice_id = $request->invoiceId;
            $attachment->invoice_number = $request->invoice_number;
            $attachment->created_by = Auth::User()->name;
            $attachment->save();
            return redirect()->back()->with(['success'=>'تمة اضافة المرفق بنجاح']);
        }
        return redirect()->back()->with(['success'=>'faild .........']);
    }


    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }


    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceAttachment $invoiceAttachment)
    {
        //
    }
}
