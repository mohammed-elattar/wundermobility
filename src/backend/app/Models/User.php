<?php

declare(strict_types=1);

namespace App\Models;

use App\Adapter\WunderfleetPayment;
use App\Http\Requests\UserRegistrationRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [
        'first_name',
        'last_name',
        'telephone',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected array $hidden = [
        'password',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function paymentInfos(): HasMany
    {
        return $this->hasMany(PaymentInfo::class);
    }

   public function register(UserRegistrationRequest $userRegistrationRequest, WunderfleetPayment $wunderfleetPayment): void
   {
       $user = new self();
       $user->first_name = $userRegistrationRequest['first_name'];
       $user->last_name = $userRegistrationRequest['last_name'];
       $user->telephone = $userRegistrationRequest['telephone'];
       $user->password = $userRegistrationRequest['password'];
       $user->save();
       $user->addresses()->create([
           'user_id' => $user->id,
           'street' => $userRegistrationRequest['address']['street'],
           'house_number' => $userRegistrationRequest['address']['house_number'],
           'zip_code' => $userRegistrationRequest['address']['zip_code'],
           'city' => $userRegistrationRequest['address']['city'],
       ]);

       $userPaymentDataId = $wunderfleetPayment->getPaymentDataId(['customerId'=> 1, 'iban' => 'DE8234', 'owner'=> 'Max Mustermann']);
       $user->paymentInfos()->create([
           'user_id' => $user->id,
           'account_owner' => $userRegistrationRequest['payment_infos']['account_owner'],
           'iban' =>$userRegistrationRequest['payment_infos']['iban'],
           'payment_data_id' => $userPaymentDataId,
       ]);
   }
}
