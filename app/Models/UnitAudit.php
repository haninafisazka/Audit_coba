<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAudit extends Model
{
    use HasFactory;
    protected $table = 'unit_audits';
    public function periodeAudit()
    {
        return $this->belongsTo(PeriodeAudit::class, 'id_periode_audit');
    }
    public function standarRuangLingkup()
    {
        return $this->hasMany(StandarRuangLingkup::class, 'id_unit_audit');
    }
}
