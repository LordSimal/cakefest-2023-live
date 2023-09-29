<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Branch $branch
 * @var \Cake\Collection\CollectionInterface|string[] $repositories
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Branches'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="branches form content">
            <?= $this->Form->create($branch) ?>
            <fieldset>
                <legend><?= __('Add Branch') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('repository_id', ['options' => $repositories]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
