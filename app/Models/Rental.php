<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rental extends Model
{
    use HasFactory;

    protected $table = 'rentals';

    protected $primaryKey = 'id';

    protected $fillable = ['car_id', 'customer_id', 'startDate', 'endDate', 'price']; 

    public function car() {
        return $this->hasOne(Car::class);
    }

    public function customer() {
        return $this->hasOne(Customer::class);
    }
}
