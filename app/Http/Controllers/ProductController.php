<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function index()
    {
       $products = Product::all();
       $sections = Section::all();
       return view('products.products',compact('products','sections'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_name'=>['required','string','unique:products'],
            'description'=>['string'],
            'section_id'=>['required'],
        ]);

        $product = new Product();
        $product->product_name = $request->product_name  ;
        $product->description = $request->description ;
        $product->section_id = $request->section_id;
        $product->save();
        return redirect()->route('products.index')
                    ->with(['success'=>'تمة اضافة المنتج بنجاح']);
    }


    public function show(Product $product)
    {
        //
    }


    public function edit(Product $product)
    {
        //
    }


    public function update(Request $request)
    {
        $section_id = Section::where('section_name',$request->section_name)->pluck('id')->first();
        $product = Product::findOrFail($request->id);
        $product->update([
            'product_name'=>$request->product_name,
            'description'=>$request->description,
            'section_id'=>$section_id
        ]);
         return redirect()->route('products.index')
                    ->with(['success'=>'تمة تعديل المنتج بنجاح']);
    }


    public function destroy(Request $request)
    {
      $product = Product::findOrFail($request->id) ;
      $product->delete();
      return redirect()->route('products.index')
                    ->with(['success'=>'تمة حدف المنتج بنجاح']);
    }
}
