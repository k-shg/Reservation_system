<div class="col-md-8 col-md-offset-2">
    <legend><?= __('Add Reservation') ?></legend>
    <?php $this->Form->templates(['dateWidget' => '{{year}}-{{month}}-{{day}} {{hour}}:{{minute}}']); ?>
    <?= $this->Form->create($reservation) ?>
    <fieldset>
        <table class="table table-striped table-bordered" >
            <tbody>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= $this->Form->control('start_time', [
                        'label'=> false,
                        'orderYear'=>'asc',
                        'monthNames' => false,
                        'month'=>['leadingZeroValue' => true],
                        'day'=>['leadingZeroValue' => true],
                        'hour'=>['leadingZeroValue' => true],
                        'minute'=>['leadingZeroValue' => true]
                    ]); ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?=  $this->Form->control('end_time', [
                        'label'=> false,
                        'orderYear'=>'asc',
                        'monthNames' => false,
                        'month'=>['leadingZeroValue' => true],
                        'day'=>['leadingZeroValue' => true],
                        'hour'=>['leadingZeroValue' => true],
                        'minute'=>['leadingZeroValue' => true]
                    ]); ?></td>
                </tr>
                <tr>
                    <th><?= __('Body') ?></th>
                    <td><?= $this->Form->textarea('body', ['class' => 'col-sm-12']); ?></td>
                </tr>
            </tbody>
        </table>
    </fieldset>
    <?= $this->Form->button(__('Add'), ['class' => 'btn btn-info']) ?>
    <?= $this->Form->end() ?>
</div>
