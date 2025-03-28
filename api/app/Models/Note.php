<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model {

    use SoftDeletes;
    
    protected $fillable = ['content', 'noteable_id', 'noteable_type'];

    public function noteable() {
        return $this->morphTo();
    }
}
