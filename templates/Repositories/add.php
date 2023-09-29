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
            <?= $this->Html->link(__('List Repositories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="repositories form content">
            <?= $this->Form->create($repository) ?>
            <fieldset>
                <legend><?= __('Add Repository') ?></legend>
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
