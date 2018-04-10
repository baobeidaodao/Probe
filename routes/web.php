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
 * 监听 sql
 **/
Event::listen('illuminate.query', function ($sql, $param) {
    $sql = str_replace_array("\?", $param, $sql);
    echo $sql . "<br>";
});


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/** 路由权限限定 */
// Entrust::routeNeedsPermission('admin/*', ['super_manager',]);
// Entrust::routeNeedsRole('admin/*', ['admin',]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/', 'AdminController@index');
    Route::get('/update-statistics', 'AdminController@updateStatistics');
    Route::any('/update-report-config', 'AdminController@updateReportConfig');

    /** 用户 */
    Route::post('users/search', 'UsersController@index');
    Route::resource('users', 'UsersController');

    /** 角色 */
    Route::post('roles/search', 'RolesController@index');
    Route::resource('roles', 'RolesController');

    /** 权限 */
    Route::post('permissions/search', 'PermissionsController@index');
    Route::resource('permissions', 'PermissionsController');

    /** 部门 */
    Route::post('department/search', 'DepartmentController@index');
    Route::resource('department', 'DepartmentController');

    /** ip */
    Route::any('ip/check', 'IpController@check');
    Route::post('ip/search', 'IpController@index');
    Route::resource('ip', 'IpController');

    /** 日志 */
    Route::any('logs/search', 'LogController@index');
    Route::resource('logs', 'LogController');

    /** u disk */
    Route::any('u-disk/search', 'UDiskController@index');
    Route::resource('u-disk', 'UDiskController');

    /** 统计信息 */
    Route::any('statistics/summary', 'StatisticsController@summary');
    Route::any('statistics/group', 'StatisticsController@group');
    Route::any('statistics/province', 'StatisticsController@province');
    Route::any('statistics/city', 'StatisticsController@city');
    Route::resource('statistics', 'StatisticsController');
    Route::any('statistics/search', 'StatisticsController@index');

    /** 数据查询 */
    Route::any('report/group', 'ReportController@group');
    Route::any('report/province', 'ReportController@province');
    Route::any('report/export', 'ReportController@export');
    Route::resource('report', 'ReportController');
    Route::any('report/search', 'ReportController@index');

});

Route::group(['prefix' => 'test',], function () {
    Route::get('/', 'TestController@index');
});
