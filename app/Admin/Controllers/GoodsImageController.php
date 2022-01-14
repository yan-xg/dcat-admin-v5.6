<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class GoodsImageController extends Controller
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

    /**
     * 富文本编辑器上传图片
     * @param Request $request
     * @return array
     */
    public function wangUploadImage(Request $request){
        $count = count($_FILES);
        if($count > 1){
            foreach ($_FILES as $k=>$v){
                $url[] = $this->uploadImage($_FILES[$k]);
            }
        }elseif($count == 1){
            $url[] = $this->uploadImage($_FILES['image']);
        }
        $data['data'] = $url ? $url : '';
        $data['errno']   = 0;
        return json_encode($data,JSON_UNESCAPED_SLASHES);
    }

    public function uploadImage($image){
        if(!$image){
            return '图片为空';
        }

        //获取临时存储路径
        $temp_file = $image['tmp_name'];

        $ext = explode(".", $image["name"]);
        $ext = $ext[count($ext) - 1];
        $fileName = md5(date('Y-m-d-H-i-s') . '-' . uniqid()) . '.' . $ext;
        $filePath = public_path() . '/storage/tinymce/images/';

        if(move_uploaded_file($temp_file,$filePath.$fileName)){
            return [
                'url' => config('app.url') .'/storage/tinymce/images/'.$fileName
            ];
        }
    }
}
