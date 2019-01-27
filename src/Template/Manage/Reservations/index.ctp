<?= $this->Html->script('jquery-sortable-min.js') ?>

<style>
    body.dragging, body.dragging * {
      cursor: move !important;
    }
    .dragged {
      position: absolute;
      opacity: 0.5;
      z-index: 2000;
    }
    tr.placeholder {
        position: relative;
        height: 2em;
        width: 100%;
    }
    tr.placeholder:before {
        position: absolute;
    /** Define arrowhead **/
    }

    .sort-handler {
        cursor: pointer;
    }

</style>

<script>
$(function () {
    var origTdWidths = {};

    $('.sorted-table').sortable({
        containerSelector: 'table',
        itemPath: '> tbody',
        itemSelector: 'tr',
        handle: 'span.glyphicon.glyphicon-move.sort-handler',
        placeholder: '<tr class="placeholder"/>',
        onDragStart: function ($item, container, _super) {
            _super($item, container);
            $item.children().each(function (index) {
                $(this).width(origTdWidths[index]);
            });
        },
        onMousedown: function ($item, _super, event) {
            $item.children().each(function (index) {
                origTdWidths[index] = $(this).width();
            });
            return _super($item, this, event);
        }
    });

    $('.form-submit').submit(function() {
        var serialize = $('.sorted-table').sortable('serialize').get()[0];
        var json = JSON.stringify(serialize);
        $('button[name="sort_order_json"]').val(json);
        return true;
    });
});
</script>

<h1>予約一覧</h1>
<?php
    echo $this->Form->create(null);
    echo $this->Form->label(__('User'));
    echo $this->Form->select('user_id', $users, ["id" => "select", 'empty' => true]);
    echo $this->Form->button(__('Search Reservation'),['class' => 'btn btn-info']);
    echo $this->Form->end();
?>
<br>
<?= $this->Html->link(__('Add Reservation'), ['action' => 'add'], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
<div style="margin-top:0.5em;">
    <?= $this->Form->postButton(
        __('Save Priority'),
        ['controller' => 'Reservations', 'action' => 'saveOrder'],
        ['form' => ['class' => 'form-submit'], 'class' => 'btn btn-primary', 'name'=>'sort_order_json']) ?>
</div>

<table class="table table-hover table-striped sorted-table">
    <thead>
        <tr>
            <th><?=__('Priority')?></th>
            <th><?=__('Reservation Number')?></th>
            <th><?=__('Reserver')?></th>
            <th><?=__('Start Time')?></th>
            <th><?=__('End Time')?></th>
            <th><?=__('Body')?></th>
            <th><?=__('Created')?></th>
            <th><?=__('Modified')?></th>
            <th><?=__('Operation')?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($reservations as $reservation): ?>
            <?php
            if($reservation->isColor === true) {
                $class ='class = table-color';
            } else {
                $class = '';
            }
            ?>
        <tr <?= $class ?> data-id = "<?= $reservation->id ?>" >
            <td><span class="glyphicon glyphicon-move sort-handler"></span></td>
            <td>
                <?= $this->Html->link($reservation->id, ['action' => 'view', $reservation->id]) ?>
            </td>
            <td>
                <?= $this->Html->link($reservation->user->name, ['controller' => 'users', 'action' => 'view', $reservation->id]) ?>
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
                <?= $reservation->created->format('Y-m-d H:i:s') ?>
            </td>
            <td>
                <?= $reservation->modified->format('Y-m-d H:i:s') ?>
            </td>
            <td>
                <?= $this->Html->link(__('View'), ['action' => 'view', $reservation->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reservation->id]) ?>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $reservation->id],
                    ['confirm' => __('Are you ok?')])
                    ?>
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
