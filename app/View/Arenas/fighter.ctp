<?php
    pr($fighter);
    
    // If player has no more fighter, suggest creating a new fighter
    if (empty($fighter)) {
        echo $this->Form->create('Fighter');
        echo $this->Form->input('name', array('label' => 'Name'));
        echo $this->Form->end('Create');
    }
    // Else, suggest to level up skill
    else {
        echo $this->Form->create('Fighterlevelup');
        echo $this->Form->input('skill', array('options' => array('sight' => 'sight + 1', 'strength' => 'strength + 1', 'health' => 'health + 3'), 'default' => 'strength'));
        echo $this->Form->end('Level up');
    }
?>
