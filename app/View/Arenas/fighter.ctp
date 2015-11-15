<?php $this->assign('title', 'Fighter'); ?>

<?php    
    // If player's fighter is dead, suggest creating a new fighter
    if (empty($fighter)) {
        echo $this->Form->create('Fighter', array('class' => 'form-inline', 'inputDefaults' => array('div' => 'form-group', 'class' => 'form-control')));
        echo $this->Form->input('name', array('placeholder' => 'Name'));
        echo $this->Form->submit('Create', array('div' => 'form-group', 'class' => 'btn btn-default'));
        echo $this->Form->end();
    }
    // Else, if player's fighter is not dead
    else {
?>
<div class="row">
    <div id="fighter_avatar" class="col-lg-2">
<?php
        // Display fighter's avatar
        if (!empty($avatar)) {
            echo $this->Html->image($avatar, array('class' => 'img-responsive'));
        }
?>
    </div>
    <div class="col-lg-10">
        <table class="table table-hover">
            <?php
                echo $this->Html->tableHeaders(array('Name', 'Coordinate x', 'Coordinate y', 'Level', 'Xp', 'Sight skill', 'Strength skill', 'Health skill', 'Current health'), array('class' => 'active'));
                echo $this->Html->tableCells(array(array($fighter['Fighter']['name'], $fighter['Fighter']['coordinate_x'], $fighter['Fighter']['coordinate_y'], $fighter['Fighter']['level'], $fighter['Fighter']['xp'], $fighter['Fighter']['skill_sight'], $fighter['Fighter']['skill_strength'], $fighter['Fighter']['skill_health'], $fighter['Fighter']['current_health'])));
            ?>
        </table>
    </div>
</div>
<div class="row">
<?php 
        // Suggest to upload fighter's avatar
        echo $this->Form->create('Fighteruploadavatar', array('class' => 'form-inline', 'type' => 'file', 'inputDefaults' => array('div' => 'form-group', 'class' => 'form-control')));
        echo $this->Form->file('file', array('div' => 'form-group', 'class' => 'form-control'));
        echo $this->Form->submit('Upload avatar', array('div' => 'form-group', 'class' => 'btn btn-default'));
        echo $this->Form->end();
        
        // Suggest to level up fighter's skill
        echo $this->Form->create('Fighterlevelup', array('class' => 'form-inline', 'type' => 'file', 'inputDefaults' => array('div' => 'form-group', 'class' => 'form-control', 'label' => false)));
        echo $this->Form->input('skill', array('options' => array('sight' => 'sight + 1', 'strength' => 'strength + 1', 'health' => 'health + 3'), 'default' => 'strength', 'div' => 'form-group'));
        echo $this->Form->submit('Level up', array('div' => 'form-group', 'class' => 'btn btn-default'));
        echo $this->Form->end();
    }
?>
</div>
