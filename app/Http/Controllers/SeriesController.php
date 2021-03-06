<?php

namespace App\Http\Controllers;

use App\Models\Qualifiers\Media;
use App\Models\Series;
use App\Traits\TitlesController;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    protected $table;

    use TitlesController;

    public function __construct()
    {
        $this->table = new Series();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function producers($id) {
        $series = $this->table->findOrFail($id);
        return $series->creators;
    }

    public function media($id)
    {
        $media = Media::find($id);
        return $media->series;
    }
}
