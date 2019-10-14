<?php

namespace app\helpers;

class StringHelper
{
    public static function getRandomString(int $length, $useSpecialCharacters = false): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($useSpecialCharacters) {
            $characters .= "!@#$%^&*()_+~`.?/";
        }
        $characters = str_split($characters);
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[rand(0, count($characters) - 1)];
        }
        return $result;
    }
}