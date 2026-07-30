<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Authentication\Controller\Component\AuthenticationComponent;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Authentication\PasswordHasher\DefaultPasswordHasher;



class UtilisateursController extends AppController
{


    


    public function initialize(): void
{
    parent::initialize();

    $this->loadComponent('Authentication.Authentication');
    $this->loadComponent('Flash');
   
}









public function dashboard()
{
    $user = $this->request->getAttribute('identity'); // utilisateur connecté
    $userId = $user->id;
    $userRole = $user->role;

    $reunionsTable = $this->fetchTable('Reunions');
    $participantsTable = $this->fetchTable('Participants');

    if ($userRole === 'admin') {
        // L'admin voit tout
        $reunions = $reunionsTable->find()->all();
    } else {
        // Utilisateur normal : on récupère ses réunions via la table Participants
        $participants = $participantsTable->find()
            ->where(['id_utilisateur' => $userId])
            ->contain(['Reunions']) // Nécessite association définie dans ParticipantsTable
            ->all();

        // Extraire les réunions uniquement
        $reunions = collection($participants)->extract('reunion')->toList();
    }
    

    $this->set(compact('user', 'userRole', 'reunions'));
}



  public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            // Redirige vers la page d’accueil ou dashboard
            return $this->redirect($this->Authentication->getLoginRedirect() ?? '/dashboard');
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Identifiants invalides.');
        }
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        // Autoriser les actions publiques sans authentification
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'logout']);
    }


    

    /**
     * Méthode de connexion
     */



    /**
     * Méthode de déconnexion
     */
   public function logout()
    {
        // Déconnexion
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success('Déconnexion réussie.');
        }

        return $this->redirect(['action' => 'login']);
    }


    /**
     * Index method
     */
public function index()
{
    $user = $this->Authentication->getIdentity();

    if ($user->role !== 'admin') {
        $this->Flash->error("Accès non autorisé.");
        return $this->redirect($this->referer('/') ?: '/'); // Redirige vers la page précédente ou home
    }

    $utilisateurs = $this->paginate($this->Utilisateurs);
    $this->set(compact('utilisateurs'));
}

public function monProfil()
{
    $id = $this->Authentication->getIdentity()->get('id');
    $utilisateur = $this->Utilisateurs->get($id, [
        'contain' => ['Reunions'], // facultatif si tu veux ses réunions
    ]);

    $this->set(compact('utilisateur'));
}




    /**
     * View method
     */
   public function view($id = null)
{
    $user = $this->request->getAttribute('identity');

    // Membre : peut voir uniquement son propre profil
    if ($user->get('role') !== 'admin' && $user->get('id') != $id) {
        $this->Flash->error('Accès refusé.');
        return $this->redirect('/');
    }

    $utilisateur = $this->Utilisateurs->get($id, [
        'contain' => ['Reunions'], // S'il y a une relation
    ]);

    $this->set(compact('utilisateur'));
}
  public function connexion()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            // Redirige après une connexion réussie
            $target = $this->request->getQuery('redirect', [
                'controller' => 'Dashboard',
                'action' => 'index',
            ]);
            return $this->redirect($target);
        }

        // Affiche un message d'erreur si la tentative de connexion a échoué
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Email ou mot de passe incorrect.'));
        }
    }

    /**
     * Add method (Inscription)
     */
    public function add()
    {
        $utilisateur = $this->Utilisateurs->newEmptyEntity();
        if ($this->request->is(['post','put'])) {
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $this->request->getData());
            
            // Hachage du mot de passe avant sauvegarde
            if (!empty($this->request->getData('mot_de_passe'))) {
                $utilisateur->password = $this->request->getData('mot_de_passe');
            }
            
            if ($this->Utilisateurs->save($utilisateur)) {
                $this->Flash->success(__('Votre compte a été créé avec succès.'));
                
                // Connexion automatique après inscription
                $this->Authentication->setIdentity($utilisateur);
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
            $this->Flash->error(__('Impossible de créer votre compte. Veuillez réessayer.'));
        }
        $this->set(compact('utilisateur'));
    }
     public function deconnexion()
    {
        // Déconnecte l'utilisateur
        $this->Authentication->logout();

        // Redirige vers la page de login ou d'accueil
        return $this->redirect(['controller' => 'Utilisateurs', 'action' => 'login']);
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $utilisateur = $this->Utilisateurs->get($id, [
            'contain' => [],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            
            // Ne pas modifier le mot de passe si le champ est vide
            if (empty($data['password'])) {
                unset($data['password']);
            }
            
            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $data);
            
            if ($this->Utilisateurs->save($utilisateur)) {
                $this->Flash->success(__('Vos informations ont été mises à jour.'));
                return $this->redirect(['action' => 'view', $utilisateur->id]);
            }
            $this->Flash->error(__('Impossible de mettre à jour vos informations.'));
        }
        
        $this->set(compact('utilisateur'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $utilisateur = $this->Utilisateurs->get($id);
        
        // Déconnexion si l'utilisateur supprime son propre compte
        if ($this->Authentication->getIdentity()->id == $id) {
            $this->Authentication->logout();
        }
        
        if ($this->Utilisateurs->delete($utilisateur)) {
            $this->Flash->success(__('Le compte a été supprimé.'));
        } else {
            $this->Flash->error(__('Impossible de supprimer le compte.'));
        }

        return $this->redirect(['action' => 'index']);
    }


public function changePassword()
{
    $userId = $this->request->getAttribute('identity')->getIdentifier(); 
    $utilisateur = $this->Utilisateurs->get($userId);

    if ($this->request->is(['post', 'put'])) {
        $data = $this->request->getData();
        $passwordActuel = $data['mot_de_pass_actuel'] ?? '';
        $nouveauPassword = $data['nouveau_mot_de_pass'] ?? '';
        $confirmerPassword = $data['confirmer_mot_de_pass'] ?? '';

        $hasher = new DefaultPasswordHasher();
        $nouveauHash = $hasher->hash($nouveauPassword);

        

        // 🔹 Vérifier si un mot de passe existe déjà en BDD
        if (empty($utilisateur->mot_de_pass)) {
            $this->Flash->error("Aucun mot de passe initial défini. Veuillez en créer un.");
            return;
        }

        // 🔹 Vérifier le mot de passe actuel (hash vs texte clair)
        if (!$hasher->check($passwordActuel, $utilisateur->mot_de_pass)) {
            $this->Flash->error("Le mot de passe actuel est incorrect.");
            return;
        }

        // 🔹 Vérifier confirmation
        if ($nouveauPassword !== $confirmerPassword) {
            $this->Flash->error("Le nouveau mot de passe et sa confirmation ne correspondent pas.");
            return;
        }

        // 🔹 Hasher et sauvegarder le nouveau mot de passe
        $utilisateur->mot_de_pass = $hasher->hash($nouveauPassword);

        if ($this->Utilisateurs->save($utilisateur)) {
            $this->Flash->success("Mot de passe modifié avec succès.");
            return $this->redirect(['action' => 'profile']); 
        } else {
            $this->Flash->error("Erreur lors de la mise à jour du mot de passe.");
        }
    }

    $this->set(compact('utilisateur'));
}
    // src/Controller/UtilisateursController.php

}