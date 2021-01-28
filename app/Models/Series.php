<?php

namespace App\Models;

use App\Models\Qualifiers\Media;
use App\Traits\TitlesModel;
use Carbon\Traits\Creator;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Series extends Model
{
    use SoftDeletes, CascadeSoftDeletes, TitlesModel;

    protected $table = 'series';
    protected $dates = ['deleted_at'];
    protected $cascadeDeletes = ['seasons'];
    protected $arrLetterExist = [];

    public function media()
    {
        return $this->belongsToMany(Media::class)->withPivot('active', 'slug');
    }

    public function creators()
    {
        return $this->belongsToMany(Creator::class)->withPivot('order');
    }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function frontendStart($channel, $per_page)
    {
        $total = DB::table('media_series')
            ->where('slug', '=', $channel)
            ->count('series_id');
        $pages = ceil($total/$per_page);
        $series = $this->leftJoin('media_series', 'series.id', '=', 'media_series.series_id')
            ->where('media_series.active', '=', true)
            ->where('media_series.slug', '=', $channel)
            ->select('series.*')
            ->orderBy('series.title')
            ->limit($per_page)->get();
        return [$pages, $series];
    }

    public function frontendPage($channel, $offset, $per_page) {
        return $this->leftJoin('media_series', 'series.id', '=', 'media_series.series_id')
            ->where('media_series.active', '=', true)
            ->where('media_series.slug', '=', $channel)
            ->select('series.*')
            ->orderBy('series.title')
            ->offset($offset)
            ->limit($per_page)->get();
    }

    public function frontendSearchYear($channel, $year) {
        return $this->leftJoin('media_series', 'series.id', '=', 'media_series.series_id')
            ->where('media_series.slug', '=', $channel)
            ->where('series.year', '=', $year)
            ->select('series.*')
            ->orderBy('series.title')
            ->get();
    }

    public function frontendSearchRating($channel, $rating) {
        return $this->leftJoin('media_series', 'series.id', '=', 'media_series.series_id')
            ->where('media_series.slug', '=', $channel)
            ->where('series.rating', '=', $rating)
            ->select('series.*')
            ->orderBy('series.title')
            ->get();
    }

    public function frontendSearchCategory($channel, $category)
    {
        $query = DB::select(
            DB::raw("
                        SELECT * FROM series AS s
                        LEFT JOIN media_series AS ms ON ms.series_id = s.id
                        WHERE ms.slug = '$channel' AND (s.category_1 = '$category' OR s.category_2 = '$category')
                        ORDER BY FIELD(s.category_1, '$category') DESC, title
                   "));
        return $query;
    }

    public function adminSearchCategory($category)
    {
        $query = DB::select(
            DB::raw("
                        SELECT * FROM series
                        WHERE category_1 = '$category' OR category_2 = '$category'
                        ORDER BY FIELD(category_1, '$category') DESC, title
                   "));
        return $query;
    }


    public function channelTitles($channel) {
        return $this->leftJoin('media_series', 'series.id', '=', 'media_series.series_id')
            ->leftJoin('media', 'media_series.media_id', '=', 'media.id')
            ->where('media.slug', '=', $channel)
            ->where('media.isstream', '=', true)
            ->select('series.id', 'series.title')
            ->orderBy('series.title')->get();
    }

    public function cast($id)
    {
        return DB::table('cast_series')
            ->leftJoin('cast', 'cast_series.cast_id', '=', 'cast.id')
            ->leftJoin('actors', 'cast.actor_id', '=', 'actors.id')
            ->leftJoin('characters', 'cast.character_id', '=', 'characters.id')
            ->where('cast_series.series_id', '=', $id)
            ->where('cast_series.order', '<', 6)
            ->select('cast_series.*', 'actors.name as actor', 'characters.name as character',
                'cast.actor_id', 'cast.character_id')->get();
    }
}
