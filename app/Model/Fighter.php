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
     * Creates a new fighter for the player
     * @param type $playerId
     * @param type $name
     */
    public function doCreate($playerId, $name) {
        // Generate coordinates until position is vacant
        do {
            $coordinate_x = randCoordinateX();
            $coordinate_y = randCoordinateY();
            $fighter = $this->findByCoordinate_xAndCoordinate_y($coordinate_x,
                    $coordinate_y);
        } while (!empty($fighter));

        // Create new fighter
        $this->create(array(
            'name' => $name,
            'player_id' => $playerId,
            'coordinate_x' => $coordinate_x,
            'coordinate_y' => $coordinate_y,
            'level' => 0,
            'xp' => 0,
            'skill_sight' => 2,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 3,
            'next_action_time' => '0000-00-00 00:00:00'));
        $this->save();
    }

    /**
     * Moves fighter to one direction
     * @param type $fighterId
     * @param type $direction
     * @return boolean
     */
    public function doMove($fighterId, $direction) {
        // Set current model to edit
        $fighterToMove = $this->read(array(
            'coordinate_x',
            'coordinate_y'), $fighterId);

        // Initialize new coordinates with current position
        $new_coordinate_x = $fighterToMove['Fighter']['coordinate_x'];
        $new_coordinate_y = $fighterToMove['Fighter']['coordinate_y'];

        // Compute new coordinates
        switch ($direction) {
            case 'north':
                $new_coordinate_y = $new_coordinate_y + 1;
                break;
            case 'south':
                $new_coordinate_y = $new_coordinate_y - 1;
                break;
            case 'east':
                $new_coordinate_x = $new_coordinate_x + 1;
                break;
            case 'west':
                $new_coordinate_x = $new_coordinate_x - 1;
                break;
            default:
                return false;
        }

        // If new position is not within arena bounds, do not move fighter
        if (!isWithinArena($new_coordinate_x, $new_coordinate_y)) {
            return false;
        }

        // If new position is already occupied by another fighter, do not move fighter
        $fighterAtNewPosition = $this->findByCoordinate_xAndCoordinate_y($new_coordinate_x,
                $new_coordinate_y);
        if (!empty($fighterAtNewPosition)) {
            return false;
        }

        // Else, edit fighter's position
        $this->set('coordinate_x', $new_coordinate_x);
        $this->set('coordinate_y', $new_coordinate_y);
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

        // Look for a defender at given direction
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

        // If no defender found, no attack
        if (empty($defender)) {
            return false;
        }

        // Else, defender found, attack
        // If attacker's level is greater than defender's level, attacker has more probability to attack successfully
        if (rand(1, 20) < (10 + $defender['Fighter']['level'] - $attacker['Fighter']['level'])) {
            return false;
        }

        // Successful attack
        $xpWonByAttacker = 1;
        $defenderHealthAfterAttack = $defender['Fighter']['current_health'] - $attacker['Fighter']['skill_strength'];

        // If defender is dead, give extra xp to attacker and remove defender from the game
        if ($defenderHealthAfterAttack <= 0) {
            $xpWonByAttacker = $xpWonByAttacker + $defender['Fighter']['level'];
            $this->delete($defender['Fighter']['id']);
        }
        // Else, defender loses health points
        else {
            $this->read('current_health', $defender['Fighter']['id']);
            $this->set('current_health',
                    $defender['Fighter']['current_health'] - $attacker['Fighter']['skill_strength']);
            $this->save();
        }

        // Attacker gets xp
        $this->read('xp', $attacker['Fighter']['id']);
        $this->set('xp', $attacker['Fighter']['xp'] + $xpWonByAttacker);
        $this->save();

        return true;
    }

    /**
     * Levels skill up
     * @param type $fighterId
     * @param type $skill
     * @return boolean
     */
    public function doLevelUp($fighterId, $skill) {
        // Set current model to edit
        $fighterToLevelUp = $this->read(array(
            'level',
            'xp',
            'skill_sight',
            'skill_strength',
            'skill_health'), $fighterId);

        // Level up only if fighter has at least 4 xp
        if ($fighterToLevelUp['Fighter']['xp'] < 4) {
            return false;
        }

        // Edit skill
        switch ($skill) {
            case 'sight':
                $this->set('skill_sight',
                        $fighterToLevelUp['Fighter']['skill_sight'] + 1);
                break;
            case 'strength':
                $this->set('skill_strength',
                        $fighterToLevelUp['Fighter']['skill_strength'] + 1);
                break;
            case 'health':
                $this->set('skill_health',
                        $fighterToLevelUp['Fighter']['skill_health'] + 3);
                break;
            default:
                return false;
        }

        // Edit level
        $this->set('level', $fighterToLevelUp['Fighter']['level'] + 1);

        // Edit xp
        $this->set('xp', $fighterToLevelUp['Fighter']['xp'] - 4);

        // Save modification
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
        if (!isWithinArena($coordinate_x, $coordinate_y)) {
            return false;
        }
        $fighter = $this->findById($fighterId);
        // Compute Manhattan distance
        if (((abs($fighter['Fighter']['coordinate_x'] - $coordinate_x) + abs($fighter['Fighter']['coordinate_y'] - $coordinate_y)) > $fighter['Fighter']['skill_sight'])) {
            return false;
        }
        return true;
    }

}
