<div class="row">
  <div class="span6">
    <div id="video">
    </div>
  </div>
  <div class="span6">
      <blockquote style="word-break: break-word;">
        <h3 id="anime-title">Now Loading...</h3>
        <small><a id="anime-url" target="_blank">hoge</a></small>
        <h1 id="video-title">Now Loading...</h1>
        <small><a id="video-url" target="_blank">fuga</a></small>
      </blockquote>
      <div id="anime-evaluation">
        <a tabindex='1' id="like-anime"   anime-id="" class="btn btn-large btn-primary">好き</a>
        <a tabindex='1' id="unlike-anime" anime-id="" class="btn btn-large btn-inverse">これ今期アニメじゃない</a>
      </div>
      <div id="share">
        <div id="share-fb">
          <img src="http://anicatch.net/assets/img/share_fb.png">
        </div>
        <div id="share-tw">
          <img src="http://anicatch.net/assets/img/share_tw.png">
        </div>
        <div id="share-sh">
          <span>SoundHook</span>
        </div>
      </div>
  </div>
</div>
<div class="row">
  <div id="control-pannel" class="span12">
    <a tabindex='1' id="cont-prev"  class="btn btn-large play-prev">PREV</a>
    <a tabindex='1' id="cont-pause" class="btn btn-large switch-pause btn-inverse" state="0">PLAY</a>
    <a tabindex='1' id="cont-next"  class="btn btn-large play-next">NEXT</a>
    <!--a tabindex='1' id="cont-hide"  class="btn btn-large hide-cont" state="1">hide</a-->
  </div>
</div>
<div class="row streaming-contents">
	<div class="span8">
    <?php if(isset($page)){ ?>
      <div class="pull-right"><a class="replace-loader" href="/stream/<?php echo $page + 1; echo '/' . $get_parameter; ?>">next page</a></div>
    <?php } ?>
    <h2>playlist</h2>
		<table class="table">
      <?php for($i=0; $i<count($animes); $i++){
        echo '<tr id="index_'.$i.'" class="animetr"><td>' . $animes[$i]['title'] .'</td>';
        echo '<td><a tabindex="1" class="anime play-direct" seq="'.$i.'" anime-id="'.$animes[$i]['id'].'" hash="'.$animes[$i]['hash'].'" atitle="'.$animes[$i]['title'].'" aurl="' .$animes[$i]['url'].'">'.$animes[$i]['vtitle'] . '</a></td></tr>';
      } ?>
      <tr><td colspan="2" style="text-align:center">
      <?php if(isset($page)){ ?>
        &lt&lt page<?echo $page; ?> &gt&gt
      <?php }else{
        echo $animes[0]['title'];
      } ?>
      </td></tr>
		</table>
	</div>
	<div class="span4">
		<h2>comments</h2>
		<table class="table">
      <tr><td>piyo</td></tr>
		</table>
	</div>
</div>
