<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Wisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_wisata', 'jenis_wisata', 'alamat', 'geometry', 'kabupaten', 'foto'
    ];
    protected $spatialFields = [
        'geometry'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) Str::uuid();
        });
    }

    
}
