<?php
namespace app\api\controller;

use think\Controller;
use think\Session;

/**
 * 通用上传接口
 * Class Upload
 * @package app\api\controller
 */
class Upload extends Controller
{

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-21
     * 上传图片
     */
    public function upload()
    {
        $config = [
            'size' => 20971520,
            'ext'  => 'jpg,gif,png,bmp'
        ];
        $file = $this->request->file('file');
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/Image');
        $save_path   = '/public/uploads/Image/';

        $info        = $file->validate($config)->move($upload_path);
        if ($info) {
            $result = [
                'error' => 0,
                'url'   => HTTP_URL.str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }
        return json($result);
    }

    /**
     * @Author   admin
     * @Email    无
     * @DateTime 2018-11-21
     * 本地上传附件
     */
    public function uploadFile(){
        $config = [
            'size' => 10485760,
            'ext'  => 'docx,doc,txt,rar,xls,xlsx,html,php,jpg,gif,png,bmp,mp3,wav,wma,ogg,ape,acc,pem'
        ];
        $file = $this->request->file('file');
        $upload_path = str_replace('\\', '/', ROOT_PATH . 'public/uploads/File');
        $save_path   = '/public/uploads/File/';
        $info        = $file->validate($config)->move($upload_path);

        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }

        return json($result);
    }
}