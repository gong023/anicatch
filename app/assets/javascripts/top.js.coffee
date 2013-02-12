# Place all the behaviors and hooks related to the matching controller here.
# All this logic will automatically be available in application.js.
# You can use CoffeeScript in this file: http://jashkenas.github.com/coffee-script/



$ ->
  # TODO: get video info by title by using ServerSide API in order to affect each video's score (or even existence)

  ageEffect = () ->
    $('#age-response-ux').animate({
      "top" : "-200px"
    }, 1500, () ->
      $('#age-response-ux').css({
        "top" : "150%"
      })
    )

  $('.action-age').on 'click', () ->
    url      = $(this).attr 'destination'
    anime_id = $(this).attr 'anime-id'
    idstr    = $(this).attr 'idstr'
    #title    = $(this).attr 'anime-title'
    $.post url,
      'idstr'    : idstr
      'anime_id' : anime_id
      (data) ->
        if data.id
          ageEffect()

  DEFINED_LENGTH = parseInt($('input#defined-length').attr('len'))

  # function generateVideoTo
  generateVideoTo = (info, anime_id, anime_title, sequence, video_id, is_OP) ->
    # console.log sequence, video_id
    sid = ''
    if is_OP
      dom_render_target = 'div#_id_' + anime_id
      sid = 'sid-' + sequence + '-' + video_id
    else
      dom_render_target = 'div#_id_ED_' + anime_id
      sid = 'sid-' + sequence + '-' + (parseInt(video_id) + DEFINED_LENGTH)
    video_hash          = (info.id.$t.split /\//).pop()
    video_title         = info.title.$t
    video_thumbnail_url = info.media$group.media$thumbnail.shift().url
    #console.log video_hash, video_thumbnail_url, video_title, dom_render_target
    # create img
    img = document.createElement 'img'
    img.setAttribute 'id', sid
    img.setAttribute 'anime-id', anime_id
    img.setAttribute 'src', video_thumbnail_url
    img.setAttribute 'class', 'trigger'
    img.setAttribute 'title', video_title
    img.setAttribute 'anime-title', anime_title
    img.setAttribute 'video-hash', video_hash
    img.addEventListener 'click', (e)=>
      playThis img
    #console.log img
    $(dom_render_target).append(img)

  # function getVideosInfo
  getVideosInfo = (str, anime_id, sequence) ->
    secret_query = $('#secret-query').attr('query');
    url = 'http://gdata.youtube.com/feeds/api/videos?alt=json&'
    op_url = url + 'q=' + str + '+OP' + '+' + secret_query
    $.ajax op_url,
      type: 'GET'
      dataType: 'JSONP'
      error: (a, b, c, d) -> console.log a b c d
      success : (data, result) ->
        tail = DEFINED_LENGTH - 1
        generateVideoTo(data.feed.entry[key], anime_id, str, sequence, key, true) for key in [0 .. tail]
    ed_url = url + 'q=' + str + '+ED' + '+' + secret_query
    $.ajax ed_url,
      type: 'GET'
      dataType: 'JSONP'
      error: (a, b, c, d) -> console.log a b c d
      success : (data, result) ->
        tail = DEFINED_LENGTH - 1
        generateVideoTo(data.feed.entry[key], anime_id, str, sequence, key, false) for key in [0 .. tail]

  # main
  titles = $("h1.anime_title")
  getVideosInfo(title.innerHTML, $(title).attr('render-to'), $(title).attr('sequence')) for title in titles

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
