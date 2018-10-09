<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */

?>

<div class="documents form large-6 medium-8 columns content">
	<p><?php echo __('Your account has not been verified yet. You will not be able to create new content.'); ?></p>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Send me another email') ?></legend>
        <?php
            echo $this->Form->control('sendit', ['type' => 'hidden']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
