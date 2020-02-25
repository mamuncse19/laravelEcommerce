<?php

namespace App\Http\Controllers\Admin\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Brand;
use DB;

class BrandController extends Controller
{
   public function __construct()
   {
   		$this->middleware('auth:admin');
   }

   public function brnad()
   {
   		$brand = Brand::all();
   		return view('admin.brand.brand',compact('brand'));
   }

   public function brandInsert(Request $request)
   {
   		$validatedData = $request->validate([
        'brand_name' => 'required|unique:brands|max:255',
        'brand_logo' => 'required',
    ]);
   		$brand = new Brand();
   		$brand->brand_name = $request->brand_name;
   		$image = $request->file('brand_logo');
   		if($image>0)
   		{
   			$image_name = time();
   			$ext = $image->getClientOriginalExtension();
   			$image_full_name = $image_name.'.'.$ext;
   			$path = 'public/img/brand/';
   			$image_url = $path.$image_full_name;
   			$success = $image->move($path,$image_full_name);
   			if($success)
   			{
   				$brand->brand_logo = $image_url;
   				$con = $brand->save();
   				if($con)
   				{
   					$sms = array(
		                'message' => 'Brand inserted successfully.',
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
   			}else{
   				$sms = array(
		                'message' => 'Image Problem.',
		                'alert-type' => 'error'
	            	);
	            	return Redirect()->back()->with($sms);
   			}
   		}else{
   			$brand->save();
   			$sms = array(
                'message' => 'Brnad inserted without image',
                'alert-type' => 'success'
        	);
        	return Redirect()->back()->with($sms);
   		}
   }
}
