<div class="row">
  <div class="span6">
    <?php if($isSoundCloud){ ?>
      <iframe class="iframe"
        width="100%"
        height="206"
        scrolling="no"
        frameborder="no">
      </iframe>
    <?php }else{ ?>
    <div id="video">
    </div>
    <?php } ?>
  </div>
  <div class="span6" style="margin-bottom:20px">
      <blockquote style="word-break: break-word;">
        <h3 id="anime-title">Now Loading...</h3>
        <a tabindex='1' id="like-anime" anime-id="" class="btn btn-mini">好き</a>
        <?php if(isset($is_admin) && $is_admin){ ?>
          <a tabindex='1' id="unlike-anime" anime-id="" class="btn btn-mini btn-inverse">これ今期アニメじゃない</a>
        <?php } ?>
        <small><a id="anime-url" target="_blank">hoge</a></small>
        <h1 id="video-title">Now Loading...</h1>
        <a id="video-wrong" class="btn btn-mini">これ違う動画</a>
        <small><a id="video-url" target="_blank">fuga</a></small>
        <div id="share">
          <div id="share-fb">
            <img src="http://anicatch.net/assets/img/share_fb.png">
          </div>
          <div id="share-tw">
            <img src="http://anicatch.net/assets/img/share_tw.png">
          </div>
          <?php if(!$isSoundCloud){ ?>
            <div id="share-sh">
              <span>SoundHook</span>
            </div>
          <?php } ?>
        </div>
      </blockquote>
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
    <h2>Playlist</h2>
		<table class="table">
      <?php for($i=0; $i<count($animes); $i++){
        echo '<tr id="index_'.$i.'" class="animetr"><td><a class="black" href="/anime/'.$animes[$i]['id'].'/stream'.$get_parameter.'">'. $animes[$i]['title'] .'</td>';
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
		<h2>Option</h2>
    <form id="option">
		<table class="table">
      <tr>
        <th>sound</th>
        <td><input id="opt-src-youtube" class="option src-selector" type="radio" name="src" value="youtube" <?php if(!$isSoundCloud){ echo 'checked'; } ?>>YouTube</td>
        <td><input id="opt-src-soundcloud" class="option src-selector" type="radio" name="src" value="soundcloud"  <?php if($isSoundCloud){ echo 'checked'; } ?>>SoundCloud</td>
      </tr>
      <tr>
        <th>filter</th>
        <td><input id="opt-allow-no" class="option allow-selector" type="radio" name="allow" value="" <?php if(!$isAllowAll){ echo 'checked'; } ?>>On</td>
        <td><input id="opt-allow-all" class="option allow-selector" type="radio" name="allow" value="all"<?php if($isAllowAll){ echo 'checked'; } ?>>Off</td>
      </tr>
      <tr>
        <th>query</th>
        <td colspan="2">
          <input id="opt-q" class="option opt-text q-selector" type="text" name="q" placeholder="additional query" value="<? if($q){ echo $q; }else{ echo 'OP'; }?>"/>
        </td>
      </tr>
      <tr>
        <th>start</th>
        <td colspan="2">
          <input id="opt-v" class="option opt-text v-selector" type="text" name="v" placeholder="start video id" value=<?php if($start_v_id){ echo '"'.$start_v_id.'"'; }else{ ?>"" disabled<?php } ?>/>
        </td>
      </tr>
      <tr>
        <td colspan="3">
          <pre id="option-parameters">?src=soundcloud&q=REMIX&allow=all</pre>
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>
          <a id="btn-reload" href="" class="btn btn-primary pull-right">Reload</a>
        </td>
      </tr>
		</table>
    </form>
	</div>
</div>
