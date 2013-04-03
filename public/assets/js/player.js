/**
 * main.jsにリネームするかも
**/
var __playlist = [];
var __index    =  0;
var __player   = {};

// see : https://developers.google.com/youtube/js_api_reference?hl=ja#Events
var STATE = {
  READY    : -1,
  ENDED    :  0,
  PLAYING  :  1,
  STOPED   :  2,
  BUFFERING:  3,
  HEADED   :  5,
}

function init(){
  initPlaylist(__playlist);
  initPlayer(__playlist[__index]['hash']);
  displayInfo();
  registControleBtns();
  registReplaceBtns();
}

function registControleBtns(){

  var prevBtns = document.getElementsByClassName('play-prev');
  for(var i=0; i<prevBtns.length; i++){
    prevBtns[i].addEventListener('click', playPrev);
  }
  var nextBtns = document.getElementsByClassName('play-next');
  for(var i=0; i<nextBtns.length; i++){
    nextBtns[i].addEventListener("click", playNext);
  }

  var directBtns = document.getElementsByClassName('play-direct');
  for(var i=0; i<directBtns.length; i++){
    directBtns[i].addEventListener("click", function(){
      var seq = this.getAttribute('seq');
      playDirect(seq);
    });
  }

}

function initPlaylist(__playlist, is_sub){
  var class_name = 'anime';
  if(is_sub){
    class_name = 'subanime';
  }
  var animes = document.getElementsByClassName(class_name);
  for(var i=0; i<animes.length; i++){
    var video = {
      "seq"    :  animes[i].getAttribute('seq'),
      "hash"   :  animes[i].getAttribute('hash'),
      "atitle"  :  animes[i].getAttribute('atitle'),
      "aurl"   :  animes[i].getAttribute('aurl'),
      "vtitle" :  animes[i].innerHTML,
    };
    __playlist.push(video);
  }
}

function initPlayer(initialID){
  var params = { allowScriptAccess: "always" };
  var atts   = { id: "player" };
  swfobject.embedSWF(
    "http://www.youtube.com/v/" + initialID + "?enablejsapi=1&playerapiid=ytplayer", 
    "video",
    "460",
    "360",
    "8",
    null,
    null,
    params,
    atts
  );
}

// pre-registered method
function onYouTubePlayerReady(){
  __player = document.getElementById('player');
  __player.addEventListener("onStateChange", "stateDispatcher");
  __player.addEventListener("onError",       "errorHandler");
}

function stateDispatcher(state){
  console.log(state);
  switch(state){
    case STATE.READY:
      break;
    case STATE.ENDED:
      playNext();
      break;
    case STATE.PLAYING:
      break;
    case STATE.STOPED:
      break;
    case STATE.BUFFERING:
      break;
    case STATE.HEADED:
      break;
    default:
      // do nothing
  }
}

function errorHandler(){
  setTimeout(function(){
    playNext();
  },800);
}

function displayInfo(){
  var atitle = document.getElementById('anime-title');
  atitle.innerHTML = __playlist[__index]['atitle'];

  var vtitle = document.getElementById('video-title');
  vtitle.innerHTML = __playlist[__index]['vtitle'];

  var str = 'http://www.youtube.com/watch?v=' + __playlist[__index]['hash'];
  var vurl = document.getElementById('video-url');
  vurl.innerHTML = str;
  vurl.setAttribute('href', str);

  var str = __playlist[__index]['aurl'];
  var aurl = document.getElementById('anime-url');
  aurl.innerHTML = str;
  aurl.setAttribute('href', str);

  // initialize tr
  var trs = document.getElementsByClassName('animetr');
  for(var i=0; i<trs.length; i++){
    trs[i].setAttribute('class', 'animetr');
  }
  var tr = document.getElementById('index_' + String(__index));
  tr.setAttribute('class', 'animetr nowplaying');

  // change title
  var title = document.getElementsByTagName('title');
  title[0].innerHTML = __playlist[__index]['atitle'] + ' - あにきゃっち.net';
}

function enableEvaluateBtns(){

}

function playNext(){
  var is_last = false;
  if(__index > (__playlist.length - 1)){
    is_last = true;
  }
  if(is_last){
    __index = 0;
  }else{
    __index = __index + 1;
  }
  _playThis();
}

function playPrev(){
  var is_first = false;
  if(__index < 1){
    is_first = true;
  }
  if(is_first){
    __index = (__playlist.length - 1);
  }else{
    __index = __index - 1;
  }
  _playThis();
}

function playDirect(seq){
  console.log(seq);
  __index = parseInt(seq);
  _playThis();  
}

function switchPause(){

}

function _playThis(){
  __player.loadVideoById(__playlist[__index]['hash']);
  displayInfo();
}
