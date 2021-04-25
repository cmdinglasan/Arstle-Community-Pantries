<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pantry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'barangay', 'city', 'province', 'region', 'contacts_id', 'accounts_id', 'source'];

    protected $hidden = ['id', 'contact_id', 'account_id', 'created_at', 'updated_at'];

    public function contacts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id');
    }

    public function accounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Account::class, 'id', 'account_id');
    }
}
