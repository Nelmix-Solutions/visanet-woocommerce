<?php

namespace VisanetSDK\lib\helpers;

class Html
{
  public static function hiddenInput($name, $value)
  {
    return "<input type=\"hidden\" name=\"$name\" value=\"$value\" />\n";
  }

  public static function paragraphBackground($url)
  {
    return "<p style=\"background:url($url)\"></p>\n";
  }

  public static function img($url, $alt = '')
  {
    return "<img src=\"$url\" alt=\"$alt\" />\n";
  }

  public static function script($url)
  {
    return '<script src="'.$url.'" type="text/javascript"> </script>' . "\n";
  }

  public static function swf($url)
  {
    return '<object type="application/x-shockwave-flash" data="'.$url.'" width="1" height="1" id="thm_fp"> <param name="movie"
value="'.$url.'" />
<div></div> </object>' . "\n";
  }
}
