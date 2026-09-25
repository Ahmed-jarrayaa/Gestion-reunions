<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddSendAtToNotifications extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('notifications');
        if ($table->exists()) {
            $columns = $this->getAdapter()->getColumns('notifications');
            $hasSendAt = false;
            foreach ($columns as $column) {
                if ($column->getName() === 'send_at') {
                    $hasSendAt = true;
                    break;
                }
            }
            if (!$hasSendAt) {
                $table->addColumn('send_at', 'datetime', ['null' => true])->update();
            }
        }
    }
}