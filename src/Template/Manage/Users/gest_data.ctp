<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 *  web アプリ公開用にゲストページを作成

 */
use App\Model\Entity\User;



?>

<div class="row">
    <h3>ゲスト</h3>
    <table class="table table-striped">
        <tbody>
            <tr>
                <th scope="row"><?= __(__('User Number')) ?></th>
                <td>------</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Role') ?></th>
                <td>
                    ------
                </td>
            </tr>
            <tr>
                <th scope="row"><?= __('Name') ?></th>
                <td>------</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Email') ?></th>
                <td>------</td>
            </tr>

            <tr>
                <th scope="row"><?= __('Created') ?></th>
                <td>------</td>
            </tr>
            <tr>
                <th scope="row"><?= __('Modified') ?></th>
                <td>------</td>
            </tr>
            <tr>
                <th scope="row"><?= __('State') ?></th>
                <td>------</td>
            </tr>
        </tbody>
    </table>
</div>
