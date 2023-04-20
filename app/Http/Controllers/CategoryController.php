<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index(){
        $categories = Category::all();
        return view('admin.category.category',compact('categories'));
    }

    public function manage_category(){
        $model = new Category();
        return view('admin.category.manage_category',compact('model'));
    }

    public function add_category(Request $request){
        $model = new Category();
        $model->category_name = $request->name;
        $model->category_status = $request->status;
        $model->save();
        $msg = 'Successfully added category';
        return redirect()->route('category')->with('msg', $msg);
    }

    public function edit_category(Request $request){
        $id = $request->id;
        $model = Category::find($id);
        return view('admin.category.manage_category',compact('model'));
    }
    
    public function edit_category_process(Request $request){
        $model = Category::find($request->id);
        $model->category_name = $request->name;
        $model->category_status = $request->status;
        $model->save();
        $msg = 'Successfully edit category';
        return redirect()->route('category')->with('msg', $msg);
    }

    public function delete_category(Request $request){
        $model = Category::find($request->id);
        $model->delete();
        $msg = 'Successfully deleted category';
        return redirect()->route('category')->with('msg', $msg);
    }


}
