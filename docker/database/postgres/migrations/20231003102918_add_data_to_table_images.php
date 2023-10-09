<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddDataToTableImages extends AbstractMigration
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
        $sql =
            /** @lang text */
            "
            INSERT INTO images VALUES
                (27, 'moto.png', 50),
                (32, 'moto.png', 50),
                (33, 'wheels.png', 50),
                (34, 'boat.png', 52),
                (35, 'icons8.png', 53),
                (37, 'wheels.png', 50),
                (38, 'moto.png', 51),
                (39, 'boat.png', 15),
                (40, 'wheels.png', 3),
                (41, 'wheels.png', 3),
                (42, 'wheels.png', 3),
                (43, 'wheels.png', 3),
                (48, 'icons8-frontend-development-96.png', 1),
                (51, 'moto.png', 2),
                (57, 'handlebar.png', 54),
                (58, 'steam.png', 54),
                (61, 'moto.png', 1),
                (62, 'wheels.png', 1),
                (63, 'wheels.png', 1),
                (64, 'helmet.png', 11),
                (65, 'symfony.png', 1),
                (66, 'new image', 55),
                (67, 'changed image', 55),
                (68, 'default.jpeg', 56),
                (69, 'test', 57),
                (70, 'test', 58),
                (71, 'test', 59),
                (72, 'test', 60),
                (73, 'update', 60),
                (74, 'update', 59),
                (75, 'update', 58),
                (76, 'insert.png', 53);
            ";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = "TRUNCATE TABLE images;";
        $this->execute($sql);
    }
}
