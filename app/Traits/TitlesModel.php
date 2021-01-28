<?php

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait TitlesModel
{
    public function titlesLetterExist()
    {
        $letters = Config::get('msvars.letters');
        $result = $this->whereRaw('title REGEXP "^[^a-zàáâãäåçèéêëìíîïñòóôõöoùüúÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖOÙÜÚ]"')->first();
        if ($result) {
            $this->arrLetterExist[0] = ['letter' => $letters[0], 'exist' => true];
        } else {
            $this->arrLetterExist[0] = ['letter' => $letters[0], 'exist' => false];
        }
        for ($i = 1; $i < 27; $i++) {
            $result = $this->where('title', 'LIKE', $letters[$i] . '%')->first();
            if ($result) {
                $this->arrLetterExist[$i] = ['letter' => $letters[$i], 'exist' => true];;
            } else {
                $this->arrLetterExist[$i] = ['letter' => $letters[$i], 'exist' => false];
            }
        }
        return $this->arrLetterExist;
    }

    public function letterPagination($letter)
    {
        if ($letter == '@') {
            return $this->whereRaw('title REGEXP "^[^a-zàáâãäåçèéêëìíîïñòóôõöoùüúÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖOÙÜÚ]"')
                ->orderBy('title')->get();
        }
        return $this->where('title', 'like', $letter . '%')->orderBy('title')->get();
    }
}
