<?php

namespace App\Traits\Api;

use App\Models\BannedWord;
use Illuminate\Support\Facades\Cache;

trait BannedWordsTrait
{
    protected function filterBannedWords($text)
    {
        $bannedWords = Cache::remember('banned_words', 30 * 60 * 60, function () {
            return BannedWord::pluck('word')->toArray();
        });

        $textWords = explode(' ', $text);
        foreach ($textWords as $word) {
            if (in_array($word, $bannedWords)) {
                $text = str_replace($word, '**', $text);
            }
        }
        return $text;
    }
}
