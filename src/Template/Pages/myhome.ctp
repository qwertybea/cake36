<?php
$urlToDocumentsAutocomplete = $this->Url->build([
    "controller" => "Documents",
    "action" => "findDocuments",
    "_ext" => "json"
        ]);
$searchUrl = $this->Url->build([
    "controller" => "Documents",
    "action" => "search",
    "?" => ["term" => "_term_goes_here_"]
        ]);
echo $this->Html->scriptBlock('var urlToAutocompleteAction = "' . $urlToDocumentsAutocomplete . '";', ['block' => true]);
echo $this->Html->scriptBlock('var searchUrl = "' . $searchUrl . '";', ['block' => true]);
echo $this->Html->script(['Documents/autocompletebyname', 'Documents/searchbar'], ['block' => 'scriptBottom']);
?>

<div class="row">
    <h2>Story city</h2>
    <p><?= __('Story city is a site where you can create original content publish it for the world to enjoy.'); ?></p>
    

    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['controller' => 'documents','action' => 'search'], 'class' => 'search']) ?>
    <fieldset>
        <?php
            echo $this->Form->control(null, ['name' => 'search_term', 'id' => 'autocomplete', 'placeholder' => __('search a document')]);
        ?>
        <?= $this->Form->button('<i class="fa fa-search"></i>', ['class' => 'button']) ?>
    </fieldset>
    <?= $this->Form->end() ?>
    
    <div class="columns large-6">
        <h4><?= __('New stories'); ?></h4>
        <ul>
            <?php
            foreach ($new_docs as $doc) {
                // debug($doc);
                $doc_name = ($doc['name']) ? mb_strimwidth($doc['name'], 0, 15, "...") : 'Untitled';
                $user_name = mb_strimwidth($doc->user['username'], 0, 15, "...");
                echo $this->Html->link(__('<span style="font-size: 1.3em">{0}</span> <span style="color: grey">by {1}</span>', $doc_name, $user_name), array('controller' => 'Documents', 'action' => 'view', $doc['id']), array('escape' => false));
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
        <h4><?= __('Most viewed stories'); ?></h4>
        <?php
            foreach ($popular_docs as $interaction) {
                $doc = $interaction->document;
                $user = $doc->user;
                $doc_name = ($doc['name']) ? mb_strimwidth($doc['name'], 0, 15, "...") : 'Untitled';
                $user_name = mb_strimwidth($user['username'], 0, 15, "...");
                echo $this->Html->link(__('<span style="font-size: 1.3em">{0}</span> <span style="color: grey">by {1} with {2} views</span>', $doc_name, $user_name, $interaction['views']), array('controller' => 'Documents', 'action' => 'view', $doc['id']), array('escape' => false));
                echo '<br>';
            }
            ?>
    </div>
    <hr />
</div>