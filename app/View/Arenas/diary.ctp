<?php
    if (!empty($events)) {
?>
    <table>
        <?php
            echo $this->Html->tableHeaders(array('Date', 'Description', 'Coordinate x', 'Coordinate y'));
            foreach ($events as $event) {
                echo $this->Html->tableCells(array(array($event['Event']['date'], $event['Event']['name'], $event['Event']['coordinate_x'], $event['Event']['coordinate_y'])));
            }
        ?>
    </table>
<?php
    }
