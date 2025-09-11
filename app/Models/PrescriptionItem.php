<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'prescription_id',
        'product_id',
        'medicine_name',
        'quantity',
        'dosage_instructions'
    ];

    protected $casts = [
        // Remove price casts since we don't use money
    ];

    /**
     * Relationship with prescription
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    /**
     * Relationship with product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Boot method to handle stock reduction when prescription item is created
     */
    protected static function boot()
    {
        parent::boot();
        
        static::created(function ($prescriptionItem) {
            // Reduce product quantity when prescription item is created
            $product = $prescriptionItem->product;
            if ($product) {
                $product->decrement('quantity', $prescriptionItem->quantity);
            }
        });

        static::deleted(function ($prescriptionItem) {
            // Restore product quantity when prescription item is deleted
            $product = $prescriptionItem->product;
            if ($product) {
                $product->increment('quantity', $prescriptionItem->quantity);
            }
        });
    }
}
