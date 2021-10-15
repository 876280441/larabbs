<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

/**
 * 上传图片到阿里云
 *
 * @param   $path   要保存的路径
 * @param   $file   上传的文件
 * @param   $drive  要使用的驱动
 * @return  url     图片完全路径
 */
function upload_image($path, $file, $drive = 'oss')
{
    $disk = Storage::disk($drive);

    //将图片上传到OSS中，并返回图片路径信息 值如:avatar/WsH9mBklpAQUBQB4mL.jpeg
    $path = $disk->put($path, $file);

    //由于图片不在本地，所以我们应该获取图片的完整路径，
    //值如：https://test.oss-cn-hongkong.aliyuncs.com/avatar/8GdIcz1NaCZ.jpeg
    return $disk->url($path);
}

/*
 * 获取当前选中栏目
 */
function category_nav_active($category_id)
{
    return active_class((if_route('categories.show') && if_route_param('category', $category_id)));
}

/*
 * 过滤文章的内容
 */
function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return \Illuminate\Support\Str::limit($excerpt, $length);
}

/*
 * 连接后台模型
 */
function model_admin_link($title, $model)
{
    return model_link($title, $model, 'admin');
}

function model_link($title, $model, $prefix = '')
{
    // 获取数据模型的复数蛇形命名
    $model_name = model_plural_name($model);
    //初始化前缀
    $prefix = $prefix ? "/$prefix/" : "/";
    //使用站点URL拼接全量URL
    $url = config('app.url') . $prefix . $model->name . '/' . $model->id;
    //拼接HTML A 标签 并返回
    return '<a href="' . $url . '" target="_blank">' . $title . '</a>';
}

function model_plural_name($model)
{
    // 从实体中获取完整类名，例如：App\Models\User
    $full_class_name = get_class($model);
    // 获取基础类名，例如：传参 `App\Models\User` 会得到 `User`
    $class_name = class_basename($full_class_name);
    //蛇形命名，例如：传参 `User`  会得到 `user`, `FooBar` 会得到 `foo_bar`
    $snake_case_name = \Illuminate\Support\Str::snake($class_name);
    // 获取子串的复数形式，例如：传参 `user` 会得到 `users`
    return \Illuminate\Support\Str::plural($snake_case_name);

}


