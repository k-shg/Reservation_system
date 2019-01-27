<div class="container">
    <div class="col-md-4 col-md-offset-3">
        <legend><?= __('Login') ?></legend>
        <?= $this->Form->create() ?>
        <fieldset>
            <table class="table table-striped table-bordered" >
                <tbody>
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
        <?= $this->Form->button(__('Login'), ['class' => 'btn btn-info']) ?>
        <?= $this->Form->end() ?>
    </div>

</div>
