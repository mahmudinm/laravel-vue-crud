<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
		protected $fillable = ['item_id', 'name', 'weight'];

    public function items()
    {
        return $this->belongsTo('App\Item', 'item_id');
    }
}
