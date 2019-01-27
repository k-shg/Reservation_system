<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use App\Model\Entity\User;
?>

<div class="row">
    <h3><?= h($user->name). __('Mr') ?></h3>
    <table class="table table-striped">
        <tbody>
            <tr>
                <th scope="row"><?= __('User Number') ?></th>
                <td><?= $this->Number->format($user->id) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Role') ?></th>
                <td>
                    <?php
                    if($user->role === User::ADMIN) {
                        echo __("Manager");
                    }else if($user->role === User::NORMAL) {
                        echo __("Normal");
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td><?= h($user->name) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Email') ?></th>
                <td><?= h($user->email) ?></td>
            </tr>

            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td><?= h($user->created->format('Y-m-d H:i:s')) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td><?= h($user->modified->format('Y-m-d H:i:s')) ?></td>
            </tr>
            <tr>
                <th scope="row"><?= __('State') ?></th>
                <td><?= $user->stop === true ? __("Stop"): "" ?></td>
            </tr>
        </tbody>
    </table>
</div>
