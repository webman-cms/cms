<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class CreateCarouselTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('carousel', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '轮播图表']);

        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '主键ID'])
            ->addColumn('index', 'integer', ['signed' => false, 'default' => 0, 'limit' => MysqlAdapter::INT_MEDIUM, 'comment' => '排序索引'])
            ->addColumn('thumb_media_id', 'integer', ['signed' => false, 'default' => 0, 'limit' => 11, 'comment' => '缩略图所属媒体ID'])
            ->addColumn('href', 'string', ['default' => '', 'limit' => 255, 'comment' => '跳转链接地址']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('carousel')->drop()->save();
    }
}
