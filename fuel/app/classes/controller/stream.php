<?php

class Controller_Stream extends Controller_Template
{
	public function action_index()
	{
    $limit = 20;
    $page  = $this->param('page');
    if(empty($page) || $page < 0){
      $page   = 1;
    }
    $offset = $page -1;
    $query = 'SELECT * FROM animes ORDER BY unlikes DESC, created_at, likes LIMIT '.($limit*$offset).', '.$limit;
    $list  = DB::query($query)->execute()->as_array();

    foreach($list as $k => $anime){
      $video_info = $this->_getVideoFromYouTube($anime['title']);
      $list[$k]   = array_merge($list[$k], $video_info);
    }

		$this->template->content = View::forge('stream/index');
    $this->template->content->animes = $list;
    $this->template->content->page   = $page;
	}

  private function _getVideoFromYouTube($anime_title, $class='OP')
  {
    $url = 'http://gdata.youtube.com/feeds/api/videos';
    $url .= '?alt=json';
    $url .= '&max-results='.'6';
    //$url .= '&orderby='.'rating';
    $url .= '&q='.urlencode($anime_title . ' ' . $class);
    $url .= '&category='.urlencode('Music');

    require_once 'HTTP/Request2.php';
    $req = new HTTP_Request2($url);
    $res = $req->send();

    $rows = json_decode($res->getBody(), true);

    $info = $this->_chooseAptYouTubeVideo($rows['feed']['entry']);

    $elms  = explode('/',$info['id']['$t']);
    $vhash = array_pop($elms);

    $return = array();
    $return['vtitle'] = (isset($info['title']['$t'])) ? $info['title']['$t'] : '';
    $return['hash']   = $vhash;
    return $return;
  }

  private function _chooseAptYouTubeVideo($list)
  {
    foreach($list as $k => $info){

      if(
        false
      ){
        continue;
      }

      $content_length = $info['media$group']['media$content'][0]['duration'];
      if(
        $content_length > 60*7
      ){
        continue;
      }

      return $info;
    }
  }

  private function _getVideoFromSoundCloud($anime_title)
  {

  }
}
