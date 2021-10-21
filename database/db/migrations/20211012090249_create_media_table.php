<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateMediaTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('media', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '媒体ID'])
            ->addColumn('type', 'enum', ['values' => 'image,video,audio,file', 'default' => 'image', 'comment' => '媒体资源类型'])
            ->addColumn('path', 'string', ['default' => '', 'limit' => 255, 'comment' => '存储路径'])
            ->addColumn('size', 'char', ['default' => '0', 'limit' => 32, 'comment' => '图片大小'])
            ->addColumn('description', 'text', ['null' => true, 'comment' => '描述'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建者'])
            ->addColumn('create_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('media')->drop()->save();
    }
}
