<?php

namespace App\Traits;

trait TitlesController
{
    /**
     * Create first page display channel per page.
     *
     * @param $channel
     * @param int $per_page
     * @return mixed
     */
    public function frontendStart($channel, $per_page = 10)
    {
        return $this->table->frontendStart($channel, $per_page);
    }

    /**
     * Return resource by channel per page.
     *
     * @param $channel
     * @param $offset
     * @param $per_page
     * @return mixed
     */
    public function frontendPage($channel, $offset, $per_page)
    {
        return $this->table->frontendPage($channel, $offset, $per_page);
    }

    /**
     * Returns the channel resource selected by year.
     *
     * @param $channel
     * @param $year
     * @return mixed
     */
    public function frontendSearchYear($channel, $year) {
        return $this->table->frontendSearchYear($channel, $year);
    }

    /**
     * Return the channel resource selected by rating.
     *
     * @param $channel
     * @param $rating
     * @return mixed
     */
    public function frontendSearchRating($channel, $rating) {
        return $this->table->frontendSearchRating($channel, $rating);
    }

    /**
     * Return the channel resource selected by category.
     *
     * @param $channel
     * @param $category
     * @return mixed
     */
    public function frontendSearchCategory($channel, $category) {
        return $this->table->frontendSearchCategory($channel, $category);
    }

    /**
     * Return the channel resource by titles.
     * @param $channel
     * @return mixed
     */
    public function channelTitles($channel) {
        return $this->table->channelTitles($channel);
    }

    /**
     * Return the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        return $this->table->where('id', '=', $id)->get();
    }

    public function adminStart(): array
    {
        $exist = $this->table->titlesLetterExist();
        for ($i = 0; $i < 26; $i++) {
            if ($exist[$i]['exist']) {
                $letter = $exist[$i]['letter'];
                return [$exist, $letter, $this->table->letterPagination($exist[$i]['letter'])];
            }
        }
    }

    public function adminLetter($letter)
    {
        return $this->table->letterPagination($letter);
    }

    public function cast($id)
    {
        return $this->table->cast($id);
    }

    public function category($category)
    {
        return $this->table->adminSearchCategory($category);
    }

    public function keyword($name)
    {
        return $this->table->keyword($name);
    }

    public function year($year)
    {
        return $this->table->where('year', '=', $year)->orderBy('title')->get();
    }

}
