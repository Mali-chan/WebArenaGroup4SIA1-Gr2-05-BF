<?php

/**
 * Main controller of the application
 *
 * @author Mali
 */
App::uses('AppController', 'Controller');

class ArenasController extends AppController {

    public $uses = array(
        'Fighter',
        'Event');

    public function beforefilter() {
        parent::beforeFilter();
//        $this->Auth->allow(); // Allow all actions
        $this->Auth->allow('index');
    }

    /**
     * Index method : first page
     */
    public function index() {
        
    }

    /**
     * Fighter page
     * @todo with sessions, parameter playerId must be the currently connected player
     */
    public function fighter() {
        pr($this->request->data);

        // Find logged player's fighter
        $fighter = $this->Fighter->findByPlayerId('545f827c-576c-4dc5-ab6d-27c33186dc3e');

        if ($this->request->is('post')) {
            // Create fighter
            if (isset($this->request->data['Fighter']['name'])) {
                $this->Fighter->doCreate('545f827c-576c-4dc5-ab6d-27c33186dc3e',
                        $this->request->data['Fighter']['name']);
                $fighter = $this->Fighter->findByPlayerId('545f827c-576c-4dc5-ab6d-27c33186dc3e');
            }
            // Upload avatar
            else if (isset($this->request->data['Fighteruploadavatar']['file'])) {
                $filename = $this->request->data['Fighteruploadavatar']['file']['tmp_name'];
                $destination = WWW_ROOT . DS . 'img' . DS . 'avatar' . DS . 1;
                if (move_uploaded_file($filename, $destination)) {
                    $this->Flash->success('The avatar has been uploaded.');
                } else {
                    $this->Flash->error('The avatar could not be uploaded. Please, try again.');
                }
            }
            // Level up
            else if (isset($this->request->data['Fighterlevelup']['skill'])) {
                if ($this->Fighter->doLevelUp(1,
                        $this->request->data['Fighterlevelup']['skill'])) {
                    $this->Flash->success('Successful level up.');
                } else {
                    $this->Flash->error('Level up failed.');
                }
            }
        }

        // Set variables to use inside view
        $this->set('fighter', $fighter);
        if (!empty($fighter['Fighter']['id']) && file_exists(WWW_ROOT . DS . 'img' . DS . 'avatar' . DS . $fighter['Fighter']['id'])) {
            $this->set('avatar', 'avatar/' . $fighter['Fighter']['id']);
        }
    }

    /**
     * Sight page
     * @todo pass the correct fighterId parameter
     */
    public function sight() {
        pr($this->request->data);
        if ($this->request->is('post')) {
            // Move
            if (isset($this->request->data['Fightermove']['direction'])) {
                if ($this->Fighter->doMove(1,
                        $this->request->data['Fightermove']['direction'])) {
                    $this->Flash->success('Successful move.');
                } else {
                    $this->Flash->error('Move failed.');
                }
            }
            // Attack
            else if (isset($this->request->data['Fighterattack']['direction'])) {
                if ($this->Fighter->doAttack(1,
                        $this->request->data['Fighterattack']['direction'])) {
                    $this->Flash->success('Successful attack.');
                } else {
                    $this->Flash->error('Attack failed.');
                }
            }
        }
        $this->set('fighters', $this->Fighter->find('all'));
    }

    /**
     * Diary page
     */
    public function diary() {
        if ($this->Event->getEvent()) {
            $this->set('raw', $this->Event->getEvent());
        }
    }

}
