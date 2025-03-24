<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {

    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'company_id'];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function notes() {
        return $this->morphMany(Note::class, 'noteable');
    }
}

