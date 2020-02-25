<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Category;
use DB;

class CategoryController extends Controller
{
   public function __construct()
    {
    	$this->middleware('auth:admin');
    }

    public function category()
    {
    	$category = Category::all();
    	return view('admin.category.category',compact('category'));
    }

    public function categoryInsert(Request $request)
    {
    	$validatedData = $request->validate([
        'category_name' => 'required|unique:categories|max:255',
    ]);
    	$category = new Category();
    	$category->category_name = $request->category_name;
    	$confirm = $category->save();
    	if($confirm){
    		$sms = array(
                'message' => 'Category inserted successfully.',
                'alert-type' => 'success'
            );
            return Redirect()->back()->with($sms);
    	}else{
    		$sms = array(
                'message' => 'Something went wrong.',
                'alert-type' => 'error'
            );
            return Redirect()->back()->with($sms);
    	}
    }

    public function delete($id)
    {
    	$category = Category::find($id);
    	$category->delete();
    	$sms = array(
                'message' => 'Category deleted successfully.',
                'alert-type' => 'success'
            );
    	return Redirect()->back()->with($sms);
    }

    public function edit($id)
    {
    	$category = Category::findOrFail($id);
    	return view('admin.category.categoryEdit',compact('category'));
    }

    public function update(Request $request,$id)
    {
    	$validatedData = $request->validate([
        'category_name' => 'required|max:255',
    ]);

    	// $category = Category::find($id);
    	// $category->category_name = $request->category_name;
    	// $confirm = $category->save();
    	$data = array();
    	$data['category_name'] = $request->category_name;
    	$confirm = DB::table('categories')->where('id',$id)->update($data); 
    	if($confirm){
    		$sms = array(
                'message' => 'Category updated successfully.',
                'alert-type' => 'success'
            );
    	return Redirect()->route('categories')->with($sms);
    	}else{
    		$sms = array(
                'message' => 'Nothing to updated.',
                'alert-type' => 'info'
            );
    	return Redirect()->route('categories')->with($sms);
    	}
    }
}
