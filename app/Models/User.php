<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordNotification;
use Laragear\TwoFactor\TwoFactorAuthentication;
use Laragear\TwoFactor\Contracts\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password', 'locale', 'avatar', 'background_image', 'two_factor_enabled', 'two_factor_code', 'two_factor_expires_at','typography_size', 'reduce_motion', 'email_notifications', 'push_notifications'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements TwoFactorAuthenticatable
{
    use TwoFactorAuthentication;
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
        ];
    }
    public function preferredLocale(): string
    {
        return $this->locale ?? config('app.locale');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function memories()
    {
        return $this->hasMany(Memory::class);
    }
    
}
