<?php

?>

<div class="row">
	<h2>Stroy city</h2>
    <p>Story city is a site where you can create original content such as stories and publish them for the world to enjoy.</p>
    <div class="columns large-6">
        <h4>New stories</h4>
        <ul>
            <?php
            foreach ($new_docs as $doc) {
                $doc_name = ($doc['name']) ? $doc['name'] : 'Untitled';
                echo $this->Html->link(__(sprintf('<span style="font-size: 1.3em">%s</span> <span style="color: grey">by %s</span>', $doc_name, $doc->user['username'])), array('controller' => 'Documents', 'action' => 'view', $doc['id']), array('escape' => false));
                echo '<br>';
            }
            ?>
        </ul>
        <?= $this->Html->link(__('see all published stories'), array('controller' => 'Documents', 'action' => 'index')); ?>
        <?php
        $logUser = $this->request->session()->read('Auth.User');
        if ($logUser) {
            if ($logUser['role'] == "admin") {
                echo '<br />';
                echo $this->Html->link(__('All stories'), array('controller' => 'Documents', 'action' => 'viewAllDocuments'));
            }
        }
        ?>
    </div>
    <div class="columns large-6">
        <h4>Most viewed stories</h4>
        <?php
            foreach ($popular_docs as $interaction) {
                $doc = $interaction->document;
                $user = $interaction->user;
                $doc_name = ($doc['name']) ? $doc['name'] : 'Untitled';
                echo $this->Html->link(__(sprintf('<span style="font-size: 1.3em">%s</span> <span style="color: grey">by %s with %s views</span>', $doc_name, $user['username'], $interaction['views'])), array('controller' => 'Documents', 'action' => 'view', $doc['id']), array('escape' => false));
                echo '<br>';
            }
            ?>
    </div>
    <hr />
</div>