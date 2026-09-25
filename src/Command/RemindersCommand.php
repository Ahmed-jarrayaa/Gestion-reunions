<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Mailer;

class RemindersCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $reunionsTable = $this->fetchTable('Reunions');
        $aujourdHui = new \DateTimeImmutable();
        $dans10Jours = $aujourdHui->modify('+10 days');

        $reunions = $reunionsTable->find()
            ->contain('Participants.Utilisateurs')
            ->where([
                'Reunions.date_heure >=' => $aujourdHui,
                'Reunions.date_heure <=' => $dans10Jours,
                'Reunions.statut' => 'valider',
            ])
            ->all();

        $envoyes = 0;
        foreach ($reunions as $reunion) {
            foreach ($reunion->participants as $p) {
                $email = $p->utilisateur->email ?? null;
                $nom = $p->utilisateur->nom ?? 'participant';
                if (!$email) {
                    continue;
                }
                $mailer = new Mailer('default');
                $mailer->setTo($email)
                    ->setSubject("Rappel : réunion à venir")
                    ->deliver(
                        "Bonjour {$nom},\n" .
                        "La réunion '{$reunion->titre}' est prévue le " .
                        $reunion->date_heure->format('d/m/Y H:i') . ".\n" .
                        "Lieu : {$reunion->lieu}\nMerci."
                    );
                $envoyes++;
            }
        }

        $io->out("Rappels envoyés pour {$envoyes} participant(s) aux réunions dans les 10 prochains jours.");
    }
}