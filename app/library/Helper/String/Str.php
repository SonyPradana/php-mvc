<?php

namespace Helper\String;

class Str
{
  public static function startWith(string $find, string $in): bool
  {
    return substr($in, 0, strlen($find)) == $find;
  }
}
