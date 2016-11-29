<?php namespace VojtaSvoboda\Brands\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete as SoftDeletingTrait;
use October\Rain\Database\Traits\Sortable as SortableTrait;
use October\Rain\Database\Traits\Validation as ValidationTrait;

class Brand extends Model
{
    use SoftDeletingTrait;

    use SortableTrait;

    use ValidationTrait;

    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    public $table = 'vojtasvoboda_brands_brands';

    public $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|unique:vojtasvoboda_brands_brands',
        'enabled' => 'boolean',
        'description' => 'max:10000',
    ];

    public $translatable = ['name', 'slug', 'description'];

    public $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $attachOne = [
        'cover' => ['System\Models\File'],
    ];

    public $attachMany = [
        'images' => ['System\Models\File'],
    ];

    public $belongsToMany = [
        'categories' => [
            'VojtaSvoboda\Brands\Models\Category',
            'table' => 'vojtasvoboda_brands_brand_category',
            'order' => 'name asc',
            'scope' => 'isEnabled',
            'timestamps' => true,
        ]
    ];

    public function scopeIsEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
