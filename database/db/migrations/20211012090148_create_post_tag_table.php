<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreatePostTagTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('post_tag', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '文章标签表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('post_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属文章ID'])
            ->addColumn('tag_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属标签ID']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('post_tag')->drop()->save();
    }
}
