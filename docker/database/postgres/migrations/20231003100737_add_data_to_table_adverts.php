<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDataToTableAdverts extends AbstractMigration
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
        INSERT INTO adverts VALUES
            (1, 'postgres database', 'item desc', 50000, 'symfony.png', '2023-06-23 12:57:05', '2023-06-29 23:57:47'),
            (2, 'item two', 'desc item', 1000, 'moto.png', '2023-06-23 14:45:05', '2023-06-27 17:15:02'),
            (3, 'item 3', 'desc', 111, 'wheels.png', '2023-06-23 15:50:18', '2023-06-27 16:52:22'),
            (4, 'bicycle', 'used bicycle', 10000, 'bike.png', '2023-06-23 23:29:47', '2023-06-23 23:29:47'),
            (5, 'auto', 'used auto', 500000, 'auto.png', '2023-06-23 23:39:12', '2023-06-23 23:39:12'),
            (6, 'house', 'old house', 999999, 'house.png', '2023-06-23 23:39:12', '2023-06-23 23:39:12'),
            (8, 'bike parts', 'userd bike parts', 1000, 'icons8.png', '2023-06-23 23:40:51', '2023-06-23 23:40:51'),
            (9, 'pc', 'used pc', 10000, 'icons8-frontend-development-96(1).png', '2023-06-23 23:40:51', '2023-06-23 23:40:51'),
            (10, 'pc 2', 'old pc 2', 5000, 'icons8-frontend-development-96.png', '2023-06-23 23:40:51', '2023-06-23 23:40:51'),
            (11, 'network', 'network', 300, 'helmet.png', '2023-06-23 23:41:17', '2023-06-27 23:30:39'),
            (12, 'qwe', 'qwe', 123, 'icons8-94.png', '2023-06-23 23:41:17', '2023-06-23 23:41:17'),
            (14, 'network 2', 'network 2', 1500, 'icons8-сеть-96.png', '2023-06-23 23:41:32', '2023-06-23 23:41:32'),
            (15, 'qwer', 'rewq', 123321, 'boat.png', '2023-06-23 23:41:32', '2023-06-27 15:52:11'),
            (16, 'boat', 'old boat', 20000, 'boat.png', '2023-06-23 23:41:32', '2023-06-23 23:41:32'),
            (17, 'wheels', 'userd wheels', 3500, 'wheels.png', '2023-06-26 13:01:40', '2023-06-26 13:01:40'),
            (18, 'moto', 'old moto', 13000, 'moto.png', '2023-06-26 13:34:28', '2023-06-26 13:34:28'),
            (50, 'qq', 'ww', 11, 'wheels.png', '2023-06-27 13:52:32', '2023-06-27 15:48:11'),
            (51, 'qq', 'ww', 11, 'moto.png', '2023-06-27 13:52:47', '2023-06-27 15:49:31'),
            (52, 'qq', 'ww', 123, 'boat.png', '2023-06-27 15:29:49', '2023-06-27 15:29:49'),
            (53, 'rew', 'qwe', 234, 'handlebar.png', '2023-06-27 15:31:16', '2023-06-27 17:58:54'),
            (54, 'handlebar', 'desc', 1122, 'steam.png', '2023-06-27 18:01:57', '2023-06-27 18:06:06'),
            (55, 'changed item', '2000', 2000, 'changed image', '2023-07-17 18:34:35', '2023-07-17 18:41:34'),
            (56, 'test-create', 'test-create', 111, 'default.jpeg', '2023-08-29 11:53:05', '2023-08-29 11:53:05'),
            (57, 'test', 'test', 123, 'test', '2023-08-30 16:20:37', '2023-08-30 16:20:37'),
            (58, 'update', 'update', 321, 'update', '2023-08-30 16:20:43', '2023-08-31 00:48:59'),
            (59, 'update', 'update', 321, 'update', '2023-08-30 16:21:00', '2023-08-31 00:48:30'),
            (60, 'update', 'update', 321, 'update', '2023-08-30 16:28:37', '2023-08-31 00:27:21');
        ";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = "TRUNCATE TABLE adverts;";
        $this->execute($sql);
    }
}
