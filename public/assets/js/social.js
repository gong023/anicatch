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
      name: __playlist[__index]['vtitle'],
      caption: 'YouTube via あにきゃっち.net',
      //description: 'ですくりぷしょん',
      link: 'http://www.youtube.com/watch?v=' + __playlist[__index]['hash'],
    });
  });
};
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
  var share_url = encodeURIComponent('http://youtu.be/'+music.hash) + '&text=' + encodeURIComponent(music.vtitle) + ' via @AnicatchNet';
  return share_url;
}

function createSoundhookUrl(){
  var music = __playlist[__index];
  return 'http://soundhook.net/search?qu=' + music.hash + '&from=anicatch'; 
}
