<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pantry extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'barangay', 'city', 'province', 'region', 'contacts_id', 'accounts_id', 'source'];

    protected $hidden = ['contact_id', 'account_id', 'created_at', 'updated_at'];

    /**
     * Show contact info of the Pantry contact person
     *
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'id', 'contact_id');
    }

    /**
     * Show accounts of the Pantry
     *
     * @return HasMany
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, 'id', 'account_id');
    }

    /**
     * Show contributor of the Pantry Item
     *
     * @return HasOne
     */
    public function contributor(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'contributor_id');
    }

    /**
     * Show verifier of the Pantry Item
     *
     * @return HasOne
     */
    public function verifier(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'verifier_id')->select('name','email');
    }
}
