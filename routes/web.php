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


/*
|--------------------------------------------------------------------------
| Start Home Site                                                       │
|-------------------------------------------------------------------------
*/
Route::get('/','Front\SiteController@index')->name('home.index');

/*
|--------------------------------------------------------------------------
| Start Admin Panel                                                       │
|-------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/','Backend\AdminController@index')->name('dashboard');


    // -------------------- Start Category --------------------
        create_crud_route('category','CategoryController');
    // -------------------- End Category ----------------------

    // -------------------- Start Brand -----------------------
        create_crud_route('brand','BrandController');
    // -------------------- End Brand -------------------------

    // -------------------- Start Color -----------------------
        create_crud_route('color','ColorController');
    // -------------------- End Color -------------------------

    // -------------------- Start Product ---------------------
        create_crud_route('product','ProductController',true);  // True ==> except(['show'])
    // -------------------- End Product -----------------------

    // -------------------- Start Warranty --------------------
        create_crud_route('warranty','WarrantyController');
    // -------------------- End Warranty ----------------------

    // -------------------- Start Warranty --------------------
        create_crud_route('productWarranty','productWarrantyController');
    // -------------------- End Warranty ----------------------

    // -------------------- Start ProductGallery --------------------
        Route::get('product/gallery/{id}','ProductGalleryController@gallery')->name('product.gallery');
        Route::post('product/gallery/Upload/{id}','ProductGalleryController@galleryUpload')->name('product.galleryUpload');
        Route::delete('product/gallery/{id}','ProductGalleryController@destroy')->name('gallery.destroy');
        Route::post('product/change_images_status/{id}','ProductGalleryController@change_image');
    // -------------------- End ProductGallery ----------------------

    // -------------------- Start Slider --------------------
        create_crud_route('slider','SliderController');
        Route::post('slider/del_img/{id}','Backend\SliderController@del_img');
    // -------------------- End Slider ----------------------

    // -------------------- Start Item Category --------------------
        Route::get('category/{id}/item','Backend\ItemController@item')->name('item.index');
        Route::post('category/{id}/item','Backend\ItemController@add_item')->name('item.addItem');
        Route::delete('category/item/{id}','Backend\ItemController@destroy')->name('item.destroy');
    // -------------------- End Item Category ----------------------

    // -------------------- Start Item Value Product --------------------
        Route::get('product/{id}/item','Backend\ProductController@items')->name('product.items');
        Route::post('product/{id}/item','Backend\ProductController@add_items')->name('product.add_items');
    // -------------------- End Item Value Product ----------------------
	
	// -------------------- Start Product Filter --------------------
        Route::get('product/{id}/filter','Backend\ProductController@filters')->name('product.filters');
        Route::post('product/{id}/filter','Backend\ProductController@add_filters')->name('product.add_filters');
    // -------------------- End Product Filter ----------------------

    // -------------------- Start Item Category --------------------
        Route::get('category/{id}/filter','Backend\FilterController@filter')->name('filter.index');
        Route::post('category/{id}/filter','Backend\FilterController@add_filter')->name('filter.addItem');
        Route::delete('category/filter/{id}','Backend\FilterController@destroy')->name('filter.destroy');
    // -------------------- End Item Category ----------------------

    // -------------------- Start Incredible Offers --------------------
        Route::get('incredible-offers','Backend\AdminController@incredible_offers')->name('incredible-offers');
    // -------------------- End Incredible Offers ----------------------

    // -------------------- Start Incredible Offers Api --------------------
        Route::get('ajax/getWarranty','Backend\AdminController@getWarranty')->name('incredible-offers.getWarranty');
    // -------------------- End Incredible Offers Api ----------------------

});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
