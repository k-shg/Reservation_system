<div class="col-md-8 col-md-offset-2">
    <legend><?=__('Reservation data')?></legend>
        <fieldset>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th scope="row"><?= __('Reservation Number') ?></th>
                        <td><?= h($reservation->id);  ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Start Time') ?></th>
                        <td><?= $reservation->start_time->format('Y-m-d H:i:s') ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('End Time') ?></th>
                        <td><?= $reservation->end_time->format('Y-m-d H:i:s') ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td>
                            <?=$reservation->created->format('Y-m-d H:i:s')?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td>
                            <?=$reservation->created->format('Y-m-d H:i:s')?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Body') ?></th>
                        <td><?= nl2br(h($reservation->body)) ?></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reservation->id], ['class' => 'btn btn-primary', 'role' => 'button']) ?>
</div>
