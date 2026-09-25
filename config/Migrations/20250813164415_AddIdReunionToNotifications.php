<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddIdReunionToNotifications extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('notifications', ['id' => false, 'primary_key' => ['id']]);
        $table
            ->addColumn('id', 'biginteger', [
                'autoIncrement' => true,
                'signed' => false,
            ])
            ->addColumn('utilisateur_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('message', 'text', [
                'default' => null,
                'null' => true,
            ])
            ->addColumn('id_reunion', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('lu', 'boolean', [
                'default' => 0,
                'null' => false,
            ])
            ->addColumn('supprime', 'boolean', [
                'default' => 0,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addIndex(['utilisateur_id'])
            ->addIndex(['id_reunion'])
            ->create();
    }
}