<h1>予約一覧</h1>
<?php
    if(!$reservations){
        echo __('Now, no reservation')."<br><br>";
    }else {
        echo $this->Session->read('Auth.User.name').__('Mr')."<br><br>";
    }?>

<?= $this->Html->link(__('Add Reservation'), ['action' => 'add'],['class' => 'btn btn-primary', 'role' => 'button']) ?>

<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th><?=__('Reservation Number')?></th>
            <th><?=__('Start Time')?></th>
            <th><?=__('End Time')?></th>
            <th><?=__('Body')?></th>
            <th><?=__('Created')?></th>
            <th><?=__('Operation')?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <?php
            if($reservation->isColor === true) {
                echo '<tr class="table-color">';
            }else {
                echo '<tr>';
            }
            ?>
            <td>
                <?= $this->Html->link($reservation->id, ['action' => 'view', $reservation->id]) ?>
            </td>
            <td>
                <?= $reservation->start_time->format('Y-m-d H:i:s') ?>
            </td>
            <td>
                <?= $reservation->end_time->format('Y-m-d H:i:s') ?>
            </td>
            <td>
                <?= nl2br($reservation->body) ?>
            </td>
            <td>
                <?= $reservation->created ?>
            </td>
            <td>
                <?= $this->Html->link(__('View'), ['action' => 'view', $reservation->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reservation->id]) ?>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $reservation->id],
                    ['confirm' => __('Are you ok?')])?>
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
