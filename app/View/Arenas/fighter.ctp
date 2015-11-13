<?php
    pr($fighter);
    
    // If player's fighter is dead, suggest creating a new fighter
    if (empty($fighter)) {
        echo $this->Form->create('Fighter');
        echo $this->Form->input('name', array('label' => 'Name'));
        echo $this->Form->end('Create');
    }
    // Else, if player's fighter is not dead
    else {
        // Display fighter's avatar
        if (!empty($avatar)) {
            echo $this->Html->image($avatar);
        }
        
        // Suggest to upload fighter's avatar
        echo $this->Form->create('Fighteruploadavatar', array('type' => 'file'));
        echo $this->Form->file('file');
        echo $this->Form->end('Upload');
        
        // Suggest to level up fighter's skill
        echo $this->Form->create('Fighterlevelup');
        echo $this->Form->input('skill', array('options' => array('sight' => 'sight + 1', 'strength' => 'strength + 1', 'health' => 'health + 3'), 'default' => 'strength'));
        echo $this->Form->end('Level up');
    }
?>
