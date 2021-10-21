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

use Webman\Route;

# user api
Route::post('/user/get_token', 'app\controller\User@getToken');
Route::post('/user/refresh_token', 'app\controller\User@refreshToken');
Route::post('/user/get_user_info', 'app\controller\User@getUserInfo')->middleware(\support\middleware\AuthCheck::class);
Route::post('/user/add', 'app\controller\User@addUser')->middleware(\support\middleware\AuthCheck::class);
Route::post('/user/update', 'app\controller\User@updateUser')->middleware(\support\middleware\AuthCheck::class);
Route::post('/user/delete', 'app\controller\User@deleteUser')->middleware(\support\middleware\AuthCheck::class);

# options api
Route::post('/options/add', 'app\controller\Options@addOptions')->middleware(\support\middleware\AuthCheck::class);
Route::post('/options/update', 'app\controller\Options@updateOptions')->middleware(\support\middleware\AuthCheck::class);
Route::post('/options/delete', 'app\controller\Options@deleteOptions')->middleware(\support\middleware\AuthCheck::class);
Route::post('/options/get_by_code', 'app\controller\Options@getOptionsByCode')->middleware(\support\middleware\AuthCheck::class);

# media api
Route::post('/media/add', 'app\controller\Media@addMedia')->middleware(\support\middleware\AuthCheck::class);
Route::post('/media/update', 'app\controller\Media@updateMedia')->middleware(\support\middleware\AuthCheck::class);
Route::post('/media/delete', 'app\controller\Media@deleteMedia')->middleware(\support\middleware\AuthCheck::class);
Route::post('/media/get_list', 'app\controller\Media@getMediaList')->middleware(\support\middleware\AuthCheck::class);
Route::post('/media/get_details', 'app\controller\Media@getMediaDetails')->middleware(\support\middleware\AuthCheck::class);