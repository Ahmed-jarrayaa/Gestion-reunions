<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * TypesReunions Controller
 *
 * @property \App\Model\Table\TypesReunionsTable $TypesReunions
 */
class TypesReunionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TypesReunions->find();
        $typesReunions = $this->paginate($query);

        $this->set(compact('typesReunions'));
    }

    /**
     * View method
     *
     * @param string|null $id Types Reunion id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $typesReunion = $this->TypesReunions->get($id, contain: []);
        $this->set(compact('typesReunion'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $typesReunion = $this->TypesReunions->newEmptyEntity();
        if ($this->request->is('post')) {
            $typesReunion = $this->TypesReunions->patchEntity($typesReunion, $this->request->getData());
            if ($this->TypesReunions->save($typesReunion)) {
                $this->Flash->success(__('The types reunion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The types reunion could not be saved. Please, try again.'));
        }
        $this->set(compact('typesReunion'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Types Reunion id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $typesReunion = $this->TypesReunions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $typesReunion = $this->TypesReunions->patchEntity($typesReunion, $this->request->getData());
            if ($this->TypesReunions->save($typesReunion)) {
                $this->Flash->success(__('The types reunion has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The types reunion could not be saved. Please, try again.'));
        }
        $this->set(compact('typesReunion'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Types Reunion id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $typesReunion = $this->TypesReunions->get($id);
        if ($this->TypesReunions->delete($typesReunion)) {
            $this->Flash->success(__('The types reunion has been deleted.'));
        } else {
            $this->Flash->error(__('The types reunion could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);

    $user = $this->request->getAttribute('identity');
    if ($user && $user->role === 'membre') {
        // Redirige ou affiche un message d'erreur
        $this->Flash->error('Vous n’avez pas accès à cette page.');
        return $this->redirect('/dashboard');
    }
}
}
