<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAudit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function gradesStoring()
    {
        return $this->hasMany(GradeStoring::class);
    }

    public function user()
    {
        return $this->belongsTo(UnitAuditt::class);
    }
}
