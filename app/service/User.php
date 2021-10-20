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
use Lcobucci\JWT\Validation\Constraint\identifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;


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
    protected function generateToken($userData, $expire, string $ip = "127.0.0.1"): string
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
     * 判断用户是否存在
     * @param int $userId
     * @throws \exception
     */
    protected function checkUserExist(int $userId): void
    {
        $existId = UserModel::where('id', '=', $userId)->value('id');

        if (empty($existId)) {
            throw_http_exception('User does not exist.', ErrorCode::UserNotExist);
        }
    }

    /**
     * 验证token
     * @param string $tokenString
     * @param string $field
     * @param string $clientIp
     * @throws \exception
     */
    public function verifyToken(string $tokenString, string $field, string $clientIp): void
    {
        try {
            $token = $this->configuration->parser()->parse($tokenString);

            $domain = new IssuedBy($this->jwtConfig['domain']);
            $this->configuration->setValidationConstraints($domain);

            $sign = new identifiedBy($this->jwtConfig['sign']);
            $this->configuration->setValidationConstraints($sign);

            if (!$this->configuration->validator()->validate($token, ...$this->configuration->validationConstraints())) {
                throw new \Exception('Wrong token.', ErrorCode::WrongToken);
            }

            //验证是否已经过期 获取 session已经过期
            $now = new DateTimeImmutable();
            if ($token->isExpired($now)) {
                throw new \Exception('Expire token.', ErrorCode::ExpireToken);
            }

            // 客户端ip不相等
            if ($token->claims()->get('ip') !== $clientIp) {
                throw new \Exception('Client ip not equal.', ErrorCode::ClientIpNotEqual);
            }

            // 验证token是否被删除
            $tokenExist = UserModel::where($field, '=', md5($tokenString))->value('id');
            if (empty($tokenExist)) {
                throw new \Exception('Token record not found.', ErrorCode::TokenRecordNotFound);
            }
        } catch (\Throwable $e) {
            if ($e->getCode() === ErrorCode::ExpireToken) {
                throw_http_exception($e->getMessage(), $e->getCode());
            } else {
                throw_http_exception('Invalid Token.', ErrorCode::InvalidToken);
            }
        }
    }

    /**
     * 新增用户信息
     * @param array $userData
     * @return array
     */
    public function addUser(array $userData): array
    {
        try {
            // 验证数据
            validate(\app\validate\User::class)
                ->scene('ModelAddUser')
                ->check($userData);

            // 增加数据
            $user = new UserModel();
            foreach ($userData as $key => $value) {
                $user->$key = $value;
            }

            $user->save();
            $addUserData = $user->toArray();

            // 密码不返回
            unset($addUserData['password']);

            return $addUserData;
        } catch (\Throwable $e) {
            // 输出错误信息
            throw_http_exception($e->getMessage(), ErrorCode::ModelAddUserError);
        }
        return [];
    }

    /**
     * 修改用户信息（包含密码修改）
     * @param array $userData
     * @return array
     */
    public function modifyUser(array $userData): array
    {
        // 检查用户是否存在
        $this->checkUserExist($userData['id']);

        $user = new UserModel();
        foreach ($userData as $key => $value) {
            $user->$key = $value;
        }

        $user->exists(true)->save();
        $addUserData = $user->toArray();

        // 密码不返回
        unset($addUserData['password']);

        return $addUserData;
    }

    /**
     * 删除用户
     * @param int $userId
     * @return array
     * @throws \exception
     */
    public function deleteUser(int $userId): array
    {
        //  user_id = 1 超级管理员账户不能删除
        if ($userId === 1) {
            throw_http_exception('The administrator account cannot be deleted.', ErrorCode::AdminAccountCannotBeDeleted);
        }

        // 检查用户是否存在
        $this->checkUserExist($userId);

        UserModel::where('id', '=', $userId)->delete();

        return ['id' => $userId];
    }

    /**
     * 获取用户信息
     * @param int $userId
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getUserInfo(int $userId): array
    {
        $userData = UserModel::field('id,login_name,name,sex,phone,email,last_visit_time,create_time')
            ->where('id', '=', $userId)
            ->find();

        if (empty($userData)) {
            throw_http_exception('User does not exist.', ErrorCode::UserNotExist);
        }

        return $userData->toArray();
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
        $existUserData = UserModel::field('id,login_name,name,sex,phone,email,password')
            ->where('login_name', '=', $loginName)
            ->find();

        if (empty($existUserData)) {
            // 用户不存在
            throw_http_exception('Login name or password error.', ErrorCode::LoginNameOrPasswordError);
        }

        $existUserData = $existUserData->toArray();
        if (!password_verify($password, $existUserData['password'])) {
            throw_http_exception('Login name or password error.', ErrorCode::LoginNameOrPasswordError);
        }

        // 移除密码信息
        unset($existUserData['password']);

        return $existUserData;
    }

    /**
     * 生成jwt Token，通过客户端ip来限制token使用范围
     * @param $userData
     * @param $clientIp
     */
    private function generateLoginTokenByUserData($userData, $clientIp)
    {

        // 生成token信息
        $accessExpires = time() + $this->jwtConfig['expire'];
        $refreshExpires = time() + $this->jwtConfig['refresh_expire'];
        $accessToken = $this->generateToken($userData, $this->jwtConfig['expire'], $clientIp);
        $refreshToken = $this->generateToken($userData, $this->jwtConfig['refresh_expire'], $clientIp);

        // 更新当前用户token信息
        $this->modifyUser([
            'id' => $userData['id'],
            'access_token' => md5($accessToken),
            'access_expires' => $accessExpires,
            'refresh_token' => md5($refreshToken),
            'refresh_expires' => $refreshExpires,
        ]);

        return [
            'access_token' => $accessToken,
            'access_token_expires' => $accessExpires,
            'refresh_token' => $refreshToken,
            'refresh_token_expires' => $refreshExpires,
        ];
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

        // 生成token
        $token = $this->generateLoginTokenByUserData($userData, $clientIp);
        return [
            'user_data' => $userData,
            'token' => $token
        ];
    }

    /**
     * 属性token
     * @param string $refreshToken
     * @param string $clientIp
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function refreshToken(string $refreshToken, string $clientIp): array
    {
        // 验证 token 有效性
        $this->verifyToken($refreshToken, 'refresh_token', $clientIp);

        // 获取用户信息
        $userData = UserModel::field('id,login_name,name,sex,phone,email')
            ->where('refresh_token', '=', md5($refreshToken))
            ->find();

        // 生成token
        $token = $this->generateLoginTokenByUserData($userData, $clientIp);
        return [
            'user_data' => $userData,
            'token' => $token
        ];
    }
}