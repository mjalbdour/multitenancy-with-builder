<?php

namespace App\Models;

use App\Traits\Multitenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    use HasFactory, Multitenantable;

    protected $fillable = ['created_by_user_id', 'company_id', 'value'];

    protected $dates = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'company_id');
    }
}
