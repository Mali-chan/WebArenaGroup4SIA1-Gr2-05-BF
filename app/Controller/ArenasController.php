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
            $this->set('avatar', 'avatar' . DS . $fighter['Fighter']['id']);
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

        $fighters = $this->Fighter->find('all');
        $this->set('fighters', $fighters);

        $playerFighter = $this->Fighter->findByPlayerId('545f827c-576c-4dc5-ab6d-27c33186dc3e');

        // Map of the arena
        $map = array();
        $height = Configure::read('Arena.height');
        $width = Configure::read('Arena.width');
        for ($row = $height - 1; $row >= 0; $row--) {
            for ($col = 0; $col < $width; $col++) {
                // If position is attacker's (player's)
                if ($row == $playerFighter['Fighter']['coordinate_y'] && $col == $playerFighter['Fighter']['coordinate_x']) {
                    // If attacker has avatar
                    if (file_exists(WWW_ROOT . DS . 'img' . DS . 'avatar' . DS . $playerFighter['Fighter']['id'])) {
                        $map[$row][$col] = 'avatar' . DS . $playerFighter['Fighter']['id'];
                    }
                    // If attacker has not avatar
                    else {
                        $map[$row][$col] = 'map' . DS . 'attacker.png';
                    }
                } else {
                    // If position is defender's
                    $defender = $this->Fighter->findByCoordinate_xAndCoordinate_y($col,
                            $row);
                    if (!empty($defender)) {
                        // If defender has avatar
                        if (file_exists(WWW_ROOT . DS . 'img' . DS . 'avatar' . DS . $defender['Fighter']['id'])) {
                            $map[$row][$col] = 'avatar' . DS . $defender['Fighter']['id'];
                        }
                        // If defender has not avatar
                        else {
                            $map[$row][$col] = 'map' . DS . 'defender.jpg';
                        }
                    } else {
                        // If position is within sight
                        if ($this->Fighter->isWithinSight($playerFighter['Fighter']['id'], $col, $row)) {
                            if (($row + $col) % 2 == 0) {
                                $map[$row][$col] = 'map' . DS . 'even.png';
                            } else {
                                $map[$row][$col] = 'map' . DS . 'odd.png';
                            }
                        }
                        // If position is not within sight
                        else {
                            $map[$row][$col] = 'map' . DS . 'invisible.png';
                        }
                    }
                }
            }
        }
        $this->set('map', $map);
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
