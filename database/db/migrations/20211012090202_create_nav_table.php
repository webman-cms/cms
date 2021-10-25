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
        $table = $this->table('nav', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '菜单表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('name', 'char', ['default' => '', 'limit' => 24, 'comment' => '菜单名称'])
            ->addColumn('type', 'enum', ['values' => 'post,page,link,category', 'default' => 'post', 'comment' => '菜单类型，post 文章，page 页面，link 链接，分类'])
            ->addColumn('url', 'string', ['default' => '', 'limit' => 255, 'comment' => '菜单为link链接时候有值'])
            ->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级id'])
            ->addColumn('link_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '关联id'])
            ->addColumn('index', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '排序索引']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('nav')->drop()->save();
    }
}
