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
            <?= $this->Html->link(__('Edit Repository'), ['action' => 'edit', $repository->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Repository'), ['action' => 'delete', $repository->id], ['confirm' => __('Are you sure you want to delete # {0}?', $repository->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Repositories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Repository'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="repositories view content">
            <h3><?= h($repository->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($repository->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($repository->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($repository->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Forks') ?></th>
                    <td><?= $this->Number->format($repository->forks) ?></td>
                </tr>
                <tr>
                    <th><?= __('Open Issues') ?></th>
                    <td><?= $this->Number->format($repository->open_issues) ?></td>
                </tr>
                <tr>
                    <th><?= __('External Ident') ?></th>
                    <td><?= $this->Number->format($repository->external_ident) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($repository->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($repository->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Branches') ?></h4>
                <?php if (!empty($repository->branches)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Repository Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($repository->branches as $branches) : ?>
                        <tr>
                            <td><?= h($branches->id) ?></td>
                            <td><?= h($branches->name) ?></td>
                            <td><?= h($branches->repository_id) ?></td>
                            <td><?= h($branches->created) ?></td>
                            <td><?= h($branches->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Branches', 'action' => 'view', $branches->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Branches', 'action' => 'edit', $branches->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Branches', 'action' => 'delete', $branches->id], ['confirm' => __('Are you sure you want to delete # {0}?', $branches->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
