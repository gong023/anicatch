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
    $query = 'SELECT * FROM animes ORDER BY unlikes, created_at DESC, likes DESC LIMIT '.($limit*$offset).', '.$limit;
    $list  = DB::query($query)->execute()->as_array();

    $animes = array();
    foreach($list as $k => $anime){
      $video_info = $this->_getVideoFromYouTube($anime['title']);
      if(empty($video_info)){
        unset($list[$k]);
        continue;
      }
      $animes[] = array_merge($list[$k], $video_info);
    }

    $this->template->content = View::forge('stream/index');
    $this->template->content->animes = $this->_checkNew($animes);
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

    if(empty($rows['feed']) || empty($rows['feed']['entry'])){
      return null;
    }
    $info = $this->_chooseAptYouTubeVideo($rows['feed']['entry']);

    if(empty($info['id'])){
      return null;
    }
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

      if(Input::get('allow') !== 'all' && $this->_checkUTATTEMITA($info)){
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

  private function _checkUTATTEMITA($info)
  {
    if(
      preg_match('/てみた/', $info['title']['$t'])
    ){
      return true;
    }
    return false;
  }

  private function _getVideoFromSoundCloud($anime_title)
  {

  }
}
