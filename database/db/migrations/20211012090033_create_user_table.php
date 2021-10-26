<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUserTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('user', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '用户表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('login_name', 'char', ['default' => '', 'limit' => 36, 'comment' => '登录名'])
            ->addColumn('avatar_media_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '用户头像所属媒体ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '用户姓名'])
            ->addColumn('sex', 'enum', ['values' => 'male,female', 'default' => 'male', 'comment' => '性别（男 male、女female）'])
            ->addColumn('phone', 'char', ['default' => '', 'limit' => 20, 'comment' => '手机号码'])
            ->addColumn('email', 'string', ['default' => '', 'limit' => 128, 'comment' => '用户邮箱'])
            ->addColumn('password', 'string', ['default' => '', 'limit' => 128, 'comment' => '密码'])
            ->addColumn('access_token', 'char', ['default' => '', 'limit' => 40, 'comment' => '验证令牌'])
            ->addColumn('access_expires', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '验证令牌过期时间'])
            ->addColumn('refresh_token', 'char', ['default' => '', 'limit' => 40, 'comment' => '刷新令牌'])
            ->addColumn('refresh_expires', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '刷新令牌过期时间'])
            ->addColumn('ip', 'char', ['default' => '', 'limit' => 32, 'comment' => 'IP地址'])
            ->addColumn('last_visit_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '最后访问时间'])
            ->addColumn('create_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间']);

        //添加索引
        $table->addIndex(['login_name'], ['unique' => true, 'name' => 'idx_login_name']);
        $table->addIndex(['phone'], ['unique' => true, 'name' => 'idx_user_phone']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('user')->drop()->save();
    }
}
