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
Route::add(['POST', 'OPTIONS'], '/user/get_token', 'app\controller\User@getToken');
Route::add(['POST', 'OPTIONS'], '/user/refresh_token', 'app\controller\User@refreshToken');
Route::add(['POST', 'OPTIONS'], '/user/get_user_info', 'app\controller\User@getUserInfo')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/user/add', 'app\controller\User@addUser')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/user/update', 'app\controller\User@updateUser')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/user/delete', 'app\controller\User@deleteUser')->middleware(\support\middleware\AuthCheck::class);

# options api
Route::add(['POST', 'OPTIONS'], '/options/add', 'app\controller\Options@addOptions')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/options/update', 'app\controller\Options@updateOptions')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/options/delete', 'app\controller\Options@deleteOptions')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/options/get_by_code', 'app\controller\Options@getOptionsByCode')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/options/get_presigned_put_object_url', 'app\controller\Options@getPresignedPutObjectUrl')->middleware(\support\middleware\AuthCheck::class);

# media api
Route::add(['POST', 'OPTIONS'], '/media/add', 'app\controller\Media@addMedia')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/media/update', 'app\controller\Media@updateMedia')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/media/delete', 'app\controller\Media@deleteMedia')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/media/get_list', 'app\controller\Media@getMediaList')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/media/get_details', 'app\controller\Media@getMediaDetails')->middleware(\support\middleware\AuthCheck::class);

# tag api
Route::add(['POST', 'OPTIONS'], '/tag/add', 'app\controller\Tag@addTag')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/tag/update', 'app\controller\Tag@updateTag')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/tag/delete', 'app\controller\Tag@deleteTag')->middleware(\support\middleware\AuthCheck::class);
Route::add(['POST', 'OPTIONS'], '/tag/get_list', 'app\controller\Tag@getTagList')->middleware(\support\middleware\AuthCheck::class);

// 回退路由，设置默认的路由兜底
Route::fallback(function (\support\Request $request) {
    return new Response(404, []);
});

# 关闭默认路由解析
Route::disableDefaultRoute();