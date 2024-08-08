<?php
namespace App\Models\Traits;

use App\Models\Scopes\TransactionAccountHolderScope;

trait AccountHolderId {

    protected static function bootAccountHolderId()
    {
        static::addGlobalScope(new TransactionAccountHolderScope);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->account_profile_id = TransactionAccountHolderScope::getAccountProfileID();
        });
    }
}