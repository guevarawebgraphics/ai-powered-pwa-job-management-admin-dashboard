<?php

/* dashboard routes */
Route::get('/', function () {
    return redirect('/admin/dashboard');
});

/* dashboard */
Route::get('/dashboard', [
    'uses' => '\App\Http\Controllers\AdminDashboardController@index',
    'as' => 'admin.dashboard',
]);
/* dashboard */

/* users */
Route::get('/users/draw',
    ['as' => 'admin.users.draw',
        'uses' => '\App\Http\Controllers\UserController@draw']
);

Route::resource('/users', 'UserController', [
    'as' => 'admin'
]);

Route::delete('/users/{id}/delete',
    ['as' => 'admin.users.delete',
        'uses' => '\App\Http\Controllers\UserController@destroy']
);
/* users */

/* roles */
Route::resource('/roles', 'RoleController', [
    'as' => 'admin'
]);

Route::delete('/roles/{id}/delete',
    ['as' => 'admin.roles.delete',
        'uses' => '\App\Http\Controllers\RoleController@destroy']
);
/* roles */

/* permissions */
Route::resource('/permissions', 'PermissionController', [
    'as' => 'admin'
]);

Route::delete('/permissions/{id}/delete',
    ['as' => 'admin.permissions.delete',
        'uses' => '\App\Http\Controllers\PermissionController@destroy']
);
/* permissions */

/* permission groups */
Route::resource('/permission_groups', 'PermissionGroupController', [
    'as' => 'admin'
]);

Route::delete('/permission_groups/{id}/delete',
    ['as' => 'admin.permission_groups.delete',
        'uses' => '\App\Http\Controllers\PermissionGroupController@destroy']
);
/* permission groups */

/* system settings */
Route::resource('/system_settings', 'SystemSettingController', [
    'as' => 'admin',
]);

Route::delete('/system_settings/{id}/delete',
    ['as' => 'admin.system_settings.delete',
        'uses' => '\App\Http\Controllers\SystemSettingController@destroy']
);
/* system settings */

/* posts */
Route::resource('/posts', 'PostController', [
    'as' => 'admin'
]);

Route::delete('/posts/{id}/delete',
    ['as' => 'admin.posts.delete',
        'uses' => '\App\Http\Controllers\PostController@destroy']
);
/* posts */

/* pages */
Route::resource('/pages', 'PageController', [
    'as' => 'admin'
]);

Route::delete('/pages/{id}/delete',
    ['as' => 'admin.pages.delete',
        'uses' => '\App\Http\Controllers\PageController@destroy']
);
/* pages */

/* ckeditor image upload */
Route::post('/ckeditor_image_upload',
    ['as' => 'admin.ckeditor_image_upload',
        'uses' => '\App\Http\Controllers\PageController@ckEditorImageUpload']
);
/* ckeditor image upload */

Route::post('/upload', '\App\Http\Controllers\PageController@upload')->name('admin.upload');

/* home_slides */
Route::resource('/home_slides', 'HomeSlideController', [
    'as' => 'admin'
]);

Route::delete('/home_slides/{id}/delete',
    ['as' => 'admin.home_slides.delete',
        'uses' => '\App\Http\Controllers\HomeSlideController@destroy']
);
/* home_slides */

/* products */
Route::resource('/products', 'ProductController', [
    'as' => 'admin'
]);

Route::delete('/products/{id}/delete',
    ['as' => 'admin.products.delete',
        'uses' => '\App\Http\Controllers\ProductController@destroy']
);
/* products */

/* product categories */
Route::resource('/product_categories', 'ProductCategoryController', [
    'as' => 'admin'
]);

Route::delete('/product_categories/{id}/delete',
    ['as' => 'admin.product_categories.delete',
        'uses' => '\App\Http\Controllers\ProductCategoryController@destroy']
);
/* product categories */

/* contacts */
Route::resource('/contacts', 'ContactController', [
    'as' => 'admin'
]);

Route::delete('/contacts/{id}/delete',
    ['as' => 'admin.contacts.delete',
        'uses' => '\App\Http\Controllers\ContactController@destroy']
);
/* contacts */

/* presses */


/*Route::resource('/faqs', 'FAQController', [
    'as' => 'admin'
]);

*/
