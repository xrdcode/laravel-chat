<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function operator() {
        return $this->belongsTo(Operator::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

}
