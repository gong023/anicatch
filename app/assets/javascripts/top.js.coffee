# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/



$ ->
  # TODO: get video info by title by using ServerSide API in order to affect each video's score (or even existence)

  # function generateVideoTo
  generateVideoTo = (info, anime_id, anime_title, video_id) ->
    dom_render_target   = 'div#_id_' + anime_id
    video_hash          = (info.id.$t.split /\//).pop()
    video_title         = info.title.$t
    video_thumbnail_url = info.media$group.media$thumbnail.shift().url
    #console.log video_hash, video_thumbnail_url, video_title, dom_render_target
    # create img
    img = document.createElement 'img'
    img.setAttribute 'id', ('uid-' + anime_id + '-' + video_id)
    img.setAttribute 'anime-id', anime_id
    img.setAttribute 'src', video_thumbnail_url
    img.setAttribute 'class', 'trigger'
    img.setAttribute 'title', video_title
    img.setAttribute 'anime-title', anime_title
    img.setAttribute 'video-hash', video_hash
    img.addEventListener 'click', (e)=>
      playThis img
    $(dom_render_target).append(img)

  # function getVideosInfo
  getVideosInfo = (str, anime_id) ->
    url = 'http://gdata.youtube.com/feeds/api/videos?alt=json&'
    url += 'q=' + str + '+op'
    $.ajax url,
      type: 'GET'
      dataType: 'JSONP'
      error: (a, b, c, d) -> console.log a b c d
      success : (data, result) ->
        #for ( var i in data) { # each???
        info = data.feed.entry[0]
        generateVideoTo(info, anime_id, str, 0);
        #}

  # main
  titles = $("h1.anime_title")
  getVideosInfo(title.innerHTML, $(title).attr('render-to')) for title in titles

# I should use this syntax when generating iframe
#hash = (data.feed.entry[0].id.$t.split /\//).pop()


## this is sample
#$ ->
#  $("div#canvas").dblclick (e) ->
#    [x, y] = positionOfNewBlock(e)
#    $.post '/blocks', block: { x: x, y: y }, (block_id) ->
#      block = $("<div class='block' style='left: #{x}px; top: #{y}px;' />").
#        draggable(containment: "parent").css(position: "absolute")
#      $(e.target).append(block)
#
#  $("div.block").draggable(containment: "parent").css(position: "absolute")
