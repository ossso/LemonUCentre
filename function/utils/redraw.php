<?php

namespace LemonUCentre\Utils;

/**
 * 图片重绘
 */
class Redraw {
    /**
     * 缩放图片
     * @param string $sourceFilePath 原图路径 *
     * @param string $saveFilePath 新图路径 *
     * @param string $outputType 输出图片格式 *
     * @param int $newWidth 新图宽
     * @param int $newHeight 新图高
     * @param array $mode 裁图模式
     *  - 自动缩放到对应大小
     *  - [[left, center, right], [top, center, bottom]] 
     *  - array[0] 宽大于设定的长比例，裁剪位置；
     *  - array[1] 长大于设定的宽比例，裁剪位置；
     */
    public function redraw($sourceFilePath, $saveFilePath, $outputType, $newWidth = null, $newHeight = null, $mode = ['center', 'top']) {
        //获取图片尺寸
        list($sourceWidth, $sourceHeight) = getimagesize($sourceFilePath);
        // 创建新的图像
        if (!$newWidth) {
            $newWidth = $sourceWidth;
        }
        if (!$newHeight) {
            $newHeight = $sourceHeight;
        }
        $cropWidth = $sourceWidth;
        $cropHeight = $sourceHeight;
        // 画布绘制原图的XY起点坐标
        $x = 0;
        $y = 0;
        // 裁剪判断
        if ($newWidth / $newHeight != $sourceWidth / $sourceHeight) {
            if ($sourceWidth > $sourceHeight) {
                // $mode[0]
                $cropWidth = $newWidth * ($sourceHeight / $newHeight);
                if ($mode[0] = 'left') {
                    $x = 0;
                } else if ($mode[0] = 'right') {
                    if ($cropWidth > $sourceWidth) {
                        $x = $sourceWidth;
                    } else {
                        $x = $sourceWidth - $cropWidth;
                    }
                } else { // center
                    $x = ($sourceWidth - $cropWidth) / 2;
                    $x = abs($x);
                }
                if ($newWidth > $sourceWidth) {
                    $newWidth = $cropWidth;
                    $newHeight = $cropHeight;
                }
            } else {
                $cropHeight = $newHeight * ($sourceWidth / $newWidth);
                if ($mode[0] = 'top') {
                    $y = 0;
                } else if ($mode[0] = 'bottom') {
                    if ($cropHeight > $sourceHeight) {
                        $y = $sourceHeight;
                    } else {
                        $y = $sourceHeight - $cropHeight;
                    }
                } else { // center
                    $y = ($sourceHeight - $cropHeight) / 2;
                    $y = abs($y);
                }
                if ($newHeight > $sourceHeight) {
                    $newWidth = $cropWidth;
                    $newHeight = $cropHeight;
                }
            }
        }
        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        // 自动白图背景
        $autoWhiteBG = imagecolorallocate($newImage, 255, 255, 255);
        imagefill($newImage, 0, 0, $autoWhiteBG);
        // 用资源图片创建图像
        $sourceImage = imagecreatefromstring(file_get_contents($sourceFilePath));
        if (!$sourceImage) {
            return false;
        }
        // 拷贝资源图片到新图像
        $status = imagecopyresampled($newImage, $sourceImage, 0, 0, $x, $y, $newWidth, $newHeight, $cropWidth, $cropHeight);
        // 保存新图片
        $outputType = strtolower($outputType);
        switch ($outputType) {
            default:
            case 'png':
                imagepng($newImage, $saveFilePath);
            break;
            case 'gif':
                imagegif($newImage, $saveFilePath);
            break;
            case 'jpg':
            case 'jpeg':
                imagejpeg($newImage, $saveFilePath);
            break;
        }
        // 销毁图片对象
        imagedestroy($newImage);
        imagedestroy($sourceImage);
        return $status;
    }
}
