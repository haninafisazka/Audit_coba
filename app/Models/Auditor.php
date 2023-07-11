<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditor extends Model
{
    use HasFactory;
    protected $table = 'auditor_units';

    protected $fillable = [
        'id_user',
        'id_unit_audit',
        'nama_auditor',
        'nip_auditor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function unit_audit()
    {
        return $this->belongsTo(UnitAudit::class, 'id_unit_audit');
    }
}
