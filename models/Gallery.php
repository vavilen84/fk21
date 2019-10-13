<?php

namespace app\models;

use Yii;

class Gallery
{
    const PORTFOLIO = [
        'id' => 1,
        'title' => 'Портфолио'
    ];

    public $id;
    public $title;

    public static function getList(): array
    {
        $portfolio = new Gallery();
        $portfolio->id = self::PORTFOLIO['id'];
        $portfolio->title = self::PORTFOLIO['title'];

        $result = [];
        $result[self::PORTFOLIO['id']] = $portfolio;

        return $result;
    }

    public static function findById(int $id): ?Gallery
    {
        $list = self::getList();
        if (isset($list[$id])) {
            return $list[$id];
        }
        return null;
    }
}