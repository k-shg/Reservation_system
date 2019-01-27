<?php
use App\Model\Entity\User;

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?= $this->Html->css('origin.css') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>
    <!-- もしすべてのビューでメニューを表示したい場合、ここに入れます -->
    <nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbarEexample">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
            <?= $this->Html->link(__("Reservation site"), ['controller' => 'reservations', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
		</div>

		<div class="collapse navbar-collapse" id="navbarEexample">
			<ul class="nav navbar-nav">
                <?php
                if($this->Session->read('Auth.User.role') === User::ADMIN) {
                ?>
                    <li><?= $this->Html->link(__('Account data'), ['controller' => 'users', 'action' => 'view',$this->Session->read('Auth.User.id')]) ?></li>
                    <li><?= $this->Html->link(__('Reservation list'), ['controller' => 'reservations', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link(__('Users'), ['controller' => 'users', 'action' => 'index']) ?></li>
                    <li><?= $this->Html->link(__('Aggregates'), ['controller' => 'Aggregates', 'action' => 'statisticReservations']) ?></li>
                    <li><?= $this->Html->link(__('Aggregates2'), ['controller' => 'Aggregates', 'action' => 'statisticLength']) ?></li>
                <?php
                } else if($this->Session->read('Auth.User.role') === User::NORMAL) {
                ?>
                    <li><?= $this->Html->link(__('Account data'), ['controller' => 'users', 'action' => 'view',$this->Session->read('Auth.User.id')]) ?></li>
                    <li><?= $this->Html->link(__('Reservation list'), ['controller' => 'reservations', 'action' => 'index']) ?></li>

                <?php }
                ?>
			</ul>
            <div class="navbar-right">
                <?php //管理者または一般ユーザーがログイン中のとき
                    if($this->Session->read('Auth.User.role') === User::ADMIN
                        || $this->Session->read('Auth.User.role') === User::NORMAL) { ?>
                            <p class="navbar-text" style="font-size: 14px;">
                                <?=__('User name')?>:
                                <?= $this->Session->read('Auth.User.name') ?>
                            </p>
                            <p class="navbar-text" style="font-size: 14px;">
                                <?=__('Mail Address')?>:
                                <?= $this->Session->read('Auth.User.email') ?>
                            </p>
                        <?php echo $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-default navbar-btn']);
                    }else {
                        echo $this->Html->link(__('New user registration'), ['controller' => 'users', 'action' => 'add'], ['class' => 'btn btn-default navbar-btn']);
                    }
                ?>
            </div>
		</div>

	</div>
</nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix" style="font-size: 20px;">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
