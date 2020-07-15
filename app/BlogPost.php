<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;

    // Expacted table name
    // protected $table = 'blogposts'; creatali smo novu migraciju blog_post rename
    protected $fillable = ['title', 'content'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public static function boot() {
        parent::boot();

        // OVO CE SE ZVATI UVIJEK KAD CE SE MODEL OBRISATI
        // bisati ce sve svi related podaci, u ovom slucaju comments
        static::deleting(function(BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::restoring(function(BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
