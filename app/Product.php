<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const PRODUCT_AVAILABLE = 'available';
    const PRODUCT_UNAVAILABLE = 'unavailable';

    protected $fillable = [
		'name',
		'description',
		'quantity',
		'seller_id',
		'image',
		'status'
	];

	public function isAvailable() 
	{
		return $this->status == self::PRODUCT_AVAILABLE;
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function seller() 
	{
		return $this->belongsTo(Seller::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}
}
