<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Log\Log;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
class ReunionsController extends AppController
{
    /**
     * @var \App\Model\Table\NotificationsTable
     */
    public $Notifications;

    /**
     * @var \App\Model\Table\ParticipantsTable
     */
    public $Participants;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
        
        
    }

public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);

    $user = $this->Authentication->getIdentity();

    // Autoriser certaines actions sans connexion
    $this->Authentication->allowUnauthenticated(['login', 'register']);

    if (!$user) {
        return;
    }

    // Si admin → accès complet
    if ($user->role === 'admin') {
        return;
    }

    // Si membre → restrictions
    if ($user->role === 'membre') {

        $action = $this->request->getParam('action');

        // Actions autorisées sans vérification
        $allowedActions = ['index', 'view', 'add', 'mesReunions', 'mesParticipants','addMultiple','select','calendrier','events','markNotificationsRead','notificationsProches','notifyParticipantsAnnulation'];
        if (in_array($action, $allowedActions)) {
            return;
        }

        // Actions qui nécessitent vérification
        if (in_array($action, ['view', 'edit', 'delete'])) {

            $id = $this->request->getParam('pass')[0] ?? null;
            if (!$id) {
                $this->Flash->error("Réunion non spécifiée.");
                return $this->redirect(['action' => 'index']);
            }

            // Charger la réunion avec ses participants
            $reunion = $this->Reunions->get($id, [
                'contain' => ['Participants']
            ]);

            $estCreateur = ($reunion->cree_par == $user->id);
            $estParticipant = false;

            foreach ($reunion->participants as $participant) {
                if ($participant->id_utilisateur == $user->id) {
                    $estParticipant = true;
                    break;
                }
            }

            // Règles :
            // - view : créateur ou participant
            // - edit : seulement créateur
            // - delete : seulement créateur
            if ($action === 'view' && ($estCreateur || $estParticipant)) {
                return;
            }

            if (in_array($action, ['edit', 'delete']) && $estCreateur) {
                return;
            }

            // Si aucune condition remplie → accès refusé
            $this->Flash->error("Vous n'avez pas accès à cette réunion.");
            return $this->redirect(['action' => 'index']);
        }

        // Sinon, refus d'accès
        $this->Flash->error("Vous n'avez pas accès à cette page.");
        return $this->redirect(['action' => 'index']);
    }
}



public function select()
{
    $user = $this->Authentication->getIdentity();

    // Liste des réunions que l'utilisateur a créées (ou auxquelles il participe selon ta logique)
    $reunions = $this->Reunions->find('all', [
        'conditions' => ['cree_par' => $user->id],
        'order' => ['date_heure' => 'ASC']
    ])->toArray();

    $this->set(compact('reunions'));
}



public function edit($id = null)
{
    $reunion = $this->Reunions->get($id, [
        'contain' => ['Participants']
    ]);

    $user = $this->request->getAttribute('identity');

    // Vérification d'accès
    if ($user->role !== 'admin' && $reunion->cree_par !== $user->id) {
        $this->Flash->error("Vous n'avez pas le droit de modifier .");
        return $this->redirect(['action' => 'index']);
    }

    // Vérification supplémentaire : si le créateur, ne peut éditer que si statut = en_attente
    if ($reunion->cree_par === $user->id && $reunion->statut !== 'en_attente' && $user->role !== 'admin') {
        $this->Flash->error("Vous ne pouvez éditer cette réunion que si elle est en attente.");
        return $this->redirect(['action' => 'index']);
    }

    if ($this->request->is(['post', 'put', 'patch'])) {
        $data = $this->request->getData();

        // 🔹 Si l'utilisateur n'est pas admin, on supprime le champ 'statut' pour qu'il ne soit pas modifiable
        if ($user->role !== 'admin' && isset($data['statut'])) {
            unset($data['statut']);
        }

        $dateChanged = isset($data['date_heure']) && $data['date_heure'] != $reunion->date_heure->format('Y-m-d H:i:s');

        $reunion = $this->Reunions->patchEntity($reunion, $data);

        if ($this->Reunions->save($reunion)) {
            $this->Flash->success("Réunion modifiée avec succès.");

            // Envoyer notification si la date a changé
            if ($dateChanged) {
                $notifications = [];
                foreach ($reunion->participants as $participant) {
                    if ($participant->id_utilisateur) {
                        $notifications[] = [
                            'message' => "La réunion '{$reunion->titre}' a été déplacée. Nouvelle date/heure : " . $reunion->date_heure->format('d/m/Y H:i'),
                            'send_at' => $reunion->date_heure->format('Y-m-d H:i:s'),
                            'id_reunion' => $reunion->id   
                        ];
                    }
                }
                // Stocker en session pour le frontend
                $this->request->getSession()->write('notifications.annulation', $notifications);
            }

            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error("Impossible de modifier la réunion.");
        }
    }

    $this->set(compact('reunion'));
}


public function view($id = null)
{
    $user = $this->Authentication->getIdentity();

    if (!$user) {
        $this->Flash->error(__('Vous devez être connecté.'));
        return $this->redirect(['action' => 'index']);
    }

    $Reunions = $this->Reunions;

    if ($user->role === 'admin') {
        // Admin a accès à toutes les réunions
        $reunion = $Reunions->get($id, [
            'contain' => ['Participants']
        ]);
    } else {
        // Membre → ne peut voir que ses réunions (créateur ou participant)
        $reunion = $Reunions->find()
            ->where(['Reunions.id' => $id])
            ->contain(['Participants'])
            ->matching('Participants', function ($q) use ($user) {
                return $q->where(['Participants.id_utilisateur' => $user->id]);
            })
            ->first();

        // Vérifier si c’est le créateur également
        if (!$reunion) {
            // Vérifie si c’est le créateur
            $reunion = $Reunions->find()
                ->where(['Reunions.id' => $id, 'Reunions.cree_par' => $user->id])
                ->contain(['Participants'])
                ->first();
        }

        if (!$reunion) {
            $this->Flash->error(__('Vous n\'avez pas accès à cette réunion.'));
            return $this->redirect(['action' => 'index']);
        }
    }

    $this->set(compact('reunion'));
}








public function index()
{
    $user = $this->Authentication->getIdentity();

    // Récupérer le terme de recherche
    $search = $this->request->getQuery('search');

    if (!$user) {
        // utilisateur non connecté, aucun résultat
        $reunions = $this->paginate($this->Reunions->find()->where(['1 = 0']));
    } elseif ($user->role === 'admin') {
        // Admin voit toutes les réunions
        $query = $this->Reunions->find();

        // 🔎 Filtre recherche
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Reunions.titre LIKE' => '%' . $search . '%',
                    'Reunions.id' => (is_numeric($search) ? (int)$search : null)
                ]
            ]);
        }

        $reunions = $this->paginate($query);
    } elseif ($user->role === 'membre') {
        // Récupérer les IDs des réunions où l'utilisateur est participant
        $participantReunionIds = $this->Reunions->Participants->find()
            ->select(['id_reunion'])
            ->where(['id_utilisateur' => $user->id])
            ->all()
            ->extract('id_reunion')
            ->toList();

        // Filtrer les réunions pour membre (créateur ou participant)
        $query = $this->Reunions->find()
            ->contain(['Participants' => function ($q) use ($user) {
                return $q->where(['id_utilisateur' => $user->id]);
            }])
            ->where([
                'OR' => [
                    'Reunions.cree_par' => $user->id,
                    'Reunions.id IN' => $participantReunionIds
                ]
            ])
            ->distinct(['Reunions.id']);

        // 🔎 Filtre recherche
        if (!empty($search)) {
            $query->where([
                'OR' => [
                    'Reunions.titre LIKE' => '%' . $search . '%',
                    'Reunions.id' => (is_numeric($search) ? (int)$search : null)
                ]
            ]);
        }

        $reunions = $this->paginate($query);
    } else {
        $reunions = $this->paginate($this->Reunions->find()->where(['1 = 0']));
    }

    $this->set(compact('reunions', 'search'));
}


// If you want to send notifications with delays, move this logic inside a controller method (e.g., after creating a reunion in add())


// src/Controller/ReunionsController.php
public function add()
{
    $user = $this->Authentication->getIdentity();
    if (!$user) {
        $this->Flash->error('Vous devez être connecté pour créer une réunion.');
        return $this->redirect(['action' => 'index']);
    }

    $reunion = $this->Reunions->newEmptyEntity();

    if ($this->request->is('post')) {
        $data = $this->request->getData();
        $data['cree_par'] = $user->id;
        $data['statut'] = 'en_attente';

        $reunion = $this->Reunions->patchEntity($reunion, $data);

        if ($this->Reunions->save($reunion)) {

            // 🔹 Ajouter le créateur comme participant
            $Participants = $this->getTableLocator()->get('Participants');
            $creator = $Participants->newEmptyEntity();
            $creator->id_reunion = $reunion->id;
            $creator->id_utilisateur = $user->id;
            $creator->presence = 0;
            $Participants->save($creator);

            // 🔹 Ajouter les participants sélectionnés
            $participants = $this->request->getData('participants_ids') ?? [];
            foreach ($participants as $pid) {
                // éviter de dupliquer le créateur
                if ($pid != $user->id) {
                    $participant = $Participants->newEmptyEntity();
                    $participant->id_reunion = $reunion->id;
                    $participant->id_utilisateur = $pid;
                    $participant->presence = 0;
                    $Participants->save($participant);
                }
            }

            $this->Flash->success('Réunion proposée avec participants. En attente de validation par l’admin.');
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error('Erreur lors de la création de la réunion.');
    }

    // Charger types et utilisateurs
    $types = $this->Reunions->TypesReunions->find('list', [
        'keyField' => 'id',
        'valueField' => 'nom_type'
    ])->toArray();

    $utilisateurs = $this->getTableLocator()
        ->get('Utilisateurs')
        ->find('list', [
            'keyField' => 'id',
            'valueField' => 'email'
        ])
        ->toArray();

    $selectedParticipants = !empty($reunion->participants_attente) 
        ? json_decode($reunion->participants_attente, true) 
        : [];

    $this->set(compact('reunion', 'types', 'utilisateurs', 'selectedParticipants'));
}




public function mesParticipants()
{
    $userId = $this->request->getAttribute('identity')->id;

    // On récupère uniquement les réunions créées par l'utilisateur
    $reunions = $this->Reunions->find()
        ->where(['cree_par' => $userId])
        ->contain(['Participants' => ['Utilisateurs']]); // Jointure avec utilisateurs

    $this->set(compact('reunions'));
}






public function mesReunions()
{
    $user = $this->request->getAttribute('identity');
    if (!$user) {
        $this->Flash->error("Vous devez être connecté pour voir vos réunions.");
        return $this->redirect(['action' => 'index']);
    }

    if ($user->role === 'admin') {
        // L'admin voit toutes les réunions
        $reunions = $this->Reunions->find()
            ->order(['date_heure' => 'DESC'])
            ->all();
    } else {
        // Les membres voient seulement leurs propres réunions
        $reunions = $this->Reunions->find()
            ->where(['cree_par' => $user->id])
            ->order(['date_heure' => 'DESC'])
            ->all();
    }

    $this->set(compact('reunions'));
}



public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);

    $reunion = $this->Reunions->get($id, [
        'contain' => ['Participants' => ['Utilisateurs']]
    ]);

    $user = $this->request->getAttribute('identity');
    $reunion = $this->Reunions->get($id, ['contain' => ['Participants']]);


    // Vérification d'accès : admin ou créateur
    if ($user->role !== 'admin') {
        $this->Flash->error("Vous n'avez pas le droit de supprimer cette réunion.");
        return $this->redirect(['action' => 'index']);
    }

    // Préparer les notifications avant suppression
    $notifications = $this->notifyParticipantsAnnulation(
        $reunion->id,
        $reunion->titre,
        $reunion->date_heure->format('d/m/Y H:i')
    );
    
    $annulationNotifications = [];
foreach ($reunion->participants as $participant) {
    if ($participant->id_utilisateur) {
        
        $annulationNotifications[] = [
            'message' => "La réunion '{$reunion->titre}' a été annulée (prévue le ".$reunion->date_heure->format('d/m/Y H:i').")",
            'send_at' => date('Y-m-d H:i:s'),
            'id_reunion' => $reunion->id,        // 0 pour réunion annulée
            'annulee' => true         // flag pour JS
        ];
    }
}


$this->request->getSession()->write('notifications.annulation', $annulationNotifications);


    // Supprimer la réunion
    if ($this->Reunions->delete($reunion)) {
        $this->Flash->success("La réunion a été supprimée.");

        // Stocker les notifications d'annulation pour le front
        $this->request->getSession()->write('notifications.annulation', $notifications);
    } else {
        $this->Flash->error("Impossible de supprimer la réunion.");
    }

    return $this->redirect(['action' => 'index']);
}


public function ajouterParticipants($idReunion)
{
    $reunion = $this->Reunions->get($idReunion, [
        'contain' => ['Participants']
    ]);

    if ($this->request->is('post')) {
        $idsUtilisateurs = $this->request->getData('participants');

        foreach ($idsUtilisateurs as $idUser) {
            if (!empty($idUser)) {
                $participant = $this->Reunions->Participants->newEntity([
                    'id_reunion' => $idReunion,
                    'id_utilisateur' => $idUser
                ]);
                $this->Reunions->Participants->save($participant);
            }
        }

        $this->Flash->success(__('Participants ajoutés avec succès.'));
        return $this->redirect(['action' => 'view', $idReunion]);
    }

    // Récupérer tous les utilisateurs pour la liste
    $utilisateurs = $this->Reunions->Participants->Utilisateurs->find('list', [
        'keyField' => 'id',
        'valueField' => 'nom'
    ])->toArray();

    $this->set(compact('reunion', 'utilisateurs'));
}

public function addMultiple($reunionId = null)
{
    $user = $this->Authentication->getIdentity();

    if (!$reunionId) {
        $this->Flash->error('Réunion non spécifiée.');
        return $this->redirect(['action' => 'select']);
    }

    // Récupérer la réunion
    $reunion = $this->Reunions->get($reunionId);
    $this->set(compact('reunion'));

    if ($user->role !== 'admin' && $reunion->cree_par !== $user->id) {
        $this->Flash->error('Vous n\'avez pas l\'autorisation d\'ajouter des participants.');
        return $this->redirect(['action' => 'index']);
    }

    // Liste de tous les utilisateurs
    $utilisateurs = $this->Reunions->Utilisateurs->find('list', [
        'keyField' => 'id',
        'valueField' => 'email',
        'order' => ['email' => 'ASC']
    ])->toArray();
    $this->set(compact('utilisateurs'));

    if ($this->request->is('post')) {
        $data = $this->request->getData();

        if (!empty($data['utilisateurs'])) {
            $participantsEntities = [];
            foreach ($data['utilisateurs'] as $userId) {
                // Créer le participant
                $participant = $this->Reunions->Participants->newEmptyEntity();
                $participant->id_reunion = $reunionId;
                $participant->id_utilisateur = $userId;
                $participant->presence = 0;
                $participantsEntities[] = $participant;
            }

            // Sauvegarder tous les participants
            if ($this->Reunions->Participants->saveMany($participantsEntities)) {
                $this->Flash->success('Participants ajoutés avec succès.');
                return $this->redirect(['action' => 'view', $reunionId]);
            } else {
                $this->Flash->error('Erreur lors de l\'ajout des participants.');
            }
        } else {
            $this->Flash->error('Veuillez sélectionner au moins un participant.');
        }
    }
}
public function checkUpcomingMeetings()
{
    $user = $this->Authentication->getIdentity();

    if (!$user) {
        return;
    }

    $aujourdHui = new \DateTimeImmutable();
    $dans10Jours = $aujourdHui->modify('+10 days');

    // Chercher les réunions où l’utilisateur est participant
    $reunions = $this->Reunions->find()
        ->matching('Participants', function ($q) use ($user) {
            return $q->where(['Participants.id_utilisateur' => $user->id]);
        })
        ->where([
            'Reunions.date_heure >=' => $aujourdHui,
            'Reunions.date_heure <=' => $dans10Jours
        ])
        ->all();

    foreach ($reunions as $reunion) {
        $this->Flash->info("⏰ Rappel : la réunion '{$reunion->titre}' est prévue le " 
            . $reunion->date_heure->format('d/m/Y H:i'));
    }
}


// src/Controller/ReunionsController.php
public function getNotificationsGlobal()
{
    $this->request->allowMethod(['get']);

    $today = new \DateTimeImmutable('today');
    $limit = $today->modify('+10 days'); // toutes les réunions dans 10 jours maximum

    // Récupérer tous les participants avec leurs réunions
    $participants = $this->Reunions->Participants->find()
        ->contain(['Reunions', 'Utilisateurs'])
        ->all();

    $notifications = [];

    foreach ($participants as $p) {
        $reunionDate = $p->reunion->date_heure instanceof \DateTimeInterface
            ? $p->reunion->date_heure
            : new \DateTimeImmutable($p->reunion->date_heure);
$diff = $today->diff($reunionDate);
        $diffDays = (int)$diff->format('%r%a'); 

       if ($diffDays >= 0 && $diffDays <= 10) {
    $notifications[$p->id_utilisateur][] = [
        'message' => "⏰ Réunion '{$p->reunion->titre}' prévue dans {$diffDays} jours",
        'id_reunion' => $p->reunion->id,
        'send_at' => $reunionDate->format('d/m/Y H:i')
    ];
}

    }

    // Retourne JSON par utilisateur
    $this->response = $this->response->withType('application/json')
        ->withStringBody(json_encode($notifications));

    return $this->response;
}
// src/Controller/ReunionsController.php

// src/Controller/ReunionsController.php
public function notificationsProches()
{
    $this->request->allowMethod(['get']); // Autoriser GET
    $this->autoRender = false; // Pas de vue

    $user = $this->Authentication->getIdentity();
    $notifications = [];

    if ($user) {
        $participantsTable = $this->getTableLocator()->get('Participants');
        $conn = $participantsTable->getConnection();

        // Requête SQL : réunions dans moins de 10 jours pour cet utilisateur
        $sql = "
            SELECT r.titre,p.id_reunion, r.date_heure, p.id_utilisateur
            FROM participants p
            JOIN reunions r ON p.id_reunion = r.id
            WHERE p.id_utilisateur = :userId
              AND p.id_utilisateur IS NOT NULL
              AND r.date_heure BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 10 DAY) AND r.statut='valider'
            ORDER BY r.date_heure ASC
        ";

        $results = $conn->execute($sql, ['userId' => $user->id])->fetchAll('assoc');

        foreach ($results as $r) {
            $notifications[] = [
                'message' => "Réunion '{$r['titre']}' dans moins de 10 jours (le ".$r['date_heure'].")",
                'send_at' => date('Y-m-d H:i:s'),
                'id_reunion' => $r['id_reunion'] // Ajouter l'ID de la réunion pour le lien

            ];
        }
    }
  $sessionNotifs = $this->request->getSession()->read('notifications') ?? [];
        $notifications = array_merge($notifications, $sessionNotifs);

    // Retour JSON
    $this->response = $this->response
                           ->withType('application/json')
                           ->withStringBody(json_encode([
                               'count' => count($notifications),
                               'items' => $notifications
                           ]));
    return $this->response;
}

public function markAllRead()
{
    $this->request->allowMethod(['post']); // Autoriser seulement POST
    $this->autoRender = false;

    $user = $this->Authentication->getIdentity();
    if ($user) {
        $participantsTable = $this->getTableLocator()->get('Participants');
        $conn = $participantsTable->getConnection();

        // Mettre à jour une colonne "lu" si tu l'as dans tes notifications
        // Ici on crée des notifications "virtuelles", donc tu peux stocker
        // un tableau en session pour savoir si l'utilisateur a vu les notifications

        $this->getRequest()->getSession()->write('notificationsRead', true);

        $response = ['success' => true];
        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
        return $this->response;
    }

    throw new \Cake\Http\Exception\ForbiddenException('Utilisateur non connecté.');
}
public function notifyParticipantsAnnulation($reunionId, $titre, $date)
{
    $participantsTable = $this->getTableLocator()->get('Participants');
    $conn = $participantsTable->getConnection();

    // Récupérer tous les participants
    $sql = "
        SELECT p.id_utilisateur
        FROM participants p
        WHERE p.id_reunion = :reunionId
          AND p.id_utilisateur IS NOT NULL
    ";

    $results = $conn->execute($sql, ['reunionId' => $reunionId])->fetchAll('assoc');

    $notifications = [];
    foreach ($results as $r) {
        $notifications[] = [
            'message' => "La réunion '{$titre}' prévue le {$date} a été annulée.",
            'send_at' => date('Y-m-d H:i:s')
        ];
    }

    // Retour JSON ou insertion dans une table si tu veux persisté
    return $notifications;
}







public function calendrier()
{
    // Affiche juste la vue calendrier.php
}

public function events()
{
    $this->request->allowMethod(['get']);
    $this->autoRender = false;

    $reunions = $this->Reunions
        ->find()
        ->select(['id', 'titre', 'date_heure', 'id_type'])
        ->orderAsc('date_heure')
        ->all();

    $events = [];
    foreach ($reunions as $r) {
        $events[] = [
            'id'    => (string)$r->id,
            'title' => $r->titre,
            'start' => $r->date_heure ? $r->date_heure->format('c') : null,
            'color' => '#' . substr(md5((string)$r->id_type), 0, 6) // couleur basée sur le type
        ];
        
        

    }

    $this->response = $this->response
        ->withType('application/json')
        ->withStringBody(json_encode($events));

    return $this->response;
}
public function valider($id, $action)
{
    $user = $this->Authentication->getIdentity();
    if (!$user || $user->role !== 'admin') {
        $this->Flash->error('Accès refusé');
        return $this->redirect(['action' => 'index']);
    }

    $reunion = $this->Reunions->get($id);

    $participantsTable = $this->getTableLocator()->get('Participants');

    if ($action === 'accepter') {
        $reunion->statut = 'valider';
        $session = $this->request->getSession();

$session->write('notifications.accept', [[
    'message' => "La réunion '{$reunion->titre}' a été acceptée (prévue le " . $reunion->date_heure->format('d/m/Y H:i') . ")",
    'send_at' => date('Y-m-d H:i:s'),
    'id_reunion' => $reunion->id,
    'annulee' => false
]]);
        if ($this->Reunions->save($reunion)) {

            // ✅ Ajouter le créateur
            $existe = $participantsTable->find()
                ->where(['id_reunion' => $reunion->id, 'id_utilisateur' => $reunion->cree_par])
                ->first();

            if (!$existe) {
                $participant = $participantsTable->newEntity([
                    'id_reunion' => $reunion->id,
                    'id_utilisateur' => $reunion->cree_par,
                    'presence' => 0
                ]);
                $participantsTable->save($participant);
            }

            // ✅ Ajouter les autres participants (stockés en attente)
            if (!empty($reunion->participants_attente)) {
                $ids = json_decode($reunion->participants_attente, true);
                foreach ($ids as $idUser) {
                    $existe = $participantsTable->find()
                        ->where(['id_reunion' => $reunion->id, 'id_utilisateur' => $idUser])
                        ->first();

                    if (!$existe) {
                        $participant = $participantsTable->newEntity([
                            'id_reunion' => $reunion->id,
                            'id_utilisateur' => $idUser,
                            'presence' => 0
                        ]);
                        $participantsTable->save($participant);
                    }
                }
            }

            $this->Flash->success('Réunion acceptée et participants ajoutés.');
        } else {
            $this->Flash->error('Erreur lors de l’acceptation de la réunion.');
        }
    } elseif ($action === 'refuser') {
        $reunion->statut = 'refuse';
        $session = $this->request->getSession();

$session->write('notifications.refus', [[
    'message' => "La réunion '{$reunion->titre}' a été refusée (prévue le " . $reunion->date_heure->format('d/m/Y H:i') . ")",
    'send_at' => date('Y-m-d H:i:s'),
    'id_reunion' => $reunion->id,
    'annulee' => false
]]);
        $this->Reunions->save($reunion);
        $this->Flash->success('Réunion refusée.');
    }

    return $this->redirect(['action' => 'index']);
}

public function planifier($id)
{
    $user = $this->Authentication->getIdentity();
    if (!$user || $user->role !== 'admin') {
        $this->Flash->error("Accès refusé.");
        return $this->redirect(['action' => 'index']);
    }

    // Tables nécessaires
    $Reunions = $this->fetchTable('Reunions');
    $Planification = $this->fetchTable('Planification');
    $ParticipantsPlanifications = $this->fetchTable('ParticipantsPlanifications');

    // ✅ Récupérer la réunion
    $reunion = $Reunions->get($id);

    // ✅ Créer et sauvegarder la planification
    $planif = $Planification->newEmptyEntity();
    $planif->titre = $reunion->titre;
    $planif->date_planification = $reunion->date_heure;
    $planif->lieu = $reunion->lieu;
    $planif->cree_par = $reunion->cree_par; 
    $planif->id_type = $reunion->id_type;
    $planif->statut = 'en_attente';
    $planif->planifie_par = $user->id;

    if ($Planification->save($planif)) {
        // ✅ Récupérer les participants cochés (stockés en JSON)
        $participantsAttente = !empty($reunion->participants_attente) 
            ? json_decode($reunion->participants_attente, true) 
            : [];

        // ✅ Ajouter chaque participant dans la planification
        foreach ($participantsAttente as $idUser) {
            $pp = $ParticipantsPlanifications->newEntity([
                'id_planification' => $planif->id,
                'id_utilisateur' => $idUser,
                'statut' => 'en_attente',
                'presence' => 0
            ]);
            $ParticipantsPlanifications->save($pp);
        }

        $this->Flash->success("La planification a été créée avec les participants sélectionnés.");
        return $this->redirect(['controller' => 'Planification', 'action' => 'index']);
    }

    $this->Flash->error("Erreur lors de la création de la planification.");
    return $this->redirect(['action' => 'index']);
}


public function accepter($id)
{
    $reunionsTable = $this->getTableLocator()->get('Reunions');
    $participantsTable = $this->getTableLocator()->get('Participants');

    $reunion = $reunionsTable->get($id);

    if (!$reunion) {
        $this->Flash->error("Réunion introuvable.");
        return $this->redirect(['action' => 'index']);
    }

    $reunion->statut = 'valider';
    if ($reunionsTable->save($reunion)) {

        // ✅ Ajouter le créateur
        $participantCreateur = $participantsTable->newEntity([
            'id_reunion' => $reunion->id,
            'id_utilisateur' => $reunion->cree_par,
            'statut' => 'valider',
            'presence' => 0
        ]);
       
        // Ajouter notification dans la clé 'notifications.accepte'
        // Après avoir marqué la réunion comme acceptée



        $participantsTable->save($participantCreateur);

        // ✅ Ajouter les participants stockés en attente
        if (!empty($reunion->participants_attente)) {
            $ids = json_decode($reunion->participants_attente, true);

            foreach ($ids as $idUser) {
                if ($idUser != $reunion->cree_par) {
                    $participant = $participantsTable->newEntity([
                        'id_reunion' => $reunion->id,
                        'id_utilisateur' => $idUser,
                        'statut' => 'valider',
                        'presence' => 0
                    ]);
                    $participantsTable->save($participant);
                }
            }
        }
     
// Notification pour le créateur de la réunion
// Après avoir marqué la réunion comme acceptée
$session = $this->request->getSession();

$session->write('notifications.accept', [[
    'message' => "La réunion '{$reunion->titre}' a été acceptée (prévue le " . $reunion->date_heure->format('d/m/Y H:i') . ")",
    'send_at' => date('Y-m-d H:i:s'),
    'id_reunion' => $reunion->id,
    'annulee' => false
]]);


// Sauvegarder en session pour affichage immédiat





        // Nettoyer le champ participants_attente
        $reunion->participants_attente = null;
        $reunionsTable->save($reunion);

        $this->Flash->success("Réunion acceptée et participants ajoutés.");
    } else {
        $this->Flash->error("Erreur lors de l'acceptation.");
    }
    

    return $this->redirect(['action' => 'index']);
}










    // Ajoute les autres méthodes (view, edit, delete) si besoin
}