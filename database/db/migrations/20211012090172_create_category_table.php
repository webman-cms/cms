<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoryTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('category', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '分类表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('name', 'char', ['default' => '', 'limit' => 24, 'comment' => '分类名称'])
            ->addColumn('code', 'char', ['default' => '', 'limit' => 24, 'comment' => '分类编码'])
            ->addColumn('parent_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '父级id']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('category')->drop()->save();
    }
}
