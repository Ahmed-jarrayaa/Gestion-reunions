<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/bootstrap.php';

use Cake\ORM\TableRegistry;

$Notifications = TableRegistry::getTableLocator()->get('Notifications');
$Utilisateurs = TableRegistry::getTableLocator()->get('Utilisateurs');

$now = new \DateTimeImmutable();

$notifications = $Notifications->find()
    ->where([
        'send_at <=' => $now->format('Y-m-d H:i:s'),
        'lu' => 0,
        'supprime' => 0
    ])
    ->all();

foreach ($notifications as $notif) {
    $user = $Utilisateurs->get($notif->utilisateur_id);
    echo "🔔 Notification pour {$user->nom} : {$notif->message}\n";

    $notif->lu = 1;
    $Notifications->save($notif);
}
