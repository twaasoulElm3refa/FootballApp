<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteFixtures extends Model
{
    protected $table = 'favourite_fixtures';
    protected $guarded = [];

    public function fixture()
    {
        return $this->belongsTo(Fixtures::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
