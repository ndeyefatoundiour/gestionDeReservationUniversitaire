<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $table = 'salles';

    public const TYPES = ['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion'];

    protected $fillable = [
        'nom', 
        'batiment', 
        'capacite', 
        'type', 
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
        'capacite' => 'integer',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'salle_id');
    }
}
