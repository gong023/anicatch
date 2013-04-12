<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <link rel="shorcut icon" href="assets/img/anicatch.png">
  <title>あにきゃっち.net</title>
  <meta property="og:image" content="http://anicatch.net/assets/img/anicatch.png">
  <meta property="og:description" content="アニメを見る暇無いのなら、オープニングだけ聞けばいいじゃない">
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('common.css'); ?>
	<?php echo Asset::js('effect.js'); ?>
	<?php echo Asset::js('top.js'); ?>
</head>
<body onload="init()">
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
        <h1>あにきゃっち.net <small><i> - closed β - </i></small></h1>
      </div>
		</div>
	</div>
	<div class="container">
		<div class="hero-unit">
			<div>
        <h1>今期アニメ、</h1>
        <h1>ちゃんと見てる？</h1>
      </div>
      <div class="pull-right"><p><a class="replace-loader btn btn-primary btn-large" href="/stream">or Catch Up Now ></a></p></div>
		</div>
		<div class="row">
			<div class="span4">
				<h2>list 1</h2>
				<table class="table">
          <?php foreach($list0 as $k => $v){ echo '<tr><td><a href="'.$v['url'].'">' . $v['title'] . "</a></td></tr>"; } ?>
				</table>
			</div>
			<div class="span4">
				<h2>list 2</h2>
				<table class="table">
          <?php foreach($list1 as $k => $v){ echo '<tr><td><a href="'.$v['url'].'">' . $v['title'] . "</a></td></tr>"; } ?>
				</table>
			</div>
			<div class="span4">
				<h2>list 3</h2>
				<table class="table">
          <?php foreach($list2 as $k => $v){ echo '<tr><td><a href="'.$v['url'].'">' . $v['title'] . "</a></td></tr>"; } ?>
				</table>
			</div>
		</div>
		<hr/>
		<footer>
			<p class="pull-right">
        <!-- Page rendered in {exec_time}s using {mem_usage}mb of memory. -->
        <div class="fb-like pull-right" data-href="http://anicatch.net" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
      </p>
			<p>
				<a href="http://fuelphp.com">FuelPHP</a> is released under the MIT license.<br>
				<small>Version: <?php echo Fuel::VERSION; ?></small>
			</p>
		</footer>
	</div>
</body>
</html>
