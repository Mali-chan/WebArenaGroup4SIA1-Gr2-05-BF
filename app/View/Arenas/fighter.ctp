<?php    
    // If player's fighter is dead, suggest creating a new fighter
    if (empty($fighter)) {
        echo $this->Form->create('Fighter');
        echo $this->Form->input('name', array('label' => 'Name'));
        echo $this->Form->end('Create');
    }
    // Else, if player's fighter is not dead
    else {
?>        
    <table>
        <?php
            echo $this->Html->tableHeaders(array('Name', 'Coordinate x', 'Coordinate y', 'Level', 'Xp', 'Sight skill', 'Strength skill', 'Health skill', 'Current health'));
            echo $this->Html->tableCells(array(array($fighter['Fighter']['name'], $fighter['Fighter']['coordinate_x'], $fighter['Fighter']['coordinate_y'], $fighter['Fighter']['level'], $fighter['Fighter']['xp'], $fighter['Fighter']['skill_sight'], $fighter['Fighter']['skill_strength'], $fighter['Fighter']['skill_health'], $fighter['Fighter']['current_health'])));
        ?>
    </table>
<?php 
        // Display fighter's avatar
        if (!empty($avatar)) {
            echo $this->Html->image($avatar);
        }
        
        // Suggest to upload fighter's avatar
        echo $this->Form->create('Fighteruploadavatar', array('type' => 'file'));
        echo $this->Form->file('file');
        echo $this->Form->end('Upload avatar');
        
        // Suggest to level up fighter's skill
        echo $this->Form->create('Fighterlevelup');
        echo $this->Form->input('skill', array('options' => array('sight' => 'sight + 1', 'strength' => 'strength + 1', 'health' => 'health + 3'), 'default' => 'strength'));
        echo $this->Form->end('Level up');
    }
?>
