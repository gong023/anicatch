<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
  <link rel="shorcut icon" href="assets/img/anicatch.png">
  <title>あにきゃっち.net</title>
  <meta property="og:url" content="http://anicatch.net/">
  <meta property="og:image" content="http://anicatch.net/assets/img/anicatch.png">
  <meta property="og:description" content="アニメを見る暇が無いのなら、オープニングだけ聞けばいいじゃない">
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('common.css'); ?>
	<?php echo Asset::css('top.css'); ?>
	<?php echo Asset::js('effect.js'); ?>
	<?php echo Asset::js('top.js'); ?>
	<?php echo Asset::js('social.js'); ?>
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
        <h1><a tabindex='1' href="/" class="logo">あにきゃっち.net</a><small><i> - open β - </i></small></h1>
      </div>
		</div>
	</div>
	<div class="container">
		<div class="hero-unit">
      <div>
        <h1>今期アニメ、</h1>
        <h1>ちゃんと見てる？</h1>
      </div>
      <hr class="styling margined">
      <div class="pull-right">
        <small>
          アニメを見る暇が無いのなら、オープニングだけ聞けばいいじゃない<br>
        </small>
        <p><a class="replace-loader btn btn-primary btn-large pull-right" href="/stream">Streaming ></a></p>
        <small class="more pull-right">※ アニメタイトルから、特定アニメだけのストリーミングも可能です</small>
      </div>
      <hr class="styling">
		</div>
		<div class="row">
			<div class="span4">
				<h2><a href="/stream" class="replace-loader">page 1 &gt;</a></h2>
				<table class="table">
          <?php
            foreach($list0 as $k => $v){
              echo '<tr><td>';
              if($v['is_new']){ echo '<small style="color:red">NEW!</small>'; }
              echo '<a href="http://anicatch.net/anime/'.$v['id'].'/stream">';
              echo $v['title'] . "</a>";
              echo "</td></tr>";
            }
          ?>
				</table>
			</div>
			<div class="span4">
				<h2><a href="/stream/2" class="replace-loader">page 2 &gt;</a></h2>
				<table class="table">
          <?php
            foreach($list1 as $k => $v){
              echo '<tr><td>';
              if($v['is_new']){ echo '<small style="color:red">NEW!</small>'; }
              echo '<a href="http://anicatch.net/anime/'.$v['id'].'/stream">';
              echo $v['title'] . "</a>";
              echo "</td></tr>";
            }
          ?>
				</table>
			</div>
			<div class="span4">
				<h2><a href="/stream/3" class="replace-loader">page 3 &gt;</a></h2>
				<table class="table">
          <?php
            foreach($list2 as $k => $v){
              echo '<tr><td>';
              if($v['is_new']){ echo '<small style="color:red">NEW!</small>'; }
              echo '<a href="http://anicatch.net/anime/'.$v['id'].'/stream">';
              echo $v['title'] . "</a>";
              echo "</td></tr>";
            }
          ?>
				</table>
			</div>
		</div>
		<hr/>
		<footer>
			<div class="pull-left">
        <div class="fb-like pull-left" data-href="http://anicatch.net" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="arial"></div>
        <div style="clear:both" class="pull-left">Powered by <a href="http://fuelphp.com">FuelPHP</a> : released under the MIT license.</div>
      </div>
      <div class="pull-right">
        <p>
          <small class="pull-right">All right reserved. Copyright otiai10</small><br>
          <small class="pull-right">苦情・お問い合わせ : <a href="https://twitter.com/otiai10">@otiai10</a></small>
        </p>
      </div>
		</footer>
	</div>
</body>
</html>
