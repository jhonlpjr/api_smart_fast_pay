<?php

namespace app\modules\payment\infraestructure\database\models;

use app\modules\paymentmethod\infraestructure\database\models\PaymentMethodModel;
use app\modules\user\infraestructure\database\models\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'customer_name',
        'cpf',
        'description',
        'value',
        'status',
        'payment_method',
        'payment_date',
    ];

    /**
     * Get the user that owns the payment.
     */
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'cpf', 'identity_document');
    }

    /**
     * Get the payment method associated with the payment.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethodModel::class, 'payment_method', 'slug');
    }
}