<?php

namespace App\Models;

use App\Models\Producers\Director;
use App\Models\Qualifiers\Media;
use App\Traits\TitlesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Movie extends Model
{
    use SoftDeletes, TitlesModel;

    protected $table = 'movies';
    protected $dates = ['deleted_at'];
    protected $arrLetterExist = [];

    public function media()
    {
        return $this->belongsToMany(Media::class)->withPivot('active', 'slug');
    }

    public function directors()
    {
        return $this->belongsToMany(Director::class)->withPivot('order');
    }

    public function frontendStart($channel, $per_page)
    {
        $total = DB::table('media_movie')
            ->where('slug', '=', $channel)
            ->count('movie_id');
        $pages = ceil($total / $per_page);
        $movies = $this->leftJoin('media_movie', 'movies.id', '=', 'media_movie.movie_id')
            ->where('media_movie.active', '=', true)
            ->where('media_movie.slug', '=', $channel)
            ->select('movies.*')
            ->orderBy('movies.title')
            ->limit($per_page)->get();
        return [$pages, $movies];
    }

    public function frontendPage($channel, $offset, $per_page)
    {
        return $this->leftJoin('media_movie', 'movies.id', '=', 'media_movie.movie_id')
            ->where('media_movie.active', '=', true)
            ->where('media_movie.slug', '=', $channel)
            ->select('movies.*')
            ->orderBy('movies.title')
            ->offset($offset)
            ->limit($per_page)->get();
    }

    public function frontendSearchYear($channel, $year) {
        return $this->leftJoin('media_movie', 'movies.id', '=', 'media_movie.movie_id')
            ->where('media_movie.slug', '=', $channel)
            ->where('movies.year', '=', $year)
            ->select('movies.*')
            ->orderBy('movies.title')->get();
    }

    public function frontendSearchTime($channel, $start, $end) {
        return $this->leftJoin('media_movie', 'movies.id', '=', 'media_movie.movie_id')
            ->where('media_movie.slug', '=', $channel)
            ->whereBetween('movies.time', [$start, $end])
            ->select('movies.*')
            ->orderBy('movies.title')->get();
    }

    public function frontendSearchRating($channel, $rating) {
        return $this->leftJoin('media_movie', 'movies.id', '=', 'media_movie.movie_id')
            ->where('media_movie.slug', '=', $channel)
            ->where('movies.rating', '=', $rating)
            ->select('movies.*')
            ->orderBy('movies.title')->get();
    }

    public function frontendSearchCategory($channel, $category)
    {
        $query = DB::select(
            DB::raw("
                        SELECT * FROM movies AS m
                        LEFT JOIN media_movie AS mm ON mm.movie_id = m.id
                        WHERE mm.slug = '$channel' AND (m.category_1 = '$category' OR m.category_2 = '$category')
                        ORDER BY FIELD(m.category_1, '$category') DESC, title
                   "));
        return $query;
    }

    public function adminSearchCategory($category)
    {
        $query = DB::select(
            DB::raw("
                        SELECT * FROM movies
                        WHERE category_1 = '$category' OR category_2 = '$category'
                        ORDER BY FIELD(category_1, '$category') DESC, title
                   "));
        return $query;
    }

    public function channelTitles($channel) {
        return $this->leftJoin('media_movie', 'movies.id', '=', 'media_movie.movie_id')
            ->leftJoin('media', 'media_movie.media_id', '=', 'media.id')
            ->where('media.slug', '=', $channel)
            ->where('media.isstream', '=', true)
            ->select('movies.id', 'movies.title')
            ->orderBy('movies.title')->get();
    }

    public function cast($id)
    {
        return DB::table('cast_movie')
            ->leftJoin('cast', 'cast_movie.cast_id', '=', 'cast.id')
            ->leftJoin('actors', 'cast.actor_id', '=', 'actors.id')
            ->leftJoin('characters', 'cast.character_id', '=', 'characters.id')
            ->where('cast_movie.movie_id', '=', $id)
            ->where('cast_movie.order', '<', 6)
            ->select('cast_movie.*', 'actors.name as actor', 'characters.name as character',
                'cast.actor_id', 'cast.character_id')->get();
    }

}
