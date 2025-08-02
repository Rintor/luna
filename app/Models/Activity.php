<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }

    // Получить все дочерние виды деятельности до 3 уровней вложенности (включая себя)
    public function getDescendantsWithLimit(int $depth = 3)
    {
        $result = collect([$this]);

        $this->load('children');

        if ($depth > 1) {
            foreach ($this->children as $child) {
                $result = $result->merge($child->getDescendantsWithLimit($depth - 1));
            }
        }

        return $result;
    }
}
