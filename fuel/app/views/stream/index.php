<div class="row">
  <div class="span6">
    <div id="video">
    </div>
  </div>
  <div class="span6">
      <blockquote style="word-break: break-word;">
        <h3 id="anime-title">hoge</h3>
        <small><a id="anime-url">hgoe</a></small>
        <h1 id="video-title">fuga</h1>
        <small><a id="video-url">hgoe</a></small>
      </blockquote>
      <div>
        <a tabindex='1' class="btn btn-large btn-primary">好き</a>
        <a tabindex='1' class="btn btn-large btn-inverse">これ今期アニメじゃない</a>
      </div>
  </div>
</div>
<div class="row">
  <div class="span12">
    <a tabindex='1' id="cont-prev"  class="play-prev btn btn-large">Prev</a>
    <!-- a tabindex='1' id="cont-pause" class="switch-pause btn btn-large">Pause</a -->
    <a tabindex='1' id="cont-next"  class="play-next btn btn-large">Next</a>
  </div>
</div>
<div class="row">
	<div class="span8">
		<h2>page 1</h2>
		<table class="table">
      <?php for($i=0; $i<count($animes); $i++){
        echo '<tr id="index_'.$i.'" class="animetr"><td>' . $animes[$i]['title'] .'</td>';
        echo '<td><a tabindex="1" class="anime play-direct" seq="'.$i.'" hash="'.$animes[$i]['hash'].'" atitle="'.$animes[$i]['title'].'" aurl="' .$animes[$i]['url'].'">'.$animes[$i]['vtitle'] . '</a></td></tr>';
      } ?>
      <tr><td colspan="2" style="text-align:center">&lt&lt PagingHere &gt&gt</td></tr>
		</table>
	</div>
	<div class="span4">
		<h2>comments</h2>
		<table class="table">
      <tr><td>piyo</td></tr>
		</table>
	</div>
</div>