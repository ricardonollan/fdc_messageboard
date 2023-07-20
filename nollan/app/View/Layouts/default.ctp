<?php

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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css('cake.generic');

	echo $this->fetch('meta');
	echo $this->Html->css('Login/login.css');
	echo $this->Html->css('user/user.css');
	echo $this->Html->css('message/message.css');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
	<div id="container" class="container-fluid">
		<?php if (isset($_SESSION['logged_in'])) { ?>
			<div id="header" class="text-end">
				<ul class="menu_ul">
					<li><a href="<?= FULL_BASE_URL.'/nollan/users/profile';?>" class="home_link">Home</a></li>
					<li>
						<div class="dropdown">
							<a class="dropdown-toggle user_name" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
								<?= $_SESSION['user'] ?>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
								<li><a class="dropdown_list" href="<?= FULL_BASE_URL.'/nollan/users/editProfile';?>">Edit Profile</a></li>
								<li><a class="dropdown_list" href="<?= FULL_BASE_URL.'/nollan/messages/contact';?>">message</a></li>
							</ul>
						</div>
					</li>
					<li>
						<h5><?= $this->Html->link('logout', array('controller' => 'Users', 'action' => 'logout'), array('class' => 'btn-logout')); ?></h5>
					</li>
				</ul>
			</div>
		<?php } ?> 
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">

		</div>
	</div>

	<!-- </?php echo $this->element('sql_dump'); ?> -->
</body>
<script>
	const base_url = `<?= FULL_BASE_URL . '/nollan'; ?>`;
</script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" ></script>
<?= $this->Html->script('Login/login.js'); ?>
<?= $this->Html->script('user/user.js'); ?>
<?= $this->Html->script('message/message.js'); ?>

</html>