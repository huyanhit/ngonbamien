<?php

namespace App\Modules\Chat\Config;

class Constants
{
    # Cấu hình user setting notification
    public const chat = array (
        'store_file' => 'local',
        'path_folder' => 'chat',
        'thumbnail_separate' => 'thumb_',
        'list_item_file' => 15,
        'image_type' => ['jpg','jpeg','png','gif','webp','apng','avif','pjpeg','jfif','pjp','svg'],
        'video_type' => ['mp4','avi','wmv','ogg','ogv','webm','flv','swf','ram','rm','mov','mpeg','mpg'],
    );
}
