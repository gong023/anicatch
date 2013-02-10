# coding: utf-8

class MovieController < ApplicationController
  def all
    @movies = Movie.all
  end
end
