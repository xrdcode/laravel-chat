<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function chat_messages() {
        return $this->hasMany(ChatMessage::class);
    }
}
