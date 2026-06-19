<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $guarded = false;
    protected $table = 'notes';

    // у каждого пользователя свои заметки
    public function user() {
        return $this->belongsTo(User::class);
    }
}
