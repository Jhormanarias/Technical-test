<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model {

    use SoftDeletes;

    protected $fillable = ['name'];

    public function contacts() {
        return $this->hasMany(Contact::class);
    }

    public function notes() {
        return $this->morphMany(Note::class, 'noteable');
    }
}

