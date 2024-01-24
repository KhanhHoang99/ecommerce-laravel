<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\AccountController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\RateController;
use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\UserBlogController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Support\Facades\Auth;

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

Route::get('/test-mail', [MailController::class, 'index']);


Route::get('/', [HomeController::class, 'index'])->name('userPage');


Route::get('/blog', [UserBlogController::class, 'index'])->name('listBlog');
Route::get('/blog/{id}', [UserBlogController::class, 'show'])->name('blogDetail');
Route::post('/rate/{id}', [RateController::class, 'rate'])->name('rate');

Route::post('/blog/comment', [UserBlogController::class, 'comment'])->name('comment');



// Account and product
Route::get('/account', [AccountController::class, 'index'])->name('account');

Route::middleware('UserPermission')->prefix('product')->group(function () {
    
    Route::get('/', [ProductController::class, 'index'])->name('product');
    
    Route::get('add', [ProductController::class, 'create'])->name('addProduct');
    Route::post('add', [ProductController::class, 'store'])->name('storeProduct');
    Route::get('{id}', [ProductController::class, 'show'])->name('productDetail');
    
    Route::get('edit/{id}', [ProductController::class, 'edit'])->name('editProduct');
    Route::put('edit/{id}', [ProductController::class, 'update'])->name('updateProduct');
    
    Route::delete('{id}', [ProductController::class, 'destroy'])->name('deleteProduct');

});




Route::post('/cart', [CartController::class, 'addCartToSession'])->name('addCartToSession');
Route::post('/cart/up', [CartController::class, 'up'])->name('cartUp');
Route::post('/cart/down', [CartController::class, 'down'])->name('cartDown');
Route::post('/cart/delete', [CartController::class, 'delete'])->name('cartDelete');
Route::get('/cart', [CartController::class, 'show'])->name('showCart');

Route::get('/checkout', [CheckOutController::class, 'show'])->name('showCheckOut');



Route::get('/search', [SearchController::class, 'show'])->name('showSearch');
Route::post('/search', [SearchController::class, 'show'])->name('search');

Route::get('/search-advanced', [SearchController::class, 'showSearchAdvanced'])->name('showSearchAdvanced');
Route::post('/search-advanced', [SearchController::class, 'showSearchAdvanced'])->name('showSearchAdvanced');
Route::post('/search-range', [SearchController::class, 'SearchPriceRange'])->name('searchRange');









// get user login


Route::get('/user/login',  [LoginController::class, 'index'])->name('userLogin');


Route::post('/user/register',  [RegisterController::class, 'store'])->name('userRegister');

Route::post('/user/login', [LoginController::class, 'login'])->name('userLogin');

Route::post('/logout', 'Auth\LoginController@logout')->name('logout');



Auth::routes();

//middeware to check admin
// Admin Routes
Route::middleware('AdminPermision')->prefix('admin')->group(function () {

    // Dashboard
    Route::resource('/dashboard', DashboardController::class);

    // Country
    Route::resource('/country', CountryController::class);

    // Blog
    Route::resource('/blog', BlogController::class);

    // User Profile
    Route::resource('/user/profile', UserController::class);


    // category
    Route::get('category',  [CategoryController::class, 'index'])->name('category');
    Route::post('category',  [CategoryController::class, 'store'])->name('createCategory');
    Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('deleteCategory');
    
    // brand
    Route::get('brand',  [BrandController::class, 'index'])->name('brand');
    Route::post('brand',  [BrandController::class, 'store'])->name('createBrand');
    Route::delete('/brand/{id}', [BrandController::class, 'destroy'])->name('deleteBrand');



});

