<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Webman\Http\Response;
use Webman\Route;

# user api
Route::group('/user/', function () {
    Route::add(['POST', 'OPTIONS'], 'get_token', 'app\controller\User@getToken');
    Route::add(['POST', 'OPTIONS'], 'refresh_token', 'app\controller\User@refreshToken');
    Route::add(['POST', 'OPTIONS'], 'get_user_info', 'app\controller\User@getUserInfo')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'add', 'app\controller\User@addUser')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'update', 'app\controller\User@updateUser')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'delete', 'app\controller\User@deleteUser')->middleware(\support\middleware\AuthCheck::class);
});

# options api
Route::group('/options/', function () {
    Route::add(['POST', 'OPTIONS'], 'add', 'app\controller\Options@addOptions')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'update', 'app\controller\Options@updateOptions')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'delete', 'app\controller\Options@deleteOptions')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'get_by_code', 'app\controller\Options@getOptionsByCode')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'get_presigned_put_object_url', 'app\controller\Options@getPresignedPutObjectUrl')->middleware(\support\middleware\AuthCheck::class);
});

# media api
Route::group('/media/', function () {
    Route::add(['POST', 'OPTIONS'], 'add', 'app\controller\Media@addMedia')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'update', 'app\controller\Media@updateMedia')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'delete', 'app\controller\Media@deleteMedia')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'get_list', 'app\controller\Media@getMediaList')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'get_details', 'app\controller\Media@getMediaDetails')->middleware(\support\middleware\AuthCheck::class);
});

# tag api
Route::group('/tag/', function () {
    Route::add(['POST', 'OPTIONS'], 'add', 'app\controller\Tag@addTag')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'update', 'app\controller\Tag@updateTag')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'delete', 'app\controller\Tag@deleteTag')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'get_list', 'app\controller\Tag@getTagList')->middleware(\support\middleware\AuthCheck::class);
});

# category api
Route::group('/category/', function () {
    Route::add(['POST', 'OPTIONS'], 'add', 'app\controller\Category@addCategory')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'update', 'app\controller\Category@updateCategory')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'delete', 'app\controller\Category@deleteCategory')->middleware(\support\middleware\AuthCheck::class);
    Route::add(['POST', 'OPTIONS'], 'get_tree_list', 'app\controller\Category@getCategoryTreeList')->middleware(\support\middleware\AuthCheck::class);
});

// 回退路由，设置默认的路由兜底
Route::fallback(function (\support\Request $request) {
    return new Response(404, []);
});

# 关闭默认路由解析
Route::disableDefaultRoute();