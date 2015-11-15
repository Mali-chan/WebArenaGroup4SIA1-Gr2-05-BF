<?php $this->assign('title', 'Diary'); ?>

<?php
    if (!empty($events)) {
?>
    <table class="table table-hover">
        <?php
            echo $this->Html->tableHeaders(array('Date', 'Description', 'Coordinate x', 'Coordinate y'), array('class' => 'active'));
            foreach ($events as $event) {
                echo $this->Html->tableCells(array(array($event['Event']['date'], $event['Event']['name'], $event['Event']['coordinate_x'], $event['Event']['coordinate_y'])));
            }
        ?>
    </table>
<?php
    }
