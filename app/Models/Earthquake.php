<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Earthquake extends Model
{
    //
    use HasFactory;
    protected $fillable = ['date', 'location', 'intensity_scale'];
    protected $casts = [
    'date' => 'date',
];

     public function disasterReports()
    {
        return $this->hasMany(DisasterReport::class, 'disaster_id')
                    ->where('disaster_type', 'earthquake');
    }

}
