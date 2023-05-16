<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'source',
        'owner',
        'created_by'
    ];

    public function hasOwner(){
        return $this->belongsTo(User::class, 'id', 'owner');
    }

    public function hasCreator(){
        return $this->belongsTo(User::class, 'id', 'created_by');
    }
}
