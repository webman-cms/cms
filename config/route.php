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


Route::any('/test', function ($request) {
    return response('test');
});

Route::any('/route-test', 'app\controller\Index@index');


Route::any('/json', 'app\controller\Index@json');

Route::any('/create', 'app\controller\Index@create');

Route::group('/user', function (){
    Route::group('/v1', function (){
        Route::any('/group_test2', 'app\controller\Index@groupTest2');
    })->middleware(\support\middleware\MiddlewareTest::class);
});


Route::any('/api/v1', 'app\api\v1\controller\Index@index');
