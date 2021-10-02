<?php


namespace App\Handlers;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ImageUploadHandler
{
    //只允许以下后缀名的文件上传
    protected $allowed_ext = ["png", 'jpg', 'gif', 'jpeg'];

    /*
     * 保存图片类
     */
    public function save($file, $folder, $file_prefix, $max_width = false)
    {
        //构建存储的文件夹规则
        //例如，这里的值为uploads/images/avatars/202110/02
        $folder_name = "uploads/images/$folder/" . date("Ym/d", time());
        //文件的具体存储路径 public_path()是值获取当前public文件夹的物理路径
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/202110/02
        $upload_path = public_path() . '/' . $folder_name;
        //获取文件的后缀名，因为图片从剪切板黏贴时后缀名是空的，所以需要确保后缀名一种存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';
        //拼接文件名，加前缀是为了好区分而已，前缀可以是数据相关的模型id
        // 例如：1_1493521050_7BVc9v9ujP.png
        $filename = $file_prefix . '_' . time() . '_' . Str::random(10) . '.' . $extension;
        //如果删除的不是图片，就终止操作
        if (!in_array($extension, $this->allowed_ext)) {
            return false;
        }
        //将图片移动存储路径中
        $file->move($upload_path, $filename);
        //如果限制了图片宽度，就进行裁剪
        if ($max_width && $extension != 'gif') {
            //此类中封装的函数，用于裁剪图片
            $this->reduceSize($upload_path.'/'.$filename, $max_width);
        }
        return [
            'path' => config('app.url') . "/$folder_name/$filename"
        ];
    }

    /*
     * 裁剪图片
     */
    public function reduceSize($file_path, $max_width)
    {
        //先实例化，传参是文件的磁盘文件路径
        $image = Image::make($file_path);
        //进行大小的调整
        $image->resize($max_width, null, function ($constraint) {
            //设定宽度是$max_width,高度等比例缩放
            $constraint->aspectRatio();
            //防止裁图时图片尺寸变大
            $constraint->upsize();
        });
        //对图片修改后保存
        $image->save();
    }
}
