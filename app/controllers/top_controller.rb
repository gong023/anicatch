class TopController < ApplicationController
  def index
    @query = params[:q]
    # get initial video
    @initial = Movie.last
    #initial.idstr = '9FLTUJKdvU8'
    #initial.title = 'Kotoura-san Opening'
    # get anime list
    @animes = Anime.find(:all, :order => "point DESC")
    respond_to do |format|
      format.html # index.html.erb
      format.json { render :json => @animes }
    end
  end
end
