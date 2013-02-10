class CreateAnimes < ActiveRecord::Migration
  def change
    create_table :animes do |t|
      t.string :title
      t.integer :day_of_week
      t.string :description
      t.integer :point
      t.integer :year
      t.integer :season
      t.integer :point
      t.binary :info

      t.timestamps
    end
  end
end
