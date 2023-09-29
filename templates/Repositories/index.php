<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Repository> $repositories
 */
?>
<div class="repositories index content">
    <?= $this->Html->link(__('New Repository'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Repositories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('forks') ?></th>
                    <th><?= $this->Paginator->sort('open_issues') ?></th>
                    <th><?= $this->Paginator->sort('external_ident') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repositories as $repository): ?>
                <tr>
                    <td><?= $this->Number->format($repository->id) ?></td>
                    <td><?= h($repository->name) ?></td>
                    <td><?= h($repository->url) ?></td>
                    <td><?= $this->Number->format($repository->forks) ?></td>
                    <td><?= $this->Number->format($repository->open_issues) ?></td>
                    <td><?= $this->Number->format($repository->external_ident) ?></td>
                    <td><?= h($repository->created) ?></td>
                    <td><?= h($repository->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $repository->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $repository->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $repository->id], ['confirm' => __('Are you sure you want to delete # {0}?', $repository->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
