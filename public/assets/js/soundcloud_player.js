/**
 * main.jsにリネームするかも
**/
var __playlist = [];
var __index    =  0;
var __player   = {};

var host2widgetBaseUrl = {
  "wt.soundcloud.dev" : "wt.soundcloud.dev:9200/",
  "wt.soundcloud.com" : "wt.soundcloud.com/player/",
  "w.soundcloud.com"  : "w.soundcloud.com/player/"
};

var widgetBaseUrl = "w.soundcloud.com/player/";

var defPauseBtnClass =    "btn btn-large switch-pause btn-inverse",
    pauseBtnChangeClass = "btn-inverse";

function init(){
  initPlaylist();
  initPlayer(__playlist[__index]['hash']);
  displayInfo();
  registControleBtns();
  registReplaceBtns();
  registAjaxBtns();
  registInputReaction();
  showOptionURL();
  refreshAmazon(__playlist[__index]['atitle']);
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

  var pauseBtn = document.getElementById('cont-pause');
  pauseBtn.addEventListener('click', function(){
    switchPause();
  });

}

function initPlaylist(){
  __playlist = [];
  var class_name = 'anime';
  var animes = document.getElementsByClassName(class_name);
  for(var i=0; i<animes.length; i++){
    var video = {
      "seq"     : animes[i].getAttribute('seq'),
      "animeid" : animes[i].getAttribute('anime-id'),
      "hash"    : animes[i].getAttribute('hash'),
      "atitle"  : animes[i].getAttribute('atitle'),
      "aurl"    : animes[i].getAttribute('aurl'),
      "vtitle"  : animes[i].innerHTML,
    };
    __playlist.push(video);
  }
}

function initPlayer(initialID){
  var iframe = document.querySelector('.iframe');
  iframe.src = location.protocol + "//" + widgetBaseUrl + "?url=" + initialID;
  __player = SC.Widget(iframe);
  bindStateDispatcher();
}

function set__player(){
  setTimeout(function(){
    var iframeElement   = document.querySelector('iframe');
    __player            = SC.Widget(iframeElement);
  },1000);
}

function bindStateDispatcher(){
  __player.bind(SC.Widget.Events.FINISH, function(){
    playNext();
  });
  __player.bind(SC.Widget.Events.PLAY, function(){
    transformToPause();
  });
  __player.bind(SC.Widget.Events.PAUSE, function(){
    transformToPlay();
  });
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

  var str = __playlist[__index]['hash'];
  var vurl = document.getElementById('video-url');
  vurl.innerHTML = str;
  vurl.setAttribute('href', str);
  vurl.addEventListener('click', function(){
    pause();
  });

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

  var face = document.getElementById('atitle-reject');
  face.innerHTML = __playlist[__index]['atitle'];
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
  __index = parseInt(seq);
  _playThis();  
}


function transformToPause(){
  var btn = document.getElementById('cont-pause');
  btn.setAttribute('state', '1');
  btn.innerHTML = 'PAUSE';
  removeClass(btn, pauseBtnChangeClass);
}

function transformToPlay(){
  var btn = document.getElementById('cont-pause');
  btn.setAttribute('state', '0');
  btn.setAttribute('class', defPauseBtnClass);
  btn.innerHTML = 'PLAY';
}

function switchPause(){
  __player.toggle();
}

function pause(){
  __player.pause();
}
function play(){
  __player.play();
}

function _playThis(){
  __player.load(__playlist[__index]['hash'],{callback:function(){
    __player.play();
  }});
  displayInfo();
  refreshAmazon(__playlist[__index]['atitle']);
}

function removeClass(el, c) {
  var triml = /^\s+/,
      trimr = /\s+$/;
  el.className = (' ' + el.className + ' ').replace(' ' + c + ' ', '').replace(triml, '').replace(trimr, '');
}
