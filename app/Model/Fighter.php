<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';
    public $recursive = 0;
    public $belongsTo = array(
        'Player' => array(
            'className' => 'Player',
            'foreignKey' => 'player_id',
        ),
        'Guild' => array(
            'className' => 'Guild',
            'foreignKey' => 'guild_id',
        ),
    );

    /**
     * Moves fighter to one direction
     * @param type $fighterId
     * @param type $direction
     * @return boolean
     * @todo check if new position is within arena bounds
     * @todo check if new position is not already occupied
     */
    public function doMove($fighterId, $direction) {
        // Set current model to edit
        $fighterToMove = $this->read(array(
            'coordinate_x',
            'coordinate_y'), $fighterId);

        // Edit position
        switch ($direction) {
            case 'north':
                $this->set('coordinate_y',
                        $fighterToMove['Fighter']['coordinate_y'] + 1);
                break;
            case 'south':
                $this->set('coordinate_y',
                        $fighterToMove['Fighter']['coordinate_y'] - 1);
                break;
            case 'east':
                $this->set('coordinate_x',
                        $fighterToMove['Fighter']['coordinate_x'] + 1);
                break;
            case 'west':
                $this->set('coordinate_x',
                        $fighterToMove['Fighter']['coordinate_x'] - 1);
                break;
            default:
                return false;
        }

        // Save modification
        $this->save();
        return true;
    }

    /**
     * Attacks in one direction
     * @param type $fighterId
     * @param type $direction
     * @return boolean
     */
    public function doAttack($fighterId, $direction) {
        // Set current model to attacker
        $attacker = $this->findById($fighterId);

        // Initialize defenser's position with attacker's
        $defender_coordinate_x = $attacker['Fighter']['coordinate_x'];
        $defender_coordinate_y = $attacker['Fighter']['coordinate_y'];

        // Look for a defender within fighter's sight
        $defender = array();

        do {
            switch ($direction) {
                case 'north':
                    $defender_coordinate_y = $defender_coordinate_y + 1;
                    break;
                case 'south':
                    $defender_coordinate_y = $defender_coordinate_y - 1;
                    break;
                case 'east':
                    $defender_coordinate_x = $defender_coordinate_x + 1;
                    break;
                case 'south':
                    $defender_coordinate_x = $defender_coordinate_x - 1;
                    break;
                default:
                    return false;
            }

            $defender = $this->findByCoordinate_xAndCoordinate_y($defender_coordinate_x,
                    $defender_coordinate_y);
        } while (empty($defender) && $this->isWithinSight($fighterId,
                $defender_coordinate_x, $defender_coordinate_y));

        // If no defender found within sight, no attack
        if (empty($defender) || !$this->isWithinSight($fighterId,
                        $defender_coordinate_x, $defender_coordinate_y)) {
            return false;
        }

        // Else, defender found, attack
        $this->read(null, $defender['Fighter']['id']);
        $this->set('current_health',
                $defender['Fighter']['current_health'] - $attacker['Fighter']['skill_strength']);
        $this->save();
        return true;
    }

    /**
     * Check if coordinates are within fighter's view
     * @param type $coordinate_x
     * @param type $coordinate_y
     * @return boolean
     */
    public function isWithinSight($fighterId, $coordinate_x, $coordinate_y) {
        $fighter = $this->findById($fighterId);
        if ((abs($fighter['Fighter']['coordinate_x'] - $coordinate_x) > $fighter['Fighter']['skill_sight']) ||
                (abs($fighter['Fighter']['coordinate_y'] - $coordinate_y) > $fighter['Fighter']['skill_sight'])) {
            return false;
        }
        return true;
    }

}
