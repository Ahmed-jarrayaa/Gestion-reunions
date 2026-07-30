<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ParticipantsPlanifications Controller
 *
 * @property \App\Model\Table\ParticipantsPlanificationsTable $ParticipantsPlanifications
 */
class ParticipantsPlanificationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ParticipantsPlanifications->find();
        $participantsPlanifications = $this->paginate($query);

        $this->set(compact('participantsPlanifications'));
    }

    /**
     * View method
     *
     * @param string|null $id Participants Planification id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $participantsPlanification = $this->ParticipantsPlanifications->get($id, contain: []);
        $this->set(compact('participantsPlanification'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $participantsPlanification = $this->ParticipantsPlanifications->newEmptyEntity();
        if ($this->request->is('post')) {
            $participantsPlanification = $this->ParticipantsPlanifications->patchEntity($participantsPlanification, $this->request->getData());
            if ($this->ParticipantsPlanifications->save($participantsPlanification)) {
                $this->Flash->success(__('The participants planification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participants planification could not be saved. Please, try again.'));
        }
        $this->set(compact('participantsPlanification'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Participants Planification id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $participantsPlanification = $this->ParticipantsPlanifications->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $participantsPlanification = $this->ParticipantsPlanifications->patchEntity($participantsPlanification, $this->request->getData());
            if ($this->ParticipantsPlanifications->save($participantsPlanification)) {
                $this->Flash->success(__('The participants planification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The participants planification could not be saved. Please, try again.'));
        }
        $this->set(compact('participantsPlanification'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Participants Planification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $participantsPlanification = $this->ParticipantsPlanifications->get($id);
        if ($this->ParticipantsPlanifications->delete($participantsPlanification)) {
            $this->Flash->success(__('The participants planification has been deleted.'));
        } else {
            $this->Flash->error(__('The participants planification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
