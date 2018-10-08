<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<?php if ($has_rights) { ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?> </li>
        <!-- <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Document Types'), ['controller' => 'DocumentTypes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document Type'), ['controller' => 'DocumentTypes', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Interactions'), ['controller' => 'Interactions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Interaction'), ['controller' => 'Interactions', 'action' => 'add']) ?> </li> -->
    </ul>
</nav>
<?php } ?>
<div class="documents view large-9 medium-8 columns content">
    <h3><?= h($document->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Document Type') ?></th>
            <td><?= $document->has('document_type') ? $document->document_type->type : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Author') ?></th>
            <td><?= $document->has('user') ? $this->Html->link($document->user->username, ['controller' => 'Users', 'action' => 'view', $document->user->id]) : '' ?></td>
        </tr>
        <!-- <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($document->name) ?></td>
        </tr> -->
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= h($document->description) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Other Details') ?></th>
            <td><?= h($document->other_details) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Document Cover') ?></th>
            <td><?= h($document->document_cover) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($document->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($document->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Published') ?></th>
            <td><?= $document->published ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h2>Content</h2>
        <?php 
        $text = $document['text_documents'][0]['text'];
        foreach(preg_split("/((\r?\n)|(\r\n?))/", $text) as $line){
            echo '<p>'.$line.'</p>';
        } 
        ?>
        
    </div>

    <hr>
    <div class="related">
        <table>
            <tr>
                <td>Viewed <?= $view_count ?> times</td>
            </tr>
        </table>
    </div>
</div>
