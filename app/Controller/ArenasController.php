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
        $this->Auth->allow('index');
    }

    /**
     * Index method : first page
     */
    public function index() {
        
    }

    /**
     * Fighter page
     */
    public function fighter() {
        // Find logged player's fighter
        $playerFighter = $this->Fighter->findByPlayerId($this->Auth->user());

        if ($this->request->is('post')) {
            // Create
            if (isset($this->request->data['Fighter']['name'])) {
                $this->Fighter->doCreate($this->Auth->user(),
                        $this->request->data['Fighter']['name']);
                $playerFighter = $this->Fighter->findByPlayerId($this->Auth->user());
            }
            // Upload avatar
            else if (isset($this->request->data['Fighteruploadavatar']['file'])) {
                $filename = $this->request->data['Fighteruploadavatar']['file']['tmp_name'];
                $destination = WWW_ROOT . DS . 'img' . DS . 'avatar' . DS . $playerFighter['Fighter']['id'];
                if (move_uploaded_file($filename, $destination)) {
                    $this->Flash->success('The avatar has been uploaded.');
                } else {
                    $this->Flash->error('The avatar could not be uploaded. Please, try again.');
                }
            }
            // Level up
            else if (isset($this->request->data['Fighterlevelup']['skill'])) {
                if ($this->Fighter->doLevelUp($playerFighter['Fighter']['id'],
                                $this->request->data['Fighterlevelup']['skill'])) {
                    $this->Flash->success('Successful level up.');
                } else {
                    $this->Flash->error('Level up failed.');
                }
            }
        }

        // Set variables to use inside view
        $this->set('fighter', $playerFighter);
        if (!empty($playerFighter['Fighter']['id']) && file_exists(WWW_ROOT . DS . 'img' . DS . 'avatar' . DS . $playerFighter['Fighter']['id'])) {
            $this->set('avatar', 'avatar' . DS . $playerFighter['Fighter']['id']);
        }
    }

    /**
     * Sight page
     */
    public function sight() {
        // Get player's fighter
        $playerFighter = $this->Fighter->findByPlayerId($this->Auth->user());

        if (!empty($playerFighter)) {
            if ($this->request->is('post')) {
                // Move
                if (isset($this->request->data['Fightermove']['direction'])) {
                    if ($this->Fighter->doMove($playerFighter['Fighter']['id'],
                                    $this->request->data['Fightermove']['direction'])) {
                        $this->Flash->success('Successful move.');
                    } else {
                        $this->Flash->error('Move failed.');
                    }
                }
                // Attack
                else if (isset($this->request->data['Fighterattack']['direction'])) {
                    if ($this->Fighter->doAttack($playerFighter['Fighter']['id'],
                                    $this->request->data['Fighterattack']['direction'])) {
                        $this->Flash->success('Successful attack.');
                    } else {
                        $this->Flash->error('Attack failed.');
                    }
                }
            }

            // Update of player's fighter
            $playerFighter = $this->Fighter->findByPlayerId($this->Auth->user());

            // Map of the arena
            $map = array();
            $height = Configure::read('Arena.height');
            $width = Configure::read('Arena.width');
            for ($row = $height - 1; $row >= 0; $row--) {
                for ($col = 0; $col < $width; $col++) {
                    // If position is within sight
                    if ($this->Fighter->isWithinSight($playerFighter['Fighter']['id'],
                                    $col, $row)) {
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
                                // If position is vacant
                            } else {
                                if (($row + $col) % 2 == 0) {
                                    $map[$row][$col] = 'map' . DS . 'even.png';
                                } else {
                                    $map[$row][$col] = 'map' . DS . 'odd.png';
                                }
                            }
                        }
                    }
                    // If position is not within sight
                    else {
                        $map[$row][$col] = 'map' . DS . 'invisible.png';
                    }
                }
            }
            $this->set('map', $map);
            $this->set('playerFighter', $playerFighter);
        }
        $this->set('fighters', $this->Fighter->find('all'));
    }

    /**
     * Diary page
     */
    public function diary() {
        // Get player's fighter
        $playerFighter = $this->Fighter->findByPlayerId($this->Auth->user());

        if (!empty($playerFighter)) {
            // Get events within 24h
            $events = $this->Event->getEventsWithin24h();
            // Remove events which are not in fighter's sight
            foreach ($events as $key => $event) {
                if (!$this->Fighter->isWithinSight($playerFighter['Fighter']['id'], $event['Event']['coordinate_x'],
                                $event['Event']['coordinate_y'])) {
                    unset($events[$key]);
                }
            }

            $this->set('events', $events);
        }
    }

}
