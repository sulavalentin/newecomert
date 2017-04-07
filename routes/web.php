<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
/*Comenzi rutes*/
Route::get('/admin/comenzi/{page}','Admin\ComenziAdminController@comenziadmin');
/*Admin*/
Route::get('/admin','Admin\AdminController@base');
Route::get('/admin/login','Admin\AdminController@getLogin');
Route::post('/admin/login','Admin\RegisterController@login');
Route::post('/admin/register','Admin\RegisterController@register');
Route::get('/exitadmin','Admin\RegisterController@exitadmin');
Route::post('/admin/registerother','Admin\RegisterController@registerother');
Route::get('/admin/confirm/{email}-{token}','Admin\RegisterController@comfirmadmin');
Route::get('/admin/reset','Admin\AdminController@reset');
Route::post('/admin/reset','Admin\RegisterController@sendemail');
Route::post('/admin/setcode','Admin\RegisterController@setcode');
Route::post('/admin/newpass','Admin\RegisterController@newpass');

/*Admins*/
Route::get('/admin/admins','Admin\AdminController@admins');
Route::post('/admin/modificarol','Admin\AdminController@modificarol');
Route::post('/admin/deleteadmin','Admin\AdminController@deleteadmin');
/*Products routes*/
Route::get('/admin/products','Admin\AdminController@products');
Route::get('/admin/products/{id}','Admin\ProductsController@getProducts');
Route::post('/admin/getoneadd','Admin\ProductsController@getoneadd');
Route::post('/admin/getoneitem','Admin\ProductsController@getoneitem');
    /*Iteme*/
Route::post('/admin/addItem','Admin\ProductsController@addItem');
Route::post('/admin/modificaItem','Admin\ProductsController@modificaItem');
Route::post('/admin/deleteItem','Admin\ProductsController@deleteItem');
Route::post("/admin/upload","Admin\ProductsController@upload");
Route::post('/admin/deleteImage','Admin\ProductsController@deleteImage');
Route::post('/admin/deleteAllImages','Admin\ProductsController@deleteAllImages');
Route::post('/admin/defaultImage','Admin\ProductsController@defaultImage');

/*Tabele routes*/
Route::get('/admin/tables','Admin\AdminController@tables');
Route::post('/admin/getTabele','Admin\TablesController@getTabele');

Route::post('/admin/saveTable','Admin\TablesController@saveTable');
Route::post('/admin/addGroup','Admin\TablesController@addGroup');
Route::post('/admin/modificaColoana','Admin\TablesController@modificaColoana');
Route::post('/admin/deleteColoana','Admin\TablesController@deleteColoana');

/*Menu rutes*/
Route::get('/admin/menu','Admin\AdminController@menu');
Route::post('/admin/getOnemenu','Admin\MenuController@getOnemenu');
Route::post('/admin/getOnesubmenu','Admin\MenuController@getOnesubmenu');
Route::post('/admin/getOneitemssubmenu','Admin\MenuController@getOneitemssubmenu');

Route::post('/admin/addMenu','Admin\MenuController@addMenu');
Route::post('/admin/addSubmenu','Admin\MenuController@addSubmenu');
Route::post('/admin/addItemssubmenu','Admin\MenuController@addItemssubmenu');
Route::post('/admin/modMenu','Admin\MenuController@modMenu');
Route::post('/admin/modSubmenu','Admin\MenuController@modSubmenu');
Route::post('/admin/modItemssubmenu','Admin\MenuController@modItemssubmenu');

/*Slideshow rutes*/
Route::get('/admin/slideshow','Admin\AdminController@slideshow');
Route::post('/admin/addslideshow','Admin\SlideshowController@addslideshow');
Route::post('/admin/delslideshow','Admin\SlideshowController@delslideshow');








/*Generale -----------------------------*/
Route::get('/test','HomeController@test');

Route::get('/','HomeController@home');
Route::get('/menu/{id}','HomeController@menu');
Route::get('/submenu/{id}','HomeController@submenu');
Route::get('/sort={sort}/[{id_submenu}]-{numeitem}/page={pag}','HomeController@produse');
Route::get('/product/{id_item}','HomeController@oneprodus');
/*Favorite*/
Route::get('/favorite','FavoriteController@favorite');
Route::post('/addfavorite','FavoriteController@addfavorite');
Route::post('/deletefavorite','FavoriteController@deletefavorite');
Route::post('/getCountFavorite','FavoriteController@getCountFavorite');
/*Cos*/
Route::get('/cart','CartController@cart');
Route::post('/addcart','CartController@addcart');
Route::post('/delcart','CartController@delcart');
Route::post('/updatecart','CartController@updatecart');
Route::post('/getCountCart','CartController@getCountCart');
Route::post('/deleteallcart','CartController@deleteallcart');
/*Compare*/
Route::get('/compare','CompareController@compare');
Route::post('/addcompare','CompareController@addcompare');
Route::post('/deletecompare','CompareController@deletecompare');
/*User*/
Route::get("/login-{facebook}", 'RegisterController@goToFacebook');
Route::get("/login-back/{facebook}",'RegisterController@goToFacebookBack');
Route::post('/register','RegisterController@register');
Route::post('/login','RegisterController@login');
Route::get('/confirm/{email}-{token}','RegisterController@comfirm');
Route::get('/exit','RegisterController@exituser');
/*Cautare*/
Route::get('/search','SearchController@search');
/*Comanda*/
Route::get('/comanda','ComandaController@comanda');
Route::post('/endcomanda','ComandaController@endcomanda');
Route::get('/comandatrimisa','ComandaController@comandatrimisa');