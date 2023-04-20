<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImg;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return view('admin.product.product', compact('product'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.product.manage_product', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nameFile' => 'required|array|min:2|max:10',
            'nameFile.*' => 'file|max:2048|mimetypes:image/png,image/jpg,image/jpeg,image/gif', // 2MB
            'quantity' => 'required|numeric|gt:0|min:1|max:1000',
            'price' => 'required|numeric|gt:0|min:1',
            'name' => 'required',
            'brand' => 'required',

        ]); 




        if ($request->hasFile('nameFile')) {
            $product = Product::create([
                'product_name' => $request->name,
                'product_price' => $request->price,
                'product_quantity' => $request->quantity,
                'product_brand' => $request->brand,
                'product_description' => $request->description,
                'category_id' => $request->category
            ]);
            $id = $product->id;

            $files = $request->file('nameFile');


            foreach ($files as $file) {
                // Kiểm tra tính hợp lệ của tệp tin
                if ($file->isValid()) {
                    // Lưu tệp tin vào thư mục public/uploads
                    $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/upload'), $filename);
                    $model = new ProductImg();
                    $model->img_name = $filename;
                    $model->product_id = $id;
                    $model->save();
                }
            }

            $msg = 'Successfully added product';
            return redirect()->route('product.index')->with('msg', $msg);
        } else {
            return "No file selected.";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::all();
        return view('admin.product.edit_product', compact('product', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nameFile' => 'array|min:0|max:10',
            'nameFile.*' => 'file|max:2048|mimetypes:image/png,image/jpg,image/jpeg,image/gif', // 2MB
            'quantity' => 'required|numeric|gt:0|min:1|max:1000',
            'price' => 'required|numeric|gt:0|min:1',
            'name' => 'required',
            'brand' => 'required',
        ]);
        $model = Product::find($id);
        $model->product_name = $request->name;
        $model->product_price = $request->price;
        $model->product_quantity = $request->quantity;
        $model->product_brand = $request->brand;
        $model->category_id = $request->category;
        $model->product_description = $request->description;
        $model->save();

        if ($request->hasFile('nameFile')) {
            $img = ProductImg::where('product_id', $id)->get();
            foreach ($img as $item) {
                unlink(public_path("storage/upload/{$item->img_name}"));
                $item->delete();
            }
            $id_product = $model->id;

            $files = $request->file('nameFile');


            foreach ($files as $file) {
                // Kiểm tra tính hợp lệ của tệp tin
                if ($file->isValid()) {
                    // Lưu tệp tin vào thư mục public/uploads
                    $filename = md5(uniqid()) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('storage/upload'), $filename);
                    $model = new ProductImg();
                    $model->img_name = $filename;
                    $model->product_id = $id_product;
                    $model->save();
                }
            }
        }
        
        $msg = 'Successfully updated product';
        return redirect()->route('product.index')->with('msg', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Product::find($id);
        $model->delete();


        $img = ProductImg::where('product_id', $id)->get();
        foreach ($img as $item) {
            unlink(public_path("storage/upload/{$item->img_name}"));
            $item->delete();
        }
        $msg = 'Successfully deleted product';
        return redirect()->route('product.index')->with('msg', $msg);
    }
}
