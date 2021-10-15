<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class FillDefaultUserData extends AbstractMigration
{
    /**
     * 加密密码
     * @param string $password
     * @return false|string|null
     */
    public function create_pass($password = "")
    {
        if (!empty($password)) {
            $options = [
                'cost' => 8,
            ];
            return password_hash($password, PASSWORD_BCRYPT, $options);
        } else {
            return '';
        }
    }

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    /**
     * Migrate Up.
     */
    public function up()
    {
        $rows = [
            [
                'login_name' => 'admin',
                'name' => '管理员',
                'sex' => 'male',
                'phone' => 18888888888,
                'email' => 'admin@cms.com',
                'password' => $this->create_pass("Cms@Admin"),
                'create_time' => time()
            ]
        ];

        $this->table('user')->insert($rows)->save();
    }


    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM user');
    }
}
