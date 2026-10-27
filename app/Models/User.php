<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * المستخدم لديه ملف شخصي واحد.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * المستخدم يمكن أن يمتلك عدة أدوار.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    /**
     * المستخدم لديه عدة مهارات.
     */
    public function userSkills(): HasMany
    {
        return $this->hasMany(UserSkill::class);
    }

    /**
     * الخدمات التي يقدمها المستخدم.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * الأعمال التي قدم فيها المستخدم الخدمة.
     */
    public function providedVerifiedWorks(): HasMany
    {
        return $this->hasMany(VerifiedWork::class, 'provider_id');
    }

    /**
     * الأعمال التي كان المستخدم فيها عميلًا.
     */
    public function receivedVerifiedWorks(): HasMany
    {
        return $this->hasMany(VerifiedWork::class, 'client_id');
    }

    /**
     * جوازات المهارات الخاصة بالمستخدم.
     */
    public function skillPassports(): HasMany
    {
        return $this->hasMany(SkillPassport::class);
    }

    /**
     * المفضلات التي أضافها المستخدم.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * المستخدمون الذين أضافهم هذا المستخدم للمفضلة.
     */
    public function favoriteUsers(): HasMany
    {
        return $this->hasMany(Favorite::class, 'favorite_user_id');
    }

    /**
     * المحادثات التي يشارك فيها المستخدم.
     */
    public function conversationParticipants(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    /**
     * الرسائل التي أرسلها المستخدم.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * الإشعارات الخاصة بالمستخدم.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * الشارات التي حصل عليها المستخدم.
     */
    public function badges(): HasMany
    {
        return $this->hasMany(UserBadge::class);
    }

    /**
     * البلاغات التي أنشأها المستخدم.
     */
    public function reportsCreated(): HasMany
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }

    /**
     * البلاغات التي تم الإبلاغ فيها عن المستخدم.
     */
    public function reportsReceived(): HasMany
    {
        return $this->hasMany(Report::class, 'reported_user_id');
    }

    /**
     * سجلات الأنشطة التي قام بها المستخدم.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * إعدادات المستخدم.
     */
    public function settings(): HasMany
    {
        return $this->hasMany(UserSetting::class);
    }

    /**
     * الملفات الخاصة بالمستخدم.
     */
    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }
    public function portfolioItems(): HasMany
{
    return $this->hasMany(PortfolioItem::class);
}
}