<?php

/**
 * Created by PhpStorm.
 * User: ydm5-01
 * Date: 2017/4/12
 * Time: 15:22
 */
class ImageModel extends Model
{
    /**
     * 图片支持的类型
     * @var array
     */
    private $mime = [
        'image/jpeg'=>'jpeg',
        'image/png'=>'png',
        'image/gif'=>'gif'
    ];
    /**
     * 制作缩略图
     * @param $src_path 原图路径
     * @param $max_width 缩略的宽度
     * @param $max_height 缩略图的高度
     */
    public function thumb($src_path,$max_width,$max_height){

        //获取原图的宽高
        $src_path = UPLOADS_PATH.$src_path;
        if(!is_file($src_path)){
            $this->error = "原图不存在！";
            return false;
        }

        //获取原图信息
        $src_imagesize = getimagesize($src_path);
        $mime = $src_imagesize['mime'];//获取图片类型
        list($src_width,$src_height) = $src_imagesize;

        //获取创建图片的方法
        $createFunc = 'imagecreatefrom'.$this->mime[$mime];
        $src_img = $createFunc($src_path);//可变方法
        /**
         * 2.准备一张新的画布
         */

        $thumb_img = imagecreatetruecolor($max_width,$max_height);

        //补白
        //选择颜色
        $white = imagecolorallocate($thumb_img,255,255,255);
        //填充
        imagefill($thumb_img,0,0,$white);


        //等比例缩放
        //1.计算最大缩放比例
        /**
         * 原图的宽高/目标图片的宽高
         */
        $scale = max($src_width/$max_width,$src_height/$max_height);
        /**
         * 3.将原图拷贝到新画布上面
         */
        /**
         * imagecopyresampled (
         * resource $dst_image , 目标图片资源
         * resource $src_image , 原图资源
         * int $dst_x , int $dst_y , 目标图片的起始坐标
         * int $src_x , int $src_y ,  原图的起始位置，开始拷贝的位置
         * int $dst_w , int $dst_h ,  目标图片的宽高
         * int $src_w , int $src_h    原图图片的宽高
         * )

         */
        /**
         * 计算缩放后的宽高
         */
        $thumb_width = $src_width/$scale;
        $thumb_height = $src_height/$scale;

        imagecopyresampled($thumb_img,$src_img,($max_width-$thumb_width)/2,($max_height-$thumb_height)/2,0,0,$thumb_width,$thumb_height,$src_width,$src_height);


        //输出图片
//        header('Content-Type: image/png;charset=utf-8');
        /**
         * 保存图片到制定路径
         * 原路径后面加上一个后缀，代表他的尺寸大小
         * goods/20170412/IT_58ed8d94abfd8.png
         * 缩略后的路径
         * goods/20170412/IT_58ed8d94abfd8_80x80.png
         */
        $pathinfo = pathinfo($src_path);
        $filename = $pathinfo['dirname'].'/'.$pathinfo['filename']."_{$max_width}x{$max_height}.".$pathinfo['extension'];

        //获取图片输出方法
        $outFunc = "image".$this->mime[$mime];
        $outFunc($thumb_img,$filename);

        //销毁图片
        imagedestroy($src_img);
        imagedestroy($thumb_img);

        //返回缩略图路径
        return str_replace(UPLOADS_PATH,'',$filename);
    }
}