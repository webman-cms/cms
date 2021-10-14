<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateNavTagTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $item = $this->table('nav_tag', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '标签表']);

        $item->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('nav_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属菜单ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 255, 'comment' => '标签名称'])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('nav_tag')->drop()->save();
    }
}
