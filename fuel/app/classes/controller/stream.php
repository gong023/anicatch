<?php

class Controller_Stream extends Controller_Template
{
	public function action_index()
	{

    $limit = 20;
    $query = 'SELECT * FROM animes ORDER BY unlikes DESC, created_at, likes LIMIT 0, '.$limit;
    $list  = DB::query($query)->execute()->as_array();

    foreach($list as $k => $anime){
      $video_info = $this->_getVideoFromYouTube($anime['title']);
      $list[$k]   = array_merge($list[$k], $video_info);
    }

		$this->template->content = View::forge('stream/index');
    $this->template->content->animes = $list;
	}

  private function _getVideoFromYouTube($anime_title, $category='OP')
  {
    require_once 'HTTP/Request2.php';
    $baseurl = 'http://gdata.youtube.com/feeds/api/videos?alt=json&max-results=1&q=';
    $q = urlencode($anime_title . ' ' . $category);

    $req = new HTTP_Request2($baseurl.$q);
    $res = $req->send();

    $rows = json_decode($res->getBody(), true);
    /**
     * choose the best entry : see category term ?= Music or so
    **/
    //{{{
      // TODO
    //}}}
    $info = (array)$rows['feed']['entry'][0];

    $elms  = explode('/',$info['id']['$t']);
    $vhash = array_pop($elms);

    $return = array();
    $return['vtitle'] = (isset($info['title']['$t'])) ? $info['title']['$t'] : '';
    $return['hash']   = $vhash;
    return $return;
  }

  private function _getVideoFromSoundCloud($anime_title)
  {

  }
}
