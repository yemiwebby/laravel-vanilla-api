<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'subject', 'body', 'attachments'
    ];

    protected $casts = [
        'attachments' => 'array'
    ];

    public function getList()
    {
        return self::all();
    }
}
