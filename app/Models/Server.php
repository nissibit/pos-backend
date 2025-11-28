<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Server extends Model implements Auditable {

    use \Illuminate\Database\Eloquent\SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    
     protected $softCascade = [
        'account', 'invoices'
    ];
    
    protected $fillable = [
        'fullname',
        'nuit',
        'type',
        'document_type',
        'document_number',        
        'phone_nr',
        'phone_nr_2',
        'email',        
        'address',        
        'description',        
    ];
    public function generateTags(): array {
        return [
            'Supplier'
        ];
    }
    
    public function account() {
        return $this->morphOne(Account::class, 'accountable');
    }
    
    public function invoices() {
        return $this->hasManyThrough(Invoice::class, Account::class, 'accountable_id');
    }
}
