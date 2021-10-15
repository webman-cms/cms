<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class CreatePostTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('post', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '文章表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('title', 'string', ['default' => '', 'limit' => 128, 'comment' => '文章标题'])
            ->addColumn('content', 'text', ['null' => true, 'limit' => MysqlAdapter::TEXT_LONG, 'comment' => '文章正文内容'])
            ->addColumn('thumb_media_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '缩略图所属媒体ID'])
            ->addColumn('user_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属作者ID'])
            ->addColumn('nav_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '所属菜单ID'])
            ->addColumn('create_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '创建时间'])
            ->addColumn('update_time', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '更新时间']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('post')->drop()->save();
    }
}
