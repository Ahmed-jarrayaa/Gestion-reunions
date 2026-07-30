<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Command\Command;
use Cake\Console\ConsoleIo;

class SendRemindersCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $Notifications = $this->getTableLocator()->get('Notifications');
        $Utilisateurs = $this->getTableLocator()->get('Utilisateurs');

        $now = new \DateTimeImmutable();

        $notifications = $Notifications->find()
            ->where([
                'send_at <=' => $now->format('Y-m-d H:i:s'),
                'lu' => 0,
                'supprime' => 0
            ])
            ->all();

        if ($notifications->isEmpty()) {
            $io->out('Aucune notification à envoyer.');
            return;
        }

        foreach ($notifications as $notif) {
            $user = $Utilisateurs->get($notif->utilisateur_id);

            // Affichage console (ou ici tu peux envoyer un email)
            $io->out("🔔 Notification pour {$user->nom} : {$notif->message}");

            // Marquer comme envoyée
            $notif->lu = 1;
            $Notifications->save($notif);
        }

        $io->success("✅ Notifications envoyées : " . count($notifications));
    }
}
