<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'notes',
        'medicine_names',
        'total_items',
        'total_quantity',
        'prescription_number',
        'pdf_generated'
    ];

    protected $casts = [
        'medicine_names' => 'array',
        'pdf_generated' => 'boolean'
    ];

    /**
     * Generate a unique prescription number
     */
    public static function generatePrescriptionNumber()
    {
        do {
            $number = 'RX-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('prescription_number', $number)->exists());
        
        return $number;
    }

    /**
     * Relationship with prescription items
     */
    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    /**
     * Relationship with products through prescription items
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'prescription_items')
                    ->withPivot('quantity', 'dosage_instructions')
                    ->withTimestamps();
    }

    /**
     * Boot method to auto-generate prescription number
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($prescription) {
            if (empty($prescription->prescription_number)) {
                $prescription->prescription_number = self::generatePrescriptionNumber();
            }
        });
    }
}
