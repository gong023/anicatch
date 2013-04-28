/**
**/

window.fbAsyncInit = function() {
  FB.init({
    appId      : '122961194566265', // App ID
    channelUrl : '',//'//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });
  var share_fb = document.getElementById('share-fb');
  share_fb.addEventListener('click',function(e){
    FB.ui({
      method: 'feed',
      name: __playlist[__index]['atitle'] + ' ' + __playlist[__index]['vtitle'],
      caption: generateOriginalURL(),
      description: generateOriginalURL() + ' アニメを見る暇が無いのなら、オープニングだけ聞けばいいじゃない？',
      picture : 'http://anicatch.net/assets/img/anicatch.png',
      link: window.location.origin + window.location.pathname + generateGetParameterForShare(),
    });
  });
};

function generateGetParameterForShare(){
  // over write
  params = parseLocatinGetParameter();
  params['v'] = __playlist[__index]['hash']; 
  return paramsStringify(params);
}

function parseLocatinGetParameter(){
  var elms = window.location.search.split(/[\?\&=]/);
  elms.shift();
  var i = 0;
  var params = {};
  while(true){
    if(elms[i] == void 0){
      break;
    }
    var key = elms[i];
    var val = elms[i+1];
    params[key] = val;
    i = i + 2;
  }
  return params;
}

function paramsStringify(params){
  var get_parameter_str = '';
  var first = true;
  for(var i in params){
    var sep = (first==true) ? '?' : '&';
    get_parameter_str += (sep + i + '=' + params[i]);
    first = false;
  }
  return get_parameter_str;
}

/***
  * OPTION
***/
function showOptionURL(){
  var params = parseLocatinGetParameter();
  var pre = document.getElementById('option-parameters');
  var html = paramsStringify(params);
  pre.innerHTML = html;
}

function registInputReaction(){
  var inputs = document.getElementsByTagName('input');
  for(var i=0;i<inputs.length; i++){
    inputs[i].addEventListener('change', function(){
      var params = collectInputCurrentParams();
      refreshInputValuesDisplay(params);
      refreshReloadButton(params);
    });
  }
  var input_type_text = document.getElementsByClassName('opt-text');
  for(var i=0;i<input_type_text.length; i++){
    input_type_text[i].addEventListener('keyup',function(){
      var params = collectInputCurrentParams();
      refreshInputValuesDisplay(params);
      refreshReloadButton(params);
    });
  }
}

function refreshInputValuesDisplay(params){
  var html = paramsStringify(params);
  var pre = document.getElementById('option-parameters');
  pre.innerHTML = html;
}

function refreshReloadButton(params){
  var btn = document.getElementById('btn-reload');
  btn.setAttribute('href', paramsStringify(params));
}

function collectInputCurrentParams(){
  var params = {
    src   : document.forms["option"].elements['src'].value,
  }
  var allow = document.forms["option"].elements['allow'].value;
  if(allow) params.allow = allow;
  var q = document.forms["option"].elements['q'].value;
  if(q) params.q = q;
  var v = document.forms["option"].elements['v'].value;
  if(v) params.v = v;
  return params;
}

function generateOriginalURL(){
  if(isSoundCloud()){
    return __playlist[__index]['hash'];
  }else{
    return 'http://www.youtube.com/watch?v=' + __playlist[__index]['hash'];
  }
}

function isSoundCloud(){
  return window.location.search.match(/soundcloud/);
}

// Load the SDK Asynchronously
(function(d, s, id){
 var js, fjs = d.getElementsByTagName(s)[0];
 if (d.getElementById(id)) {return;}
 js = d.createElement(s); js.id = id;
 js.src = "//connect.facebook.net/en_US/all.js";
 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

(function(){
  // {{{ #share-tw click
  var share_tw = document.getElementById('share-tw');
  share_tw.addEventListener('click',function(e){
    option = "width=720,height=280,left=" + e.clientX + ",top=" + e.clientY;
    var share_url = createShareUrl();
    window.open('https://twitter.com/intent/tweet?lang=en&hashtags=anicatch&url=' + share_url ,"",option);
  });
  // }}}

  // {{{ #share-sh click
  var share_sh = document.getElementById('share-sh');
  if(share_sh){
    share_sh.addEventListener('click',function(){
      var soundhook_url = createSoundhookUrl();
      window.open(soundhook_url);
    });
  }
  // }}}
})();

function createShareUrl(){
  var music = __playlist[__index];
  var share_url = encodeURIComponent(window.location.origin + window.location.pathname + generateGetParameterForShare()) + '&text=' + encodeURIComponent(music.vtitle) + ' via @AnicatchNet';
  return share_url;
}

function createSoundhookUrl(){
  var music = __playlist[__index];
  return 'http://soundhook.net/search?qu=' + music.hash + '&from=anicatch'; 
}
