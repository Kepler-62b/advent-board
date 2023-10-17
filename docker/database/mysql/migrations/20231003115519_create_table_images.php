<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableImages extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $sql = /** @lang text */
            "
        CREATE TABLE `images` (
            `id` int UNSIGNED NOT NULL,
            `name` varchar(55) NOT NULL,
            `item_id` int UNSIGNED NOT NULL COMMENT 'foreign key for advents table(id column)'
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

          ALTER TABLE `images`
          MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT primary key;
          ";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = /** @lang text */
            "DROP TABLE images;";
        $this->execute($sql);
    }
}
