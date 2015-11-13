<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
$Home = __d('cake_dev', 'Home');
$Index = __d('cake_dev', 'Index');
$Fighter = __d('cake_dev', 'Fighter');
$Sight = __d('cake_dev', 'Sight');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
*/

?>
        
<!DOCTYPE html>
<html>
    <head>
    <?php echo $this->Html->charset(); ?>
        <title>
        <?php echo $Home ?>:
        <?php echo $this->fetch('Home'); ?>
        </title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('cake.generic');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        echo $scripts_for_layout;
    ?>
    </head>
    <body>
        <div id="container">
            <div id="header">
                <nav>
                    <ul>                      
                        <h1>
                            <?php echo $this->Html->link('Home', array('controller' => 'arenas', 'action' => 'index')); ?> 
                            <?php echo $this->Html->link('Fighter', array('controller' => 'arenas', 'action' => 'fighter')); ?> 
                            <?php echo $this->Html->link('Sight', array('controller' => 'arenas', 'action' => 'sight')); ?> 
                            <?php echo $this->Html->link('Diary', array('controller' => 'arenas', 'action' => 'diary')); ?>
                            <?php 
                                if (empty($authUser)) {
                                    echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'));
                                } else {
                                    echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout'));
                                }
                            ?>
                        </h1>
                    </ul>
                </nav>
            </div>

            <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('auth'); ?>
            <?php echo $this->fetch('content'); ?>
            </div>

            <div id="footer">
            <?php echo $this->Html->link(
                    $this->Html->image('cake.power.gif', array( 'border' => '0')),
                    'http://www.cakephp.org/',
                    array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
                );
            ?>
                <p>
                <?php echo "Team Project" ; ?>
                </p>
            </div>
        </div>
    <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
