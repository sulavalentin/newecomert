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
/*Generale*/
Route::get('/','Controller@home');
Route::get('/test','Controller@test');
Route::get('/menu/{id}','Controller@menu');
Route::get('/submenu/{id}','Controller@submenu');
Route::get('/sort={sort}/[{id_submenu}]-{numeitem}/page={pag}','Controller@produse');
Route::get('/product/{id_item}','Controller@oneprodus');
Route::get('/cart','CartController@cart');
/*Cos*/
Route::post('/addcart','CartController@addcart');
Route::post('/delcart','CartController@delcart');
Route::post('/updatecart','CartController@updatecart');
Route::post('/totalprice','CartController@totalprice');
Route::post('/getCountCart','CartController@getCountCart');
/*User*/
Route::get("/login-{facebook}", 'RegisterController@goToFacebook');
Route::get("/login-back/{facebook}",'RegisterController@goToFacebookBack');
Route::post('/register','RegisterController@register');
Route::post('/login','RegisterController@login');
Route::get('/confirm/{email}-{token}','RegisterController@comfirm');
Route::get('/exit','RegisterController@exituser');

/*Admin*/
Route::get('/admin','Admin\AdminController@base');
Route::get('/admin/login','Admin\AdminController@getLogin');
Route::post('/admin/login','Admin\RegisterController@login');
Route::post('/admin/register','Admin\RegisterController@register');
Route::get('/exitadmin','Admin\RegisterController@exitadmin');
Route::post('/admin/deleteadmin','Admin\SettingController@deleteadmin');
Route::post('/admin/registerother','Admin\RegisterController@registerother');
Route::get('/admin/confirm/{email}-{token}','Admin\RegisterController@comfirmadmin');
Route::post('/admin/modificarol','Admin\SettingController@modificarol');
Route::get('/admin/reset','Admin\AdminController@reset');
Route::post('/admin/reset','Admin\RegisterController@sendemail');
Route::post('/admin/setcode','Admin\RegisterController@setcode');
Route::post('/admin/newpass','Admin\RegisterController@newpass');
/*Actiuni*/
Route::get('/admin/actiune/{tip}','Admin\SettingController@actiune');
Route::post('/admin/getelement/{element}','Admin\SettingController@getElement');
Route::post('/admin/addelement/{table}','Admin\SettingController@addElement');
Route::post('/admin/modelement/{element}','Admin\SettingController@modElement');
Route::get('/admin/getproducts/{id}','Admin\SettingController@getProduct');

Route::post('/admin/getTabele','Admin\SettingController@getTabele');
/*Tabele*/
Route::post('/admin/saveTable','Admin\SettingController@saveTable');
Route::post('/admin/addGroup','Admin\SettingController@addGroup');
Route::post('/admin/modificaColoana','Admin\SettingController@modificaColoana');
Route::post('/admin/deleteColoana','Admin\SettingController@deleteColoana');
/*Iteme*/
Route::post('/admin/addItem','Admin\SettingController@addItem');
Route::post('/admin/modificaItem','Admin\SettingController@modificaItem');
Route::post('/admin/deleteItem','Admin\SettingController@deleteItem');
Route::post("/admin/upload","Admin\SettingController@upload");
Route::post('/admin/deleteImage','Admin\SettingController@deleteImage');
Route::post('/admin/deleteAllImages','Admin\SettingController@deleteAllImages');
Route::post('/admin/defaultImage','Admin\SettingController@defaultImage');