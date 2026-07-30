<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;

use App\Controller\AppController;

class ParticipantsController extends AppController
{
    // En haut du fichier, dans la classe du contrôleur
protected $Notifications;

    public function initialize(): void
    {
        parent::initialize();
        // Chargement du composant d'authentification
        $this->loadComponent('Authentication.Authentication');
        // Chargement du composant pour les messages flash
        $this->loadComponent('Flash');
        
    }

    // Liste tous les participants
   public function index()
{
    $user = $this->Authentication->getIdentity();
    $reunionId = $this->request->getQuery('id_reunion');

    $query = $this->Participants->find()
        ->contain(['Reunions', 'Utilisateurs']); // récupérer les infos des relations

    if ($reunionId) {
        $query->where(['Participants.id_reunion' => $reunionId]);
    }

    // Pour les membres : ne voir que leurs participations à des réunions validées
    if ($user->role !== 'admin') {
        $query->matching('Reunions', function ($q) use ($user) {
            return $q->where([
                'Reunions.statut' => 'valider',
                'Participants.id_utilisateur' => $user->id
            ]);
        });
    }

    // Pagination
    $participants = $this->paginate($query);

    $this->set(compact('participants'));
}

    // Ajouter un participant
// tout en haut du fichier

public function add($idReunion = null)
{
    $Planification = $this->fetchTable('Planification');
    $ParticipantsPlanifications = $this->fetchTable('ParticipantsPlanifications');
    $Reunions = $this->fetchTable('Reunions');
    $Participants = $this->fetchTable('Participants');
    $Utilisateurs = $this->fetchTable('Utilisateurs');

    $planification = $Planification->newEmptyEntity();
    $selectedParticipants = [];

    if ($idReunion) {
        $reunion = $Reunions->get($idReunion);

        // Préremplir les champs de la planification
        $planification->titre = $reunion->titre;
        $planification->lieu = $reunion->lieu;
        $planification->date_planification = $reunion->date_heure;
        $planification->id_type = $reunion->id_type;

        // 🔹 Charger les participants de la réunion
        $participants = $Participants->find()
            ->where(['id_reunion' => $idReunion])
            ->all();

        foreach ($participants as $p) {
            $selectedParticipants[] = $p->id_utilisateur;
        }
    }

    if ($this->request->is('post')) {
        $data = $this->request->getData();
        $data['id_reunion'] = $idReunion;
        $planification = $Planification->patchEntity($planification, $data);

        if ($Planification->save($planification)) {
            // Ajouter les participants sélectionnés dans participants_planifications
            $participants_ids = $data['participants_planifications'] ?? [];
            foreach ($participants_ids as $uid) {
                $pp = $ParticipantsPlanifications->newEmptyEntity();
                $pp->id_planification = $planification->id;
                $pp->id_utilisateur = $uid;
                $pp->presence = 0;
                $ParticipantsPlanifications->save($pp);
            }

            $this->Flash->success('Planification créée avec succès.');
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error('Impossible de créer la planification.');
    }

    $utilisateurs = $Utilisateurs->find('list', [
        'keyField' => 'id',
        'valueField' => 'email'
    ])->toArray();

    $this->set(compact('planification', 'utilisateurs', 'selectedParticipants', 'idReunion'));
}




    // Supprimer un participant
   public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);
    $user = $this->Authentication->getIdentity();

    $participant = $this->Participants->get($id);
    $reunion = $this->Participants->Reunions->get($participant->id_reunion);

    // Vérifier l'accès : admin peut supprimer tout, membre seulement ses propres réunions
    if ($user->role !== 'admin' ) {
        $this->Flash->error('Vous n’avez pas la permission de supprimer ce participant.');
        return $this->redirect($this->referer());
    }

    if ($this->Participants->delete($participant)) {
        $this->Flash->success('Participant supprimé.');
    } else {
        $this->Flash->error('Impossible de supprimer ce participant.');
    }

    return $this->redirect($this->referer());
}
public function edit($id = null)
{
    $user = $this->Authentication->getIdentity();

    $participant = $this->Participants->get($id, [
        'contain' => ['Reunions']
    ]);
    $reunion = $participant->reunion;

    // Vérifier l'accès : admin peut modifier tout, membre seulement ses propres réunions
    if ($user->role !== 'admin' && $reunion->cree_par !== $user->id) {
        $this->Flash->error('Vous n’avez pas la permission de modifier ce participant.');
        return $this->redirect(['action' => 'index']);
    }

    if ($this->request->is(['post', 'put', 'patch'])) {
        $participant = $this->Participants->patchEntity($participant, $this->request->getData());
        if ($this->Participants->save($participant)) {
            $this->Flash->success('Participant modifié avec succès.');
            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error('Impossible de modifier ce participant.');
    }

    // Charger les réunions accessibles à l’utilisateur (admin toutes, membre ses propres)
    if ($user->role === 'admin') {
        $reunions = $this->Participants->Reunions->find('list', ['keyField' => 'id', 'valueField' => 'titre'])->toArray();
    } else {
        $reunions = $this->Participants->Reunions->find('list', [
            'conditions' => ['cree_par' => $user->id],
            'keyField' => 'id',
            'valueField' => 'titre'
        ])->toArray();
    }

    $utilisateurs = $this->Participants->Utilisateurs->find('list', ['keyField' => 'id', 'valueField' => 'email'])->toArray();

    $this->set(compact('participant', 'reunions', 'utilisateurs'));
}
public function view($id = null)
{
    $participant = $this->Participants->get($id, [
        'contain' => ['Reunions', 'Utilisateurs']
    ]);

    $this->set(compact('participant'));
}




}
