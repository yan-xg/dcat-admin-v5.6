<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Traits\HasUploadedFile;

class GoodsImageController
{
    use HasUploadedFile;

    public function handle()
    {
        $disk = $this->disk('goods_uploads');

        // 判断是否是删除文件请求
        if ($this->isDeleteRequest()) {
            // 删除文件并响应
            return $this->deleteFileAndResponse($disk);
        }

        // 获取上传的文件
        $file = $this->file();

        // 获取上传的字段名称
        $column = $this->uploader()->upload_column;

        $image_upload = config('dictionary.goods.image_upload');
        $newName = md5(uniqid()).'.'.$file->getClientOriginalExtension();

        $result = $disk->putFileAs($image_upload, $file, $newName);

        $path = "{$image_upload}/$newName";

        return $result ? $this->responseUploaded($path, $disk->url($path)) : $this->responseErrorMessage('文件上传失败');
    }
}
