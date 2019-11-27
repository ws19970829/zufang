<?php
Route::group(['prefix'=>'admin','namespace'=>'Admin','as'=>'admin.'],function(){
    //登录
    Route::get('login','LoginController@index')->name('login');
    Route::post('login','LoginController@login')->name('login');
    Route::get('getCaptcha','LoginController@getCaptcha')->name('getCaptcha');


    //es搜索
    Route::get('esinitindex','EsController@initindex')->name('initindex');
    Route::get('esinitindex1','EsController@initindex1')->name('initindex');


//    首页
    Route::group(['middleware'=>['checkadmin']],function(){

        Route::get('index','IndexController@index')->name('index');
        Route::get('welcome','IndexController@welcome')->name('welcome');
        Route::get('logout','IndexController@logout')->name('logout');

        //文件上传
        Route::post('base/upfile','BaseController@upfile')->name('base.upfile');

        //用户页
        Route::get('user/index','AdminController@index')->name('user.index');
        Route::get('user/add','AdminController@add')->name('user.add');
        Route::post('user/create','AdminController@create')->name('user.create');
        Route::get('user/edit/{id}','AdminController@edit')->name('user.edit');
        Route::put('user/update/{id}','AdminController@update')->name('user.update');
        Route::delete('user/delete/{id}','AdminController@delete')->name('user.delete');
        //全选删除
        Route::delete('user/delall','AdminController@delall')->name('user.delall');
        //软删除恢复
        Route::get('user/restore','AdminController@restore')->name('user.restore');
        //个人信息
        Route::get('me/index','MeController@index')->name('me.index');
        Route::put('me/update/{id}','MeController@update')->name('me.update');
        //角色
        Route::resource('role','RoleController');
        Route::get('role/sel','RoleController@sel')->name('role.sel');
        //权限
        Route::resource('node','NodeController');
        Route::get('node/sel','NodeController@sel')->name('node.sel');

        //文章权限
        Route::delete('article/delall','ArticleController@delall')->name('article.delall');
        Route::get('article/delimg','ArticleController@delimg')->name('article.delimg');
        Route::post('article/upfile','ArticleController@upfile')->name('article.upfile');
        Route::resource('article','ArticleController');
        //房源属性
        Route::resource('fangattr','FangAttrController');
        //房东
        //房东导出excel
        Route::get('fangowner/export','FangOwnerController@export')->name('fangowner.export');
        Route::resource('fangowner','FangOwnerController');
        //房东属性
        //
        Route::get('fang/city','FangController@getCity')->name('fang.city');
        Route::resource('fang','FangController');

        //预约管理
        Route::resource('notice','NoticeController');
        //接口账号管理
        Route::resource('apiuser','ApiuserController');
        //



    });




});
