<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTableAdverts extends AbstractMigration
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
        CREATE TABLE `adverts` (
            `id` int UNSIGNED NOT NULL,
            `item` varchar(200) NOT NULL,
            `description` varchar(3000) NOT NULL,
            `price` int NOT NULL,
            `image` varchar(50) DEFAULT NULL,
            `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        ALTER TABLE `adverts`
            MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT primary key;
        ";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = /** @lang text */
            "DROP TABLE `adverts`;";
        $this->execute($sql);
    }
}
