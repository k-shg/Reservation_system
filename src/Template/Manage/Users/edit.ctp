<div class="container">
    <div class="col-md-8 col-md-offset-2">
        <legend><?= __('Edit User') ?></legend>
        <?= $this->Form->create($user) ?>
        <fieldset>
            <table class="table table-striped table-bordered" >
                <tbody>
                    <tr>
                        <th><?= __(__('User Number')) ?></th>
                        <td><?= $user->id ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= $this->Form->control('name',['label'=>false]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Role') ?></th>
                        <td><?= $this->Form->select('role', $rolesArray, ['label'=>false]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= $this->Form->control('email',['label'=>false]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Password') ?></th>
                        <td><?= $this->Form->control('password',['label'=>false, 'value'=> ""]) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Stop') ?></th>
                        <td><?= $this->Form->select('stop', $stopArray, ['label'=>false]) ?></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?= $this->Form->button(__('Edit'), ['class' => 'btn btn-info']) ?>
        <?= $this->Form->end() ?>
    </div>

</div>
