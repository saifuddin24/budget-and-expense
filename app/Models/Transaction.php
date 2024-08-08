<?php

namespace App\Models;

use App\Models\Traits\AccountHolderId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Transaction extends Model
{
    const UPDATED_AT = NULL;
    use HasFactory, SoftDeletes, AccountHolderId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'account_profile_id',
        'category_id',
        'budget_id',
        'cash_amount',
        'cash_trx_type',
        'bank_amount',
        'bank_trx_type',
        'trx_year',
        'trx_month'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'account_profile_id' => 'integer',
        'category_id' => 'integer',
        'cash_amount' => 'double',
        'bank_amount' => 'double',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
 

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function accountProfile(): BelongsTo
    {
        return $this->belongsTo(AccountProfile::class);
    }

    public static function getYearMonth(){

        $trx_months = self::select('trx_month', 'trx_year' )->distinct()->orderBy('trx_year')->get();
        return self::select('trx_year' )
            ->distinct()
            ->orderBy('trx_year')
            ->get()
            ->map(function($year) use($trx_months){
                return [
                    'year' => $year->trx_year,
                    'months' => $trx_months->where( 'trx_year', $year->trx_year )->map(function($ym){
                        return  $ym->trx_month;
                    })->values(),
                ];
            });

    }
    
}
