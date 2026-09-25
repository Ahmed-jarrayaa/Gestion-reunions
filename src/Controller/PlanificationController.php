<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Planification Controller
 *
 * @property \App\Model\Table\PlanificationTable $Planification
 */
class PlanificationController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
public function index()
{
    $user = $this->request->getAttribute('identity'); // utilisateur connecté

    // Requête filtrée : uniquement les planifications créées par cet utilisateur
    $query = $this->Planification->find()
        ->where(['cree_par' => $user->id]);

    // Pagination
    $planification = $this->paginate($query);

    $this->set(compact('planification'));
}

    /**
     * View method
     *
     * @param string|null $id Planification id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $planification = $this->Planification->get($id, contain: []);
        $this->set(compact('planification'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
public function add($idReunion = null)
{
    // Tables
    $Planification = $this->fetchTable('Planification'); // Table SQL = planification
    $ParticipantsPlanifications = $this->fetchTable('ParticipantsPlanifications');
    $TypesReunions = $this->fetchTable('TypesReunions');
    $Utilisateurs = $this->fetchTable('Utilisateurs');
    $Reunions = $this->fetchTable('Reunions');

    // Vérifier utilisateur connecté
    $user = $this->request->getAttribute('identity');
    if (!$user) {
        $this->Flash->error('Vous devez être connecté pour créer une planification.');
        return $this->redirect(['controller' => 'Reunions', 'action' => 'index']);
    }

    // Vérifier rôle admin
    if ($user->role !== 'admin') {
        $this->Flash->error("Accès refusé. Seuls les administrateurs peuvent créer une planification.");
        return $this->redirect(['controller' => 'Reunions', 'action' => 'index']);
    }

    $reunion = null;
    $planification = $Planification->newEmptyEntity();

    // Préremplir la planification si une réunion est passée
    // Préremplir la planification si une réunion est passée
// Préremplir la planification si une réunion est passée
if ($idReunion) {
    // Récupérer la réunion
    $reunion = $Reunions->get($idReunion);

    // 🔹 Charger les participants de la réunion avec find()
    $participants = $this->fetchTable('Participants')
        ->find()
        ->select(['id_utilisateur'])
        ->where(['id_reunion' => $idReunion])
        ->all();

    // Préparer le tableau d'IDs pour le formulaire
    $selectedParticipants = [];
    foreach ($participants as $p) {
        $selectedParticipants[] = $p->id_utilisateur;
    }

    $this->set(compact('selectedParticipants'));

    // Préremplir la planification
    if ($reunion) {
        $planification->titre = $reunion->titre ?? null;
        $planification->lieu = $reunion->lieu ?? null;
        $planification->date_planification = $reunion->date_heure ?? null;
        $planification->id_type = $reunion->id_type ?? null;
        $planification->statut = 'en_attente';
    }
}





    // Soumission du formulaire
    if ($this->request->is('post')) {
        $data = $this->request->getData();

        // Associer le créateur de la réunion
        $data['cree_par'] = $reunion ? $reunion->cree_par : $user->id;

        // Associer la réunion si présente
        if ($idReunion) {
            $data['id_reunion'] = $idReunion;
        }

        // Conversion de la date
        if (!empty($data['date_planification'])) {
            $data['date_planification'] = date('Y-m-d H:i:s', strtotime($data['date_planification']));
        }

        // Créer la planification
        $planification = $Planification->patchEntity($planification, $data);

        if ($Planification->save($planification)) {
            // Ajouter le créateur comme participant
            $creatorParticipant = $ParticipantsPlanifications->newEntity([
                'id_planification' => $planification->id,
                'id_utilisateur'   => $user->id,
                'presence'         => 0
            ]);
            $ParticipantsPlanifications->save($creatorParticipant);

            // Ajouter les autres participants
           $submittedParticipants = $data['participants_ids'] ?? [];
foreach ($submittedParticipants as $userId) {
    if (!empty($userId) && $userId != $user->id) {
        $participantEntity = $ParticipantsPlanifications->newEntity([
            'id_planification' => $planification->id,
            'id_utilisateur'   => $userId,
            'presence'         => 0
        ]);
        $ParticipantsPlanifications->save($participantEntity);
    }
}



            // Supprimer la réunion si elle existe
            if ($idReunion && $reunion) {
                $Reunions->delete($reunion);
            }

            $this->Flash->success('✅ Planification créée avec succès. La réunion proposée a été supprimée.');
            return $this->redirect(['controller' => 'Planification', 'action' => 'index']);
        } else {
            $this->Flash->error("❌ Impossible de créer la planification.");
        }
    }

    // Charger les types de réunion et utilisateurs
    $types = $TypesReunions->find('list', [
        'keyField' => 'id',
        'valueField' => 'nom_type'
    ])->toArray();

    $utilisateurs = $Utilisateurs->find('list', [
        'keyField' => 'id',
        'valueField' => 'email'
    ])->toArray();

    $this->set(compact('planification', 'types', 'utilisateurs', 'reunion', 'selectedParticipants'));
}



/**
 * Edit method
     *
     * @param string|null $id Planification id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function edit($id = null)
{
    $Planification = $this->fetchTable('Planification');
    $ParticipantsPlanifications = $this->fetchTable('ParticipantsPlanifications'); // table réelle
    $TypesReunions = $this->fetchTable('TypesReunions');
    $Utilisateurs = $this->fetchTable('Utilisateurs');

    // Charger la planification
    $planification = $Planification->get($id);

    $user = $this->request->getAttribute('identity');
    if ($user->role !== 'admin' ) {
        $this->Flash->error("Vous n'avez pas le droit de modifier cette planification.");
        return $this->redirect(['action' => 'index']);
    }

    if ($this->request->is(['post', 'put', 'patch'])) {
        $data = $this->request->getData();

        // Conversion de la date
        if (!empty($data['date_planification'])) {
            $data['date_planification'] = date('Y-m-d H:i:s', strtotime($data['date_planification']));
        }

        // Mise à jour de la planification
        $planification = $Planification->patchEntity($planification, $data);

        if ($Planification->save($planification)) {
            // 🔄 Supprimer les anciens participants
            $ParticipantsPlanifications->deleteAll(['id_planification' => $planification->id]);

            // ✅ Réinsérer les participants envoyés
            $submittedParticipants = $data['participants_planifications'] ?? [];
            foreach ($submittedParticipants as $p) {
                if (!empty($p['id_utilisateur'])) {
                    $participantEntity = $ParticipantsPlanifications->newEntity([
                        'id_planification' => $planification->id,
                        'id_utilisateur'  => $p['id_utilisateur'],
                        'presence'        => 0
                    ]);
                    $ParticipantsPlanifications->save($participantEntity);
                }
            }

            $this->Flash->success("Planification modifiée avec succès !");
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error("Impossible de modifier la planification.");
        }
    }

    // Charger les types de réunion
    $types = $TypesReunions->find('list', [
        'keyField' => 'id',
        'valueField' => 'nom_type'
    ])->order(['nom_type' => 'ASC'])->toArray();

    // Charger les utilisateurs
    $utilisateurs = $Utilisateurs->find('list', [
        'keyField' => 'id',
        'valueField' => 'email'
    ])->toArray();

    // Charger les participants actuels via l’association correcte
    $existingParticipants = $ParticipantsPlanifications->find()
        ->where(['id_planification' => $id])
        ->all()
        ->toArray();

    $this->set(compact('planification', 'types', 'utilisateurs', 'existingParticipants'));
}



/**
 * Delete method
     *
     * @param string|null $id Planification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
public function delete($id = null)
{
    $this->request->allowMethod(['post', 'delete']);

    $user = $this->request->getAttribute('identity'); // utilisateur connecté
    if (!$user || $user->role !== 'admin') {
        $this->Flash->error(__('Vous n\'avez pas la permission de supprimer cette planification.'));
        return $this->redirect(['action' => 'index']);
    }

    // Tables nécessaires
    $Planification = $this->fetchTable('Planification');
    $ParticipantsPlanifications = $this->fetchTable('ParticipantsPlanifications'); // table réelle

    // Charger la planification
    $planification = $Planification->get($id);

    // La suppression des participants est automatique grâce à 'dependent' => true
    if ($Planification->delete($planification)) {
        $this->Flash->success(__('La planification a été supprimée avec succès.'));
    } else {
        $this->Flash->error(__('Impossible de supprimer la planification. Veuillez réessayer.'));
    }

    return $this->redirect(['action' => 'index']);
}





public function accepter($id)
{
    $Planification = $this->fetchTable('Planification');
    $ParticipantsPlanifications = $this->fetchTable('ParticipantsPlanifications');
    $Participants = $this->fetchTable('Participants');
    $Reunions = $this->fetchTable('Reunions');

    $planif = $Planification->get($id, [
        'contain' => ['ParticipantsPlanifications'] // charger les participants
    ]);

    $user = $this->request->getAttribute('identity');

    // Vérifier que le membre est bien le créateur
    if ($user->id !== $planif->cree_par) {
        $this->Flash->error("Vous n'avez pas le droit d'accepter cette planification.");
        return $this->redirect(['action'=>'index']);
    }

    // Mettre à jour le statut de la planification
    $planif->statut = 'accepte';
    $Planification->save($planif);

    // Créer la réunion définitive
    $reunion = $Reunions->newEmptyEntity();
    $reunion->titre = $planif->titre;
    $reunion->date_heure = $planif->date_planification;
    $reunion->lieu = $planif->lieu;
    $reunion->cree_par = $planif->cree_par;
    $reunion->id_type = $planif->id_type;
    $reunion->statut = 'valider';

    if ($Reunions->save($reunion)) {
         // Ajouter le créateur de la planification comme participant
    $existe = $Participants->find()
        ->where(['id_reunion' => $reunion->id, 'id_utilisateur' => $planif->cree_par])
        ->first();
    if (!$existe) {
        $creator = $Participants->newEmptyEntity();
        $creator->id_reunion = $reunion->id;
        $creator->id_utilisateur = $planif->cree_par;
        $creator->presence = 'en_attente';
        $Participants->save($creator);
    }
        // Ajouter tous les participants de la planification
        foreach ($planif->participants_planifications as $pp) {
            if ((string)$pp->id_utilisateur === (string)$planif->cree_par) {
                continue;
            }
            $existe = $Participants->find()
                ->where(['id_reunion' => $reunion->id, 'id_utilisateur' => $pp->id_utilisateur])
                ->first();
            if ($existe) {
                continue;
            }
            $participant = $Participants->newEmptyEntity();
            $participant->id_reunion = $reunion->id;
            $participant->id_utilisateur = $pp->id_utilisateur;
            $participant->presence = 'en_attente';
            $Participants->save($participant);
        }

        $this->Flash->success("Planification acceptée et réunion créée avec succès !");
    } else {
        $this->Flash->error("Impossible de créer la réunion à partir de la planification.");
    }

    return $this->redirect(['action'=>'index']);
}







public function refuser($id)
{
    $Planification = $this->fetchTable('Planification');

    $planif = $Planification->get($id);
    $user = $this->request->getAttribute('identity');

    if ($user->id !== $planif->cree_par) {
        $this->Flash->error("Vous n'avez pas le droit de refuser cette planification.");
        return $this->redirect(['action'=>'index']);
    }

    $planif->statut = 'refuse';
    $Planification->save($planif);

    // Notification à l'admin qui a planifié
    $session = $this->request->getSession();
    $key = "notifications.{$planif->planifie_par}.refus";
    $existing = $session->read($key) ?? [];
    $existing[] = [
        'message' => "La planification '{$planif->titre}' a été refusée par le créateur.",
        'send_at' => date('Y-m-d H:i:s'),
        'id_planif' => $planif->id
    ];
    $session->write($key, $existing);

    $this->Flash->success("Planification refusée, l'admin en a été notifié.");
    return $this->redirect(['action'=>'index']);
}


public function notifyCreateurRefus($planificationId)
{
    $planificationTable = $this->getTableLocator()->get('Planification');
    $planification = $planificationTable->get($planificationId);

    // Récupérer l’utilisateur créateur
    $createurId = $planification->cree_par;

    // Construire le message
    $message = "Votre planification '{$planification->titre}' prévue le {$planification->date_planification} a été refusée.";

    // Stocker dans la session (comme pour annulation)
    $this->request->getSession()->write('notifications.refus', [[
        'message' => $message,
        'send_at' => date('Y-m-d H:i:s'),
        'id_planification' => $planificationId,
        'id_utilisateur' => $createurId
    ]]);

    return true;
}


}
