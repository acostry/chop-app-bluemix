<?php 
require_once 'models/Cachet.php';
require_once 'models/Coding.php';
$ca = new Cachet();
$ca->display($_GET['s'], $_GET['f']);

function unescape($str) { 
 $str = rawurldecode($str); 
 preg_match_all("/%u.{4}|&#x.{4};|&#d+;|.+/U",$str,$r); 
 $ar = $r[0]; 
 foreach($ar as $k=>$v) { 
  if(substr($v,0,2) == "%u") 
   $ar[$k] = iconv("UCS-2","gb2312",pack("H4",substr($v,-4))); 
  elseif(substr($v,0,3) == "&#x") 
   $ar[$k] = iconv("UCS-2","gb2312",pack("H4",substr($v,3,-1))); 
  elseif(substr($v,0,2) == "&#") { 
   $ar[$k] = iconv("UCS-2","gb2312",pack("n",substr($v,2,-1))); 
  } 
 } 
 $str = join("", $ar); 
 return iconv("GBK", "UTF-8", $str);
}
?>