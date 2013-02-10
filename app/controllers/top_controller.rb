class TopController < ApplicationController
  def index
    @mess = 'コントローラ通って来てるテスト'
    @animes = Anime.all
    respond_to do |format|
      format.html # index.html.erb
      format.json { render :json => @animes }
    end
  end
end
