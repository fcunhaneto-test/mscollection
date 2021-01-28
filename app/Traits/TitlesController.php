<?php

namespace App\Traits;

trait TitlesController
{
    public function frontendStart($channel, $per_page = 10)
    {
        return $this->table->frontendStart($channel, $per_page);
    }

    public function frontendPage($channel, $offset, $per_page)
    {
        return $this->table->frontendPage($channel, $offset, $per_page);
    }

    public function frontendSearchYear($channel, $year) {
        return $this->table->frontendSearchYear($channel, $year);
    }

    public function frontendSearchRating($channel, $rating) {
        return $this->table->frontendSearchRating($channel, $rating);
    }

    public function frontendSearchCategory($channel, $category) {
        return $this->table->frontendSearchCategory($channel, $category);
    }

    public function channelTitles($channel) {
        return $this->table->channelTitles($channel);
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
