<?php

namespace App\Helpers;

use Carbon\Carbon;

class Time{
  public function time(){
    Carbon::setLocale('id');
    return date_default_timezone_set('Asia/Jakarta');
  }
}