<?php
/**
 * 用户信息相关操作 service 类
 */

namespace app\service;

use app\model\User as UserModel;
use support\ErrorCode;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class User
{

    protected $jwtConfig;

    /**
     * @var Configuration
     */
    protected Configuration $configuration;

    public function __construct()
    {
        $this->jwtConfig = config("jwt");
        $this->configuration = Configuration::forSymmetricSigner(new Sha256(), InMemory::plainText($this->jwtConfig['secret']));
    }

    /**
     * 生成 token
     * @param $userData
     * @param $expire
     * @param string $ip
     * @return string
     */
    protected function generateToken($userData, $expire, $ip = "127.0.0.1"): string
    {
        $now = new DateTimeImmutable();
        $token = $this->configuration->builder()
            ->issuedBy($this->jwtConfig['domain'])
            ->permittedFor($this->jwtConfig['domain'])
            ->identifiedBy($this->jwtConfig['sign'], true)
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify('+1 minute'))
            ->expiresAt($now->modify("+{$expire} second"))
            ->withClaim('id', $userData['id'])
            ->withClaim('phone', $userData['phone'])
            ->withClaim('ip', $ip)
            ->getToken($this->configuration->signer(), $this->configuration->signingKey());

        return $token->toString();
    }

    /**
     * 新增用户信息
     * @param array $userData
     * @return array
     */
    public function addUser(array $userData): array
    {
        return [];
    }

    /**
     * 修改用户信息（包含密码修改）
     * @param array $userData
     * @return array
     */
    public function modifyUser(array $userData): array
    {
        return [];
    }

    /**
     * 删除用户
     * @param int $userId
     * @return int
     */
    public function deleteUser(int $userId): int
    {
        return 0;
    }

    /**
     * 获取用户信息
     * @param int $userId
     * @return array
     */
    public function getUserInfo(int $userId): array
    {
        return [];
    }

    /**
     * 检查用户名和密码信息
     * @param string $loginName
     * @param string $password
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function checkUserPassword(string $loginName, string $password): array
    {
        $exitUserData = UserModel::field('id,login_name,name,sex,phone,email,password')
            ->where('login_name', '=', $loginName)
            ->find()
            ->toArray();

        if (empty($exitUserData)) {
            // 用户不存在
            throw_http_exception('Login name or password error.', ErrorCode::LoginNameOrPasswordError);
        }

        if (!password_verify($password, $exitUserData['password'])) {
            throw_http_exception('Login name or password error.', ErrorCode::LoginNameOrPasswordError);
        }

        // 移除密码信息
        unset($exitUserData['password']);

        return $exitUserData;
    }

    /**
     * 生成jwt Token，通过客户端ip来限制token使用范围
     * @param $userData
     * @param $clientIp
     */
    private function generateLoginTokenByUserData($userData, $clientIp)
    {

    }

    /**
     * 获取token
     * @param string $loginName
     * @param string $password
     * @param string $clientIp
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getToken(string $loginName, string $password, string $clientIp): array
    {
        // 验证用户信息是否存在
        $userData = $this->checkUserPassword($loginName, $password);

        // 生成token信息
        $accessExpires = time() + $this->jwtConfig['expire'];
        $refreshExpires = time() + $this->jwtConfig['refresh_expire'];
        $accessToken = $this->generateToken($userData, $accessExpires, $clientIp);
        $refreshToken = $this->generateToken($userData, $refreshExpires, $clientIp);

        return [
            'user_data' => $userData,
            'token' => [
                'access_token' => $accessToken,
                'access_token_expires' => $accessExpires,
                'refresh_token' => $refreshToken,
                'refresh_token_expires' => $refreshExpires,
            ]
        ];
    }

    /**
     * 属性token
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken(string $refreshToken): array
    {
        return [];
    }

    /**
     * 验证token
     * @param string $accessToken
     * @return bool
     */
    public function verifyToken(string $accessToken): bool
    {
        return true;
    }
}