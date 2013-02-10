class TopController < ApplicationController
  def index
    # get initial video
    @initial = Movie.first
    #initial.idstr = '9FLTUJKdvU8'
    #initial.title = 'Kotoura-san Opening'
    # get anime list
    @animes = Anime.all
    respond_to do |format|
      format.html # index.html.erb
      format.json { render :json => @animes }
    end
  end
end
