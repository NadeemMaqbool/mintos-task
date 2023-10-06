<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'client_name',
        'email',
        'address'
    ];

    public function accounts() {
        return $this->hasMany(Account::class, 'client_id', 'client_id');
    }

}
