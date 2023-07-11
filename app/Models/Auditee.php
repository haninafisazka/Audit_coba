<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditee extends Model
{
    use HasFactory;
    protected $table = 'auditees';

    protected $fillable = [
        'id_user',
        'nama_auditee',
        'sub_bagian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
}
