<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Documents'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Document Types'), ['controller' => 'DocumentTypes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Document Type'), ['controller' => 'DocumentTypes', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Interactions'), ['controller' => 'Interactions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Interaction'), ['controller' => 'Interactions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="documents form large-9 medium-8 columns content">
    <?= $this->Form->create($document) ?>
    <fieldset>
        <legend><?= __('Add Document') ?></legend>
        <?php
            echo $this->Form->control('type_id', ['options' => $documentTypes]);
            echo $this->Form->control('user_id', ['options' => $users]);
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('other_details');
            echo $this->Form->control('document_cover');
            echo $this->Form->control('published');
            echo $this->Form->control('deleted');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
