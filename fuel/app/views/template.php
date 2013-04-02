<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <link rel="shorcut icon" href="assets/img/anicon.png">
  <title>あにきゃっち.net</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('common.css'); ?>
	<?php echo Asset::js('swfobject.js'); ?>
	<?php echo Asset::js('player.js'); ?>
</head>
<body onload="init();">
	<div id="header">
		<div class="row">
			<div id="logo">
        <h1><a href="/" class="logo">あにきゃっち.net</a><small><i> - closed β - </i></small></h1>
      </div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="span16">
<?php if (Session::get_flash('success')): ?>
				<div class="alert-message success">
					<p>
					<?php echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
					</p>
				</div>
<?php endif; ?>
<?php if (Session::get_flash('error')): ?>
				<div class="alert-message error">
					<p>
					<?php echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
					</p>
				</div>
<?php endif; ?>
			</div>
			<div class="span16">
      <?php echo $content; ?>
			</div>
		</div>
		<hr/>
		<footer>
			<p class="pull-right">Page rendered in {exec_time}s using {mem_usage}mb of memory.</p>
			<p>
				Powered by <a href="http://fuelphp.com">FuelPHP</a> : released under the MIT license.<br>
				<!-- small>Version: <?php echo e(Fuel::VERSION); ?></small -->
			</p>
		</footer>
	</div>
</body>
</html>
