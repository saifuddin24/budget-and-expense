<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Budget extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'amount',
        'category_id',
        'is_pined',
        'frequency',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'double',
        'is_pined' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function cash_transactions(): HasMany
    {
        return $this->hasMany( CashTransaction::class );
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }


    
    public function total_cash_transaction( string $year_month = null){

        $transactions = $this->cash_transactions();

        $transactions->when(
            $this->frequency == 'monthly' && $year_month, 
            function($transactions) use( $year_month ){
                $transactions->where( 'year_month', $year_month  );
            }
        );

        $transactions = $transactions->get();

        return $transactions->sum(function($transaction){
            return $transaction->cash_credit_amount - $transaction->cash_debit_amount;
        });
    }
    
    public function total_bank_transaction( string $year_month = null){

        $transactions = $this->cash_transactions();

        $transactions->when(
            $this->frequency == 'monthly' && $year_month, 
            function($transactions) use( $year_month ){
                $transactions->where( 'year_month', $year_month  );
            }
        );

        $transactions = $transactions->get();

        return $transactions->sum(function($transaction){
            return $transaction->bank_credit_amount - $transaction->bank_debit_amount;
        });
    }
}
