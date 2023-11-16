<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static paginate(int $int)
 * @method static findOrFail(string $id)
 * @method static create(array $postData)
 * @method static all()
 * @method static hasFile(string $string)
 * @method static file(string $string)
 * @method static store(string $string, string $string1)
 * @method static fill(array $postData)
 * @method static find(string $id)
 * 
 */
class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'category_id',
        'image',
        'description'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
