<?php
namespace App\traits;
use Illuminate\Database\DBAL\TimestampType;

trait UploadImg {

  public function uplodIgmage($file,$folder,$disk="public") {
    $filename = $file->getClientOriginalName();
    $file_name = now()->timestamp .'.' . $filename;
    $path = $file->storeAs($folder,$file_name,$disk);
    return $path ;
  }
}
