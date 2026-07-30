namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Mailer\Mailer;

class ReminderCommand extends Command
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
                'Reunions.date_heure <=' => $dans10Jours
            ])
            ->all();

        foreach ($reunions as $reunion) {
            foreach ($reunion->participants as $p) {
                // envoyer un email (ou autre canal)
                $mailer = new Mailer('default');
                $mailer->setTo($p->utilisateur->email)
                    ->setSubject("Rappel : réunion à venir")
                    ->deliver("La réunion '{$reunion->titre}' est prévue le " 
                              . $reunion->date_heure->format('d/m/Y H:i'));
            }
        }

        $io->out("Notifications envoyées pour les réunions dans 10 jours.");
    }
}
