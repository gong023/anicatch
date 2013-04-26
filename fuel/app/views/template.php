<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <link rel="shorcut icon" href="http://anicatch.net/assets/img/anicatch.png">
  <title>あにきゃっち.net</title>
  <meta property="og:url" content="http://anicatch.net/">
  <meta property="og:image" content="http://anicatch.net/assets/img/anicatch.png">
  <meta property="og:description" content="アニメを見る暇が無いのなら、オープニングだけ聞けばいいじゃない">
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('common.css'); ?>
	<?php echo Asset::js('effect.js'); ?>
	<?php echo Asset::js('ajax.js'); ?>
  <?php if($soundcloud){ ?>
    <script src="http://connect.soundcloud.com/sdk.js"></script>
    <script src="https://w.soundcloud.com/player/api.js"></script>
    <?php echo Asset::js('soundcloud_player.js'); ?>
  <? }else{
    echo Asset::js('swfobject.js');
	  echo Asset::js('player.js');
  } ?>
</head>
<body onload="init();">
  <div id="fb-root"></div>
  <script>
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
	<div id="header">
		<div class="row">
			<div id="logo">
        <h1><a tabindex='1' href="/" class="logo">あにきゃっち.net</a><small><i> - closed β - </i></small></h1>
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
			<p class="pull-right">
        <!-- Page rendered in {exec_time}s using {mem_usage}mb of memory. -->
        <div class="fb-like pull-right" data-href="http://anicatch.net" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
      </p>
			<p>
				Powered by <a href="http://fuelphp.com">FuelPHP</a> : released under the MIT license.<br>
				<small>about this site, All right reserved. Copyright otiai10<!--Version: <?php echo Fuel::VERSION; ?>--></small>
			</p>
		</footer>
	</div>
  <div id="age-face-hidden">(☝ ՞ω ՞)☝</div>
  <div id="sage-face-hidden">(´・ω・`)</div>
<div id="reject-face-hidden">
　 ∧_∧<br>
⊂（#・ω・） これは<span id="atitle-reject"></span>の曲じゃない！<br>
　/　　　ﾉ∪ <br>
　し―-J　|l| | <br>
　　 　 　 　 人ﾍﾟｼｯ!! <br>
　　　　　　　＿＿ <br>
　　　　　　　＼　 ＼ <br>
　　　　　　　　 ￣￣ <br>
</div>
<?php echo Asset::js('social.js'); ?>
</body>
</html>
