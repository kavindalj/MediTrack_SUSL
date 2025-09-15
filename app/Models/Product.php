<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'expire_date',
        'entry_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'expire_date' => 'date',
        'entry_date' => 'date',
    ];

    /**
     * Relationship with prescription items
     */
    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    /**
     * Relationship with prescriptions through prescription items
     */
    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'prescription_items')
                    ->withPivot('quantity', 'dosage_instructions')
                    ->withTimestamps();
    }

    /**
     * Check if product has sufficient quantity
     */
    public function hasSufficientQuantity($requestedQuantity)
    {
        return $this->quantity >= $requestedQuantity;
    }

    /**
     * Check if product is expired
     */
    public function isExpired()
    {
        if (!$this->expire_date) {
            return false; // No expiry date means it doesn't expire
        }
        
        return $this->expire_date <= now();
    }

    /**
     * Check if product is available (not expired and has stock)
     */
    public function isAvailable()
    {
        return $this->quantity > 0 && !$this->isExpired();
    }

    /**
     * Get products that are running low on stock
     */
    public static function lowStock($threshold = 10)
    {
        return static::where('quantity', '<=', $threshold)->get();
    }
}
