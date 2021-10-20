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


Route::post('/user/get_token', 'app\controller\User@getToken');
Route::post('/user/refresh_token', 'app\controller\User@refreshToken');
Route::post('/user/get_user_info', 'app\controller\User@getUserInfo')->middleware(\support\middleware\AuthCheck::class);
Route::post('/user/add', 'app\controller\User@addUser')->middleware(\support\middleware\AuthCheck::class);
Route::post('/user/update', 'app\controller\User@updateUser')->middleware(\support\middleware\AuthCheck::class);
Route::post('/user/delete', 'app\controller\User@deleteUser')->middleware(\support\middleware\AuthCheck::class);