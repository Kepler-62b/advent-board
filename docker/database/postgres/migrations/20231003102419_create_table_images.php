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
            CREATE TABLE images (
                id              serial PRIMARY KEY,
                name            VARCHAR ( 200 ) NOT NULL,
                item_id         integer REFERENCES adverts (id) NOT NULL,
                created_date    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                modified_date   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            );        
            ";

        $this->execute($sql);
    }

    public function down(): void
    {
        $sql = /** @lang text */
            "
            DROP TABLE public.images;
        ";

        $this->execute($sql);
    }
}
