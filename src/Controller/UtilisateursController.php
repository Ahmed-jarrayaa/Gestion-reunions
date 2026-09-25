<?php
declare(strict_types=1);

namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Event\EventInterface;

/**
 * @property \App\Model\Table\UtilisateursTable $Utilisateurs
 */
class UtilisateursController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Actions publiques sans authentification
        $this->Authentication->addUnauthenticatedActions(['login', 'add', 'logout', 'deconnexion']);
    }

    /**
     * Tableau de bord de l'utilisateur connecté.
     */
    public function dashboard()
    {
        $user = $this->request->getAttribute('identity');
        $userId = $user->id;
        $userRole = $user->role;

        $reunionsTable = $this->fetchTable('Reunions');

        if ($userRole === 'admin') {
            $reunions = $reunionsTable->find()
                ->contain(['TypesReunions'])
                ->orderBy(['date_heure' => 'DESC'])
                ->all();
        } else {
            // Réunions où l'utilisateur est participant
            $reunions = $reunionsTable->find()
                ->matching('Participants', function ($q) use ($userId) {
                    return $q->where(['Participants.id_utilisateur' => $userId]);
                })
                ->distinct(['Reunions.id'])
                ->orderBy(['Reunions.date_heure' => 'DESC'])
                ->all();
        }

        $this->set(compact('user', 'userRole', 'reunions'));
    }

    /**
     * Connexion.
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $target = $this->request->getQuery('redirect', '/dashboard');

            return $this->redirect($target);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Identifiants invalides');
        }
    }

    /**
     * Déconnexion.
     */
    public function logout()
    {
        $this->Authentication->logout();
        $this->request->getSession()->destroy();
        $this->Flash->success('Déconnexion réussie.');

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Déconnexion (raccourci utilisé par le layout).
     */
    public function deconnexion()
    {
        return $this->logout();
    }

    /**
     * Liste des utilisateurs (administrateurs uniquement).
     */
    public function index()
    {
        $user = $this->Authentication->getIdentity();

        if (!$user || $user->role !== 'admin') {
            $this->Flash->error("Accès non autorisé.");

            return $this->redirect('/dashboard');
        }

        $utilisateurs = $this->paginate($this->Utilisateurs);
        $this->set(compact('utilisateurs'));
    }

    /**
     * Profil d'un utilisateur (soi-même pour les membres, tous pour les admins).
     */
    public function view($id = null)
    {
        $user = $this->request->getAttribute('identity');
        $id = $id ?? $user->id;

        if ($user->role !== 'admin' && (int)$user->id !== (int)$id) {
            $this->Flash->error('Accès refusé.');

            return $this->redirect('/dashboard');
        }

        $utilisateur = $this->Utilisateurs->get($id, [
            'contain' => ['Reunions', 'Fonctions'],
        ]);

        $this->set(compact('utilisateur'));
    }

    /**
     * Inscription (les nouveaux comptes sont toujours créés en tant que membre).
     */
    public function add()
    {
        $utilisateur = $this->Utilisateurs->newEmptyEntity();

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            // Sécurité : jamais de rôle via le formulaire d'inscription
            unset($data['role']);
            $data['role'] = 'membre';

            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $data);

            if ($this->Utilisateurs->save($utilisateur)) {
                $this->Flash->success('Votre compte a été créé avec succès.');

                // Connexion automatique après inscription
                $this->Authentication->setIdentity($utilisateur);

                return $this->redirect(['controller' => 'Reunions', 'action' => 'index']);
            }
            $this->Flash->error('Impossible de créer votre compte. Vérifiez les champs (mot de passe : 6 caractères minimum).');
        }
        $this->set(compact('utilisateur'));
    }

    /**
     * Modification du profil : un membre ne peut modifier que son propre compte,
     * seul un administrateur peut changer le rôle.
     */
    public function edit($id = null)
    {
        $user = $this->Authentication->getIdentity();
        $id = $id ?? $user->id;

        if (!$user) {
            return $this->redirect(['action' => 'login']);
        }

        // Seul l'admin modifie un autre compte
        if ($user->role !== 'admin' && (int)$user->id !== (int)$id) {
            $this->Flash->error('Accès refusé.');

            return $this->redirect(['action' => 'view', $user->id]);
        }

        $utilisateur = $this->Utilisateurs->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Mot de passe : uniquement si un nouveau mot de passe est fourni
            if (empty($data['mot_de_passe'])) {
                unset($data['mot_de_passe']);
            }

            // Seul un administrateur peut modifier le rôle
            if ($user->role === 'admin' && isset($data['role'])) {
                $utilisateur->role = in_array($data['role'], ['admin', 'membre'], true) ? $data['role'] : 'membre';
            }
            unset($data['role']);

            $utilisateur = $this->Utilisateurs->patchEntity($utilisateur, $data);

            if ($this->Utilisateurs->save($utilisateur)) {
                $this->Flash->success('Vos informations ont été mises à jour.');

                return $this->redirect(['action' => 'view', $utilisateur->id]);
            }
            $this->Flash->error('Impossible de mettre à jour vos informations.');
        }

        $this->set(compact('utilisateur'));
    }

    /**
     * Suppression d'un compte (administrateurs uniquement).
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $user = $this->Authentication->getIdentity();
        if (!$user || $user->role !== 'admin') {
            $this->Flash->error('Accès non autorisé.');

            return $this->redirect(['action' => 'index']);
        }

        $utilisateur = $this->Utilisateurs->get($id);

        if ($this->Utilisateurs->delete($utilisateur)) {
            $this->Flash->success('Le compte a été supprimé.');
        } else {
            $this->Flash->error('Impossible de supprimer le compte.');
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Changement de mot de passe du compte connecté.
     */
    public function changePassword()
    {
        $user = $this->Authentication->getIdentity();
        if (!$user) {
            return $this->redirect(['action' => 'login']);
        }

        $userId = $user->id;
        $utilisateur = $this->Utilisateurs->get($userId);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $passwordActuel = $data['current_password'] ?? '';
            $nouveauPassword = $data['new_password'] ?? '';
            $confirmerPassword = $data['confirm_password'] ?? '';

            $hasher = new DefaultPasswordHasher();

            if (strlen($nouveauPassword) < 6) {
                $this->Flash->error('Le nouveau mot de passe doit contenir au moins 6 caractères.');

                return $this->redirect(['action' => 'changePassword']);
            }

            if ($nouveauPassword !== $confirmerPassword) {
                $this->Flash->error('Le nouveau mot de passe et sa confirmation ne correspondent pas.');

                return $this->redirect(['action' => 'changePassword']);
            }

            if (empty($utilisateur->mot_de_passe) || !$hasher->check($passwordActuel, $utilisateur->mot_de_passe)) {
                $this->Flash->error('Le mot de passe actuel est incorrect.');

                return $this->redirect(['action' => 'changePassword']);
            }

            // Le hachage est réalisé dans UtilisateursTable::beforeSave
            $utilisateur->mot_de_passe = $nouveauPassword;

            if ($this->Utilisateurs->save($utilisateur)) {
                $this->Flash->success('Mot de passe modifié avec succès.');

                return $this->redirect(['action' => 'view', $userId]);
            }
            $this->Flash->error('Erreur lors de la mise à jour du mot de passe.');
        }

        $this->set(compact('utilisateur'));
    }
}