<?php

namespace Provider\Time;

class Now
{
  public static function now(string $time)
  {
    return new \System\Time\Now($time);
  }
}
