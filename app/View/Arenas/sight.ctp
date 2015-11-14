<?php
    pr($fighters);

    foreach ($map as $row) {
        foreach ($row as $col) {
            echo $this->Html->image($col);
        }
        echo '<br>';
    }
    
    echo $this->Form->create('Fightermove');
    echo $this->Form->input('direction', array('options' => array('north' => 'north', 'east' => 'east', 'south' => 'south', 'west' => 'west'), 'default' => 'east'));
    echo $this->Form->end('Move');

    echo $this->Form->create('Fighterattack');
    echo $this->Form->input('direction', array('options' => array('north' => 'north', 'east' => 'east', 'south' => 'south', 'west' => 'west'), 'default' => 'east'));
    echo $this->Form->end('Attack');
?>
