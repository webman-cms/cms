<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateOptionsTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $table = $this->table('options', ['id' => false, 'primary_key' => ['id'], 'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci']);

        //添加数据字段
        $table->addColumn('id', 'integer', ['identity' => true, 'signed' => false, 'limit' => 11, 'comment' => '配置ID'])
            ->addColumn('name', 'string', ['default' => '', 'limit' => 128, 'comment' => '配置名称'])
            ->addColumn('code', 'string', ['default' => '', 'limit' => 128, 'comment' => '配置编码'])
            ->addColumn('type', 'enum', ['values' => 'system,custom', 'default' => 'custom', 'comment' => '配置类型（系统 system、自定义 custom）'])
            ->addColumn('config', 'json', ['null' => true, 'comment' => '配置设置']);

        //执行创建
        $table->create();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('options')->drop()->save();
    }
}
