<?php
use App\Model\Entity\User;
?>

<h3><?= __('Users') ?></h3>
<?= $this->Html->link('ユーザー追加', ['action' => 'add'],['class' => 'btn btn-primary', 'role' => 'button']) ?>

<table class="table table-hover table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col"><?= $this->Paginator->sort(__('User Number')) ?></th>
            <th scope="col"><?= $this->Paginator->sort('role') ?></th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('email') ?></th>
            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
            <th scope="col"><?= $this->Paginator->sort(__('State')) ?></th>
            <th scope="col" class="actions"><?= __('Operation') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $this->Number->format($user->id) ?></td>
            <td>
                <?php
                if($user->role == User::ADMIN){
                    echo __("Manager");
                }elseif($user->role == User::NORMAL){
                    echo __("Normal");
                }
                ?>
            <td><?= h($user->name) ?></td>
            </td>
            <td><?= h($user->email) ?></td>
            <td><?= h($user->created->format('Y-m-d H:i:s'))?></td>
            <td><?= h($user->modified->format('Y-m-d H:i:s'))?></td>
            <td>
                <?php
                if($user->stop === true) {
                    echo __("Stop");
                }
                ?>
            </td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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
