<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TextDocument $textDocument
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Text Document'), ['action' => 'edit', $textDocument->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Text Document'), ['action' => 'delete', $textDocument->id], ['confirm' => __('Are you sure you want to delete # {0}?', $textDocument->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Text Documents'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Text Document'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="textDocuments view large-9 medium-8 columns content">
    <h3><?= h($textDocument->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($textDocument->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Text') ?></h4>
        <?= $this->Text->autoParagraph(h($textDocument->text)); ?>
    </div>
</div>
