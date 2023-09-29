<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Repository $repository
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $repository->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $repository->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Repositories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="repositories form content">
            <?= $this->Form->create($repository) ?>
            <fieldset>
                <legend><?= __('Edit Repository') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('url');
                    echo $this->Form->control('forks');
                    echo $this->Form->control('open_issues');
                    echo $this->Form->control('external_ident');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
