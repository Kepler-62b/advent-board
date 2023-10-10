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
            /** @lang SQL */
            "
            INSERT INTO images (name, item_id) VALUES
                ('moto.png', 24),
                ('moto.png', 2),
                ('wheels.png', 24),
                ('boat.png', 25),
                ('icons8.png', 4),
                ('wheels.png', 21),
                ('moto.png', 22),
                ('boat.png', 15),
                ('wheels.png', 3),
                ('wheels.png', 3),
                ('wheels.png', 3),
                ('wheels.png', 3),
                ('icons8-frontend-development-96.png', 1),
                ('moto.png', 2),
                ('handlebar.png', 16),
                ('steam.png', 16),
                ('moto.png', 1),
                ('wheels.png', 1),
                ('wheels.png', 8),
                ('helmet.png', 11),
                ('symfony.png', 9),
                ('new image', 13),
                ('changed image', 26),
                ('default.jpeg', 18),
                ('test', 26),
                ('test', 6),
                ('test', 9),
                ('test', 19),
                ('update', 25),
                ('update', 10),
                ('update', 27),
                ('insert.png', 11);
            ";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = "TRUNCATE TABLE images;";
        $this->execute($sql);
    }
}
