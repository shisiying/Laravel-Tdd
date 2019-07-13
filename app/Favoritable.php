<?php
/**
 * Created by PhpStorm.
 * User: shisiying
 * Date: 2019-07-08
 * Time: 15:39
 */

namespace App;


trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class,'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (! $this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create(['user_id'=>auth()->id()]);
        }
    }

    public function isFavorited()
    {
        return !! $this->favorites()->where('user_id',auth()->id())->count();
    }


    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}