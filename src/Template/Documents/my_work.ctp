<?php 
// debug($documents);
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        
        <?php foreach ($documentTypes as $type): ?>
            <li>
                <?= $this->Html->link(__('New {0} document', $type['type']), ['controller' => 'Documents', 'action' => 'add', $type->id]) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="documents index large-9 medium-8 columns content">
    <h3><?= __('Documents') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('type_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('user_id', 'Author') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('other_details') ?></th> -->
                <th scope="col"><?= $this->Paginator->sort('document_cover') ?></th>
                <th scope="col"><?= $this->Paginator->sort('published') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
            <!-- <?php debug($document); ?> -->
            <tr>
                <td><?= $document->has('document_type') ? $document->document_type->type : '' ?></td>
                <td><?= $document->has('user') ? $this->Html->link($document->user->username, ['controller' => 'Users', 'action' => 'view', $document->user->id]) : '' ?></td>
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
                        echo __('No cover');
                    }
                    ?>

                </td>
                <td><?= $document->published ? __('Yes') : __('No'); ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $document->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>