class Movie < ActiveRecord::Base
  attr_accessible :anime_id, :idstr, :info, :score, :service, :title
end
