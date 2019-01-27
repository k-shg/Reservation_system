<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->create($user) ?>
        <fieldset>
            <table class="table table-striped table-bordered" >
                <tbody>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?=  $this->Form->control('name',['label'=>false]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= $this->Form->control('email',['label'=>false]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Password') ?></th>
                        <td><?= $this->Form->control('password',['label'=>false]) ?></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?= $this->Form->button(__('Add'), ['class' => 'btn btn-info']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
