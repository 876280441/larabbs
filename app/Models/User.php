<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailTrait;
use Psy\Util\Str;
use Spatie\Permission\Traits\HasRoles;

//继承发送邮箱接口类
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory;

    //引入邮箱验证类
    use MustVerifyEmailTrait;

    use Notifiable;

    //获取到扩展包提供的所有权限和角色的操作方法
    use HasRoles;

    /*
     * 评论通知
     */
    public function topicNotify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->notify($instance);
    }

    /**
     * 可批量赋值
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'introduction',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
     * 访问器 --头像连接字段
     */
    public function getAvatarAttribute($value)
    {
        if (empty($value)) {
            return 'https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/60';
        }
        return $value;
    }

    /*
     * 用户与话题  一对多
     */
    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    /*
   * 使用策略验证是否为有权限用户
   */
    public function isAuthorOf($model)
    {
        return $model->user_id == $this->id;
    }

    /*
     * 与评论关联
     * 一个用户可以有多条关联
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /*
     * 将密码加密处理
     */
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {
            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }
        $this->attributes['password'] = $value;
    }

    /*
     * 为头像拼接
     */
    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if (!   \Illuminate\Support\Str::startsWith($path, 'http')) {
            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }
        $this->attributes['avatar'] = $path;
    }
}
