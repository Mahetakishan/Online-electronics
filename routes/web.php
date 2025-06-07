<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controller\UserController;
use App\Http\Controllers\productcontroller;
use App\Http\Controller\categorycontroller;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('.commonpages.dashboard');
});

Route::get('/register',[AuthController::class,'loadRegister']);
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::get('/login',function(){
     return redirect('/');
});
Route::get('/getallproducts', 'App\Http\Controllers\productcontroller@index')->name('getallprod');
Route::get('/login',[AuthController::class,'loadLogin'])->name('loadlogin');
Route::post('/login',[AuthController::class,'login'])->name('login');
Route::get('/logout',[AuthController::class,'logout']);
Route::get('/getsubcategories/{category}','App\Http\Controllers\categorycontroller@getSubcategories');
Route::get('/getproducts', 'App\Http\Controllers\productcontroller@getAllProducts');
Route::get('/getproducts/{subcategory}','App\Http\Controllers\productcontroller@getProductsBySubcategory');
Route::get('/getproducts/category/{category}', 'App\Http\Controllers\productcontroller@getProductsByCategory');
Route::get('/getaddtocart/{id}','App\Http\Controllers\productcontroller@Loadcart')->name('Loadcart');
Route::get('/getviewcart','App\Http\Controllers\productcontroller@viewcart');

Route::get('/getaddtowishlist/{id}','App\Http\Controllers\productcontroller@addwishlist');

Route::group(['prefix' => 'admin','middleware'=>['web','isAdmin']],function(){
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('adminindex');
    Route::get('/create',[AdminController::class,'loadForm'])->name('load');
    Route::post('/addproduct',[AdminController::class,'add'])->name('addProduct');
    Route::get('/view',[AdminController::class,'view'])->name('ViewProduct');
    Route::get('/edit/{id}',[AdminController::class,'edit'])->name('loadEdit');
    Route::post('/edit',[AdminController::class,'update'])->name('Upd');
    Route::get('/delete/{id}',[AdminController::class,'delete'])->name('delete');
    Route::get('/createcategory',[AdminController::class,'loadCatForm'])->name('loadCategory');
    Route::post('/addcategory',[AdminController::class,'addcategory'])->name('addCategory');
    Route::get('/viewcategory',[AdminController::class,'viewcategory'])->name('ViewCategory');
    Route::get('/editcategory/{id}',[AdminController::class,'editcat'])->name('loadEditcat');
    Route::post('/editcategory/{id}',[AdminController::class,'updatecat'])->name('Updcat');
    Route::get('/deletecategory/{id}',[AdminController::class,'deletecat'])->name('deletecat');
    Route::get('/createsubcategory',[AdminController::class,'loadsubCatForm'])->name('loadsubCategory');
    Route::post('/addsubcategory',[AdminController::class,'addsubcategory'])->name('addsubCategory');
    Route::get('/viewsubcategory',[AdminController::class,'viewsubcategory'])->name('ViewSubCategory');
    Route::get('/editsubcategory/{id}',[AdminController::class,'editsubcat'])->name('loadEditsubcat');
    Route::post('/editsubcategory/{id}',[AdminController::class,'updatesubcat'])->name('Updsubcat');
    Route::delete('delete-subcategory','App\Http\Controllers\AdminController@deletesubcat');
    Route::get('/getsubcat/{id}',[AdminController::class,'getSubcategories']);
    Route::get('/viewcart',[AdminController::class,'getcartdet']);
    Route::get('/search', [AdminController::class, 'search'])->name('searchproduct');
    Route::get('/viewwishlist',[AdminController::class,'getwishdet']);
    Route::get('/vieworders',[AdminController::class,'getodrdet'])->name('Adminorderview');
    Route::get('/updatestatus/{id}',[productcontroller::class,'updatestatus'])->name('Updatestatus');
});

Route::group(['middleware'=>['web','isUser']],function(){
    Route::get('/dashboard','App\Http\Controllers\UserController@dashboard')->name('products.index'); 
    Route::get('/allproducts', 'App\Http\Controllers\categorycontroller@index')->name('allprod');
    Route::get('/subcategories/{category}','App\Http\Controllers\categorycontroller@getSubcategories');
    Route::get('/products', 'App\Http\Controllers\productcontroller@getAllProducts');
    Route::get('/products/{subcategory}','App\Http\Controllers\productcontroller@getProductsBySubcategory');
    Route::get('/products/category/{category}', 'App\Http\Controllers\productcontroller@getProductsByCategory');
    Route::get('/addtocart/{id}','App\Http\Controllers\productcontroller@Loadcart')->name('Loadcart');
    Route::post('addtocart/{id}','App\Http\Controllers\productcontroller@addtocart')->name('cart.add');
    Route::get('/viewcart','App\Http\Controllers\productcontroller@viewcart')->name('viewcart');
    Route::delete('/removecart','App\Http\Controllers\productcontroller@deletecart');
    Route::get('/user/profile/{id}','App\Http\Controllers\UserController@profileview')->name('user.profile');
    Route::post('/updatecart/{id}', 'App\Http\Controllers\productcontroller@updateCartItem');
    Route::post('/removewishlist/{id}','App\Http\Controllers\productcontroller@removeWishlist')->name('removewishlist');
    Route::post('/addtowishlist/{id}','App\Http\Controllers\productcontroller@addWishlist')->name('addwishlist');
    Route::get('/viewwishlist','App\Http\Controllers\productcontroller@viewwishlist')->name('viewwish');
    Route::delete('/removewishlist','App\Http\Controllers\productcontroller@deletewishlist');
    Route::get('/Loadorder/{id}','App\Http\Controllers\productcontroller@loadorder')->name('odrload');
    Route::post('/Loadorder/{id}','App\Http\Controllers\productcontroller@placeorder')->name('odr');
    Route::get('/getstate/{country}','App\Http\Controllers\productcontroller@getStates');
    Route::get('/getcity/{state}','App\Http\Controllers\productcontroller@getCities');
    Route::get('/viewallorder','App\Http\Controllers\productcontroller@viewallodr')->name('odrall');
    Route::delete('/removeorder','App\Http\Controllers\productcontroller@deleteorder');
 });