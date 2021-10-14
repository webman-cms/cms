<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateNavTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $item = $this->table('nav', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '菜单表']);

        $item->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('name', 'char', ['default' => '', 'limit' => 24, 'comment' => '菜单名称'])
            ->addColumn('alias', 'char', ['default' => '', 'limit' => 24, 'comment' => '菜单别名'])
            ->addColumn('index', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '排序索引'])
            ->addColumn('describe', 'string', ['default' => '', 'limit' => 255, 'comment' => '菜单描述'])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('nav')->drop()->save();
    }
}
