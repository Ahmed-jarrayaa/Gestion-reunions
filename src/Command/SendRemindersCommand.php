<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Mailer;

class SendRemindersCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $notificationsTable = $this->fetchTable('Notifications');
        $now = new \DateTimeImmutable();

        $notifications = $notificationsTable->find()
            ->contain(['Utilisateurs'])
            ->where([
                'send_at <=' => $now,
                'Notifications.lu' => false,
                'Notifications.supprime' => false,
                'Utilisateurs.email IS NOT' => null,
            ])
            ->all();

        $sent = 0;
        $errors = 0;

        foreach ($notifications as $notification) {
            if (empty($notification->utilisateur) || empty($notification->utilisateur->email)) {
                continue;
            }

            try {
                $mailer = new Mailer('default');
                $mailer->setTo($notification->utilisateur->email)
                    ->setSubject('Notification MeetFlow')
                    ->deliver((string)$notification->message);

                $notification->lu = true;
                $notificationsTable->save($notification);
                $sent++;
            } catch (\Throwable $e) {
                $errors++;
                $io->error("Échec d'envoi vers {$notification->utilisateur->email} : " . $e->getMessage());
            }
        }

        $io->out("Notifications envoyées : {$sent}, en erreur : {$errors}.");
    }
}