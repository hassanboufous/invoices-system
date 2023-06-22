<?php
namespace App\traits;


trait UploadImageTrait {

    public function UploadImg($folder,$image,$disk="public") {

        $file_extention = $image->getClientOriginalExtension();
        $file_name = now()->timestamp.'.'.$file_extention;
        $file_path = $image->storeAs($folder,$file_name,$disk);
        return $file_path;
    }
}
