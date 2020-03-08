<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.index');
});

/*
=============
Admin Routes
=============
*/

//Category Route

Route::get('admin/category','Admin\Category\CategoryController@category')->name('categories');
Route::post('admin/category/insert','Admin\Category\CategoryController@categoryInsert')->name('category.insert');
Route::get('category/delete/{id}','Admin\Category\CategoryController@delete');
Route::get('category/edit/{id}','Admin\Category\CategoryController@edit');
Route::post('category/update/{id}','Admin\Category\CategoryController@update');

//Brand Route
Route::get('admin/brand','Admin\Brand\BrandController@brnad')->name('brands');
Route::post('admin/brand/insert','Admin\Brand\BrandController@brandInsert')->name('brand.insert');
Route::get('brand/edit/{id}','Admin\Brand\BrandController@edit');
Route::post('brand/update/{id}','Admin\Brand\BrandController@update');
Route::get('brand/delete/{id}','Admin\Brand\BrandController@delete');
//Login Route
Route::prefix('admin')->group(function() {
   Route::get('/login','Auth\AdminLoginController@showLoginForm')->name('admin.login');
   Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
   Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
   Route::get('/', 'Auth\AdminController@index')->name('admin.dashboard');
  }) ;

/*
=============
Users Routes
=============
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
