class LikeController < ApplicationController
  def add
    @anime = Anime.find(params[:id])
    point = @anime.point.to_i + 1
    @movie = Movie.new
    @movie.idstr = params[:idstr]
    @movie.anime_id = params[:anime_id]
    @movie.save
    respond_to do |format|
      if @anime.update_attributes( :point => point )
        format.json { render :json => @anime }
      else
        format.json { render :message => 'hoge' }
      end
    end
  end
end
