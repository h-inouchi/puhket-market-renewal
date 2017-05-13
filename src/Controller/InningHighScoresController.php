<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * InningHighScores Controller
 *
 * @property \App\Model\Table\InningHighScoresTable $InningHighScores
 */
class InningHighScoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $inningHighScores = $this->paginate($this->InningHighScores);

        $this->set(compact('inningHighScores'));
        $this->set('_serialize', ['inningHighScores']);
    }

    /**
     * View method
     *
     * @param string|null $id Inning High Score id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inningHighScore = $this->InningHighScores->get($id, [
            'contain' => []
        ]);

        $this->set('inningHighScore', $inningHighScore);
        $this->set('_serialize', ['inningHighScore']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inningHighScore = $this->InningHighScores->newEntity();
        if ($this->request->is('post')) {
            $inningHighScore = $this->InningHighScores->patchEntity($inningHighScore, $this->request->getData());
            if ($this->InningHighScores->save($inningHighScore)) {
                $this->Flash->success(__('The inning high score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inning high score could not be saved. Please, try again.'));
        }
        $this->set(compact('inningHighScore'));
        $this->set('_serialize', ['inningHighScore']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Inning High Score id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inningHighScore = $this->InningHighScores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inningHighScore = $this->InningHighScores->patchEntity($inningHighScore, $this->request->getData());
            if ($this->InningHighScores->save($inningHighScore)) {
                $this->Flash->success(__('The inning high score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inning high score could not be saved. Please, try again.'));
        }
        $this->set(compact('inningHighScore'));
        $this->set('_serialize', ['inningHighScore']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Inning High Score id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inningHighScore = $this->InningHighScores->get($id);
        if ($this->InningHighScores->delete($inningHighScore)) {
            $this->Flash->success(__('The inning high score has been deleted.'));
        } else {
            $this->Flash->error(__('The inning high score could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
