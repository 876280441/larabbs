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
function category_nav_active($category_id){
    return active_class((if_route('categories.show')&&if_route_param('category', $category_id)));
}

/*
 * 过滤文章的内容
 */
function make_excerpt($value,$length = 200){
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return \Illuminate\Support\Str::limit($excerpt,$length);
}
