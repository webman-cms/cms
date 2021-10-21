<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillSystemOptions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $rows = [
            [
                'name' => '媒体服务器',
                'code' => 'media_service',
                'type' => 'system',
                'config' => json_encode([
                    'end_point' => '127.0.0.1', // 端点，上传url地址
                    'port' => 9000, // 端口
                    'use_ssl' => false, // bool 是否是 https
                    'access_key' => 'xxx', // 授权码
                    'secret_key' => 'xxx', // 密钥
                    'bucket' => 'cms', // 存储桶
                ])
            ],
            [
                'name' => '备案号',
                'code' => 'beian_number',
                'type' => 'system',
                'config' => json_encode([
                    'record' => '京ICP备 88888888号 ', // 备案号
                    'url' => 'https://beian.miit.gov.cn', // 管局指定跳转地址
                ])
            ]
        ];

        $this->table('options')->insert($rows)->save();
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM options');
    }
}
