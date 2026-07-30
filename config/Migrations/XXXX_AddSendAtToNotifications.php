<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddSendAtToNotifications extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('notifications');
        $table->addColumn('send_at', 'datetime', ['null' => true])
              ->update();
    }
}
