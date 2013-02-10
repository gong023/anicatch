class CreateMovies < ActiveRecord::Migration
  def change
    create_table :movies do |t|
      t.integer :service
      t.string :idstr
      t.string :title
      t.integer :score
      t.integer :anime_id
      t.binary :info

      t.timestamps
    end
  end
end
