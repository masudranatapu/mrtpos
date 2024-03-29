<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function createBy()
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
}
