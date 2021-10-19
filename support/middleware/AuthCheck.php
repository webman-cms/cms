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

use support\ErrorCode;
use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use app\service\User as UserService;

class AuthCheck implements MiddlewareInterface
{
    public function process(Request $request, callable $next): Response
    {
        // 验证token
        $bearerToken = $request->header('authorization');

        if (empty($bearerToken)) {
            throw_http_exception('Token does not exist.', ErrorCode::TokenNotExist);
        }

        // 去掉 Bearer 前缀
        $token = str_replace('Bearer ', '', $bearerToken);

        // 验证 token 有效性
        $user = new UserService();
        $user->verifyToken($token, 'access_token',$request->getRealIp());

        return $next($request);
    }
}