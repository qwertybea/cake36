<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Documents'), ['controller' => 'Documents', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Document'), ['controller' => 'Documents', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Interactions'), ['controller' => 'Interactions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Interaction'), ['controller' => 'Interactions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Documents') ?></h4>
        <?php if (!empty($user->documents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Type Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <th scope="col"><?= __('Other Details') ?></th>
                <th scope="col"><?= __('Document Cover') ?></th>
                <th scope="col"><?= __('Published') ?></th>
                <th scope="col"><?= __('Deleted') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->documents as $documents): ?>
            <tr>
                <td><?= h($documents->id) ?></td>
                <td><?= h($documents->type_id) ?></td>
                <td><?= h($documents->user_id) ?></td>
                <td><?= h($documents->name) ?></td>
                <td><?= h($documents->description) ?></td>
                <td><?= h($documents->other_details) ?></td>
                <td><?= h($documents->document_cover) ?></td>
                <td><?= h($documents->published) ?></td>
                <td><?= h($documents->deleted) ?></td>
                <td><?= h($documents->created) ?></td>
                <td><?= h($documents->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $documents->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Documents', 'action' => 'edit', $documents->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Documents', 'action' => 'delete', $documents->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documents->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Interactions') ?></h4>
        <?php if (!empty($user->interactions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Document Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('InteractiveMethod Id') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->interactions as $interactions): ?>
            <tr>
                <td><?= h($interactions->document_id) ?></td>
                <td><?= h($interactions->user_id) ?></td>
                <td><?= h($interactions->interactiveMethod_id) ?></td>
                <td><?= h($interactions->created) ?></td>
                <td><?= h($interactions->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Interactions', 'action' => 'view', $interactions->document_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Interactions', 'action' => 'edit', $interactions->document_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Interactions', 'action' => 'delete', $interactions->document_id], ['confirm' => __('Are you sure you want to delete # {0}?', $interactions->document_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
