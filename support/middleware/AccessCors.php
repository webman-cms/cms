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

namespace support\middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;

class AccessCors implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        // 处理跨域请求
        if ($request->method() == 'OPTIONS') {
            $response = response('');
        } else {
            $response = $next($request);
        }
        $response->withHeaders([
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET,POST,PUT,DELETE,OPTIONS',
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type, Token, X-Userinfo, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With,Accept,Origin, Device-Unique-Code',
        ]);

        return $response;
    }
}
