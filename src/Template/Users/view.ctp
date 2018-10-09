<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
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
</nav> -->
<div class="columns"> </div>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->username) ?></h3>
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
            <th scope="row"><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Documents') ?></h4>
        <?php if (!empty($user->documents)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Type') ?></th>
                <!-- <th scope="col"><?= __('User') ?></th> -->
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Description') ?></th>
                <!-- <th scope="col"><?= __('Other Details') ?></th> -->
                <th scope="col"><?= __('Document Cover') ?></th>
                <?php echo ($has_rights) ? '<th scope="col">Published</th>' : ''; ?>
                <th scope="col"><?= __('Created') ?></th>
                <!-- <th scope="col"><?= __('Modified') ?></th> -->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php 
            if ($has_rights) {
                foreach ($user->documents as $document): 
            ?>
                <tr>
                    <td><?= h($document->document_type->type) ?></td>
                    <!-- <td><?= h($user->username) ?></td> -->
                    <td><?= h($document->name) ?></td>
                    <td><?= h($document->description) ?></td>
                    <!-- <td><?= h($document->other_details) ?></td> -->

                    <td>
                        <?php
                        if ($document->file->status) {
                            echo $this->Html->image($document->file->path . $document->file->name, [
                                "alt" => $document->file->name,
                                "width" => "220px",
                                "height" => "150px",
                                'url' => ['controller' => 'Documents', 'action' => 'view', $document->id]
                            ]);
                        } else {
                            echo 'No cover';
                        }
                        ?>
                    </td>

                    <td><?= $document->published ? __('Yes') : __('No'); ?></td>
                    <td><?= h($document->created) ?></td>
                    <!-- <td><?= h($document->modified) ?></td> -->
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $document->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['controller' => 'Documents', 'action' => 'edit', $document->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'Documents', 'action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
                    </td>
                </tr>
            <?php
                endforeach;
            } else {
                foreach ($user->documents as $document): 
                    if ($document->published) { 
                ?>
                        <tr>
                            <td><?= h($document->document_type->type) ?></td>
                            <!-- <td><?= h($user->username) ?></td> -->
                            <td><?= h($document->name) ?></td>
                            <td><?= h($document->description) ?></td>
                            <!-- <td><?= h($document->other_details) ?></td> -->

                            <td>
                                <?php
                                if ($document->file->status) {
                                    echo $this->Html->image($document->file->path . $document->file->name, [
                                        "alt" => $document->file->name,
                                        "width" => "220px",
                                        "height" => "150px",
                                        'url' => ['controller' => 'Documents', 'action' => 'view', $document->id]
                                    ]);
                                } else {
                                    echo 'No cover';
                                }
                                ?>
                            </td>

                            <td><?= h($document->created) ?></td>
                            <!-- <td><?= h($document->modified) ?></td> -->
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Documents', 'action' => 'view', $document->id]) ?>
                            </td>
                        </tr>
            <?php
                    }
                endforeach;
            } // endif
            ?>
        </table>
        <?php endif; ?>
    </div>
</div>
