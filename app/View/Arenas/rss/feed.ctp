<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->set('channelData', array(
    'title' => __("Most Recent Events"),
    'link' => $this->Html->url(array("controller"=>"arenas","action"=>"index"); , true),
    'description' => __("Most recent events."),
    'language' => fr-fr
));
foreach ($events as $event) {
    $eventTime = strtotime($event['Event']['created']);
 
    $postLink = array(
        'controller' => 'arenas',
        'action' => 'index',
        'year' => date('Y', $eventTime),
        'month' => date('m', $eventTime),
        'day' => date('d', $eventTime),
        $event['Event']['slug']
    );
 
    // Remove & escape any HTML to make sure the feed content will validate.
    $bodyText = h(strip_tags($post['Event']['body']));
    $bodyText = $this->Text->truncate($bodyText, 400, array(
        'ending' => '...',
        'exact'  => true,
        'html'   => true,
    ));
 
    echo  $this->Rss->item(array(), array(
        'title' => $post['Event']['title'],
        'link' => $eventLink,
        'guid' => array('url' => $eventLink, 'isPermaLink' => 'true'),
        'description' => $bodyText,
        'pubDate' => $event['Event']['created']
    ));
}

