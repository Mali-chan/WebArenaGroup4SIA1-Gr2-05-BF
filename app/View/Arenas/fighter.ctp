<?php
    pr($fighters);
    
    echo $this->Form->create('Fighterlevelup');
    echo $this->Form->input('skill', array('options' => array('sight' => 'sight + 1', 'strength' => 'strength + 1', 'health' => 'health + 3'), 'default' => 'strength'));
    echo $this->Form->end('Level up');
?>
