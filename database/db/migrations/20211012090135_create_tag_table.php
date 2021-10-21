<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTagTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('tag', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '标签表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'comment' => '标签名称']);

        // 给tag名称增加唯一索引
        $table->addIndex(['name'], ['unique' => true, 'name' => 'idx_name']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('nav_tag')->drop()->save();
    }
}
