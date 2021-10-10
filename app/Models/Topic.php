<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    //与分类关联
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //与用户关联
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * 话题排序
     */
    public function scopeWithOrder($query, $order)
    {
        //不同的排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
    }

    /*
     * 新话题更新-updated_at时间戳
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /*
     * 按创建时间排序
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
