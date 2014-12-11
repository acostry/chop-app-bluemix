<?php
/**
 * 在线生成公章类
 * 说明：
 *  1. 使用背景图片bg.gif, 字体为黑体。
 *  2. 先生成一个环形文字，剪切后然后复制到背景图片。
 * 
 * @author qingbin.wu
 * @data 2011-04-22
 */
Class Cachet
{
  // 背景图片
  var $bgImg;
  var $bgMark;
  
  // 字体
  var $font;
  
  /**
   * 初始化GD2库参数
   * 
   */
  public function __construct()
  {
  	$this->bgImg  = 'images/cachet.gif';
  	$this->bgMark = 'images/mask.gif';
    $this->font   = 'images/simhei.ttc';
  }
  
  /**
   * 输入公章图片
   * 
   * @param string $str 大字
   * @param string $chr 小字
   * @return resuse
   */
  public function display($str = '', $chr = '')
  {	
  	// 生成参数
  	$param = $this->makeParam($str);  	
  	// 环形文字
    $im = imagecreate (200, 200);
    $bgcolor=ImageColorAllocate($im, 255, 255, 255);
    $red = imagecolorallocate($im, 255, 0, 0);
    // 生成环形文字
    for ( $i=1; $i<=100; $i++) {
	    $A = $param['A'] * $i;
      $X = (1 - sin(deg2rad($A)))*$param['R'] + 30;
      $Y = (1 - cos(deg2rad($A)))*$param['R'] + 30;
      $text = $this->utf8Substr($param['S'], $i, 1);
      imagettftext($im, 13, $A-$param['C'], $X, $Y, $red, $this->font, $text);
    }    
    // 生成小文字
    $cInfo = $this->makeInfo($chr);
    imagettftext($im, 11, 0, $cInfo['X'], 130, $red, $this->font, $cInfo['S']);
    // 剪切图片
    ImageColorTransparent($im, $bgcolor);
    imageantialias($im, true);
    $im2 = $this->coding($chr);
    imagecopyresampled($im2, $im, 0, 0, 5, 7, 149, 149, 149, 149);
    imageantialias($im2, true);
    // 输入图片
    header("Content-Disposition:attachment;filename=cachet.png");
    header("Content-type: image/png");
    imagedestroy($im);
    imagepng($im2);
    imagedestroy($im2);
  }
  
  /**
   * 生成私章背景
   * 
   * @param string $user
   * @return resource
   */
  public function coding($chr = 'demo:')
  {
  	$imb = imagecreatefromgif($this->bgImg);
  	
  	// 分析
  	$chr = strtolower($chr);
  	$arr = @explode(':', $chr);
  	if ( count($arr) < 2) return $imb;
  	
  	// 获取头像
  	$co = new Coding();
  	$data = $co->getUser($arr[0]);
  	
  	$thumb = $data['avatar'];
  	if ( strpos($thumb, 'http') === false) $thumb ='https://coding.net'.$thumb;
  	
  	$stream = $co->html($thumb);
  	if ( empty($stream)) return $imb;

  	// 缩放图片
  	$im = imagecreatefromstring($stream);
  	$imn = imagecreatefromgif($this->bgMark);
  	$imr = imagecreatefromgif($this->bgMark);
  	imagecopyresampled($imn, $im, 0, 0, 0, 0, 43, 43, imagesx($im), imagesy($im));
  	imagecopyresampled($imn, $imr, 0, 0, 0, 0, 43, 43, 43, 43);
  	
  	// 图片贴合
  	imagecopyresampled($imb, $imn, 52, 51, 0, 0, 43, 43, 43, 43);
  	
  	imagedestroy($im);
  	imagedestroy($imn);
  	imagedestroy($imr);
  	
  	return $imb;
  }
  
  /**
   * 按字数生成参数以实现比较完美的显示
   * 
   * @param string $str
   * @return array
   */
  public function makeInfo($str)
  {
  	$str = preg_replace("/^.*?\:/is", "", $str);
  	// 最大支持6个汉字
  	$num = mb_strlen($str, "UTF-8");
    if ( $num >=6) $str = $this->utf8Substr($str, 0, 5);
    if ( $num == 1){ $result['X'] =  71;}
    if ( $num == 2){ $result['X'] =  64;}
    if ( $num == 3){ $result['X'] =  57;}
    if ( $num == 4){ $result['X'] =  50;}
    if ( $num == 5){ $result['X'] =  44;}
    if ( $num == 6){ $result['X'] =  35;}
    $result['S'] = $str;
    // Return
    return $result;
  }
  
  /**
   * 按字数生成参数以实现比较完美的显示
   * 
   * @param string $str
   * @return array
   */
  public function makeParam($str)
  {
    // 最大支持18个汉字
    $num = mb_strlen($str, "UTF-8");
    if ( $num >=18) $str = $this->utf8Substr($str, 0, 17);
    $str = $this->reverse($str);
    if ( $num == 1){ 
      return array('R'=>51, 'A'=>20, 'C'=>10, 'S'=>'　'.$str);
    }
    if ( $num == 2){
      return array('R'=>51, 'A'=>30, 'C'=>10, 'S'=>'　　　　　　　　　　　　'.$str);
    }
    if ( $num == 3 || $num == 4){
      return array('R'=>51, 'A'=>30, 'C'=>10, 'S'=>'　　　　　　　　　　　'.$str);
    }
    if ( $num == 5 || $num == 6){
      return array('R'=>51, 'A'=>28, 'C'=>10, 'S'=>'　　　　　　　　　　 '.$str);
    }
    if ( $num == 7 ){
      return array('R'=>51, 'A'=>28, 'C'=>10, 'S'=>'                       '.$str);
    }
   if ( $num == 8){
      return array('R'=>51, 'A'=>26, 'C'=>10, 'S'=>'           '.$str);
    }
   if ($num == 9){
      return array('R'=>51, 'A'=>25, 'C'=>10, 'S'=>'           '.$str);
    }
   if ($num == 10){
      return array('R'=>51, 'A'=>24, 'C'=>10, 'S'=>'           '.$str);
    }
    if ($num == 11){
      return array('R'=>51, 'A'=>23, 'C'=>10, 'S'=>'           '.$str);
    } 
    if ($num == 12){
      return array('R'=>51, 'A'=>20, 'C'=>10, 'S'=>'             '.$str);
    } 
    if ($num == 13){
      return array('R'=>51, 'A'=>17, 'C'=>10, 'S'=>'                '.$str);
    }
    if ($num == 14){
      return array('R'=>51, 'A'=>17, 'C'=>10, 'S'=>'                '.$str);
    } 
    if ($num == 15){
      return array('R'=>51, 'A'=>17, 'C'=>10, 'S'=>'               '.$str);
    } 
    if ($num == 16){
      return array('R'=>51, 'A'=>17, 'C'=>10, 'S'=>'              '.$str);
    } 
    if ($num >= 17){
      return array('R'=>51, 'A'=>16, 'C'=>10, 'S'=>'               '.$str);
    }
  }
  
  /**
   * 文字反转面试
   * 
   * @param string $str
   * @return string
   */
  public function reverse($str)
  {
    $num = mb_strlen($str, "UTF-8"); 
    for ( $i=$num; $i>=0; $i--){
      $result.= mb_substr($str, $i, 1, 'UTF-8'); 
     } 
    return $result;
  }
  
  /**
   * 截取中文字符
   * 
   * @param string $str
   * @param integer $from
   * @param integer $len
   * @return string
   */
  public function utf8Substr($str, $from, $len) 
  { 
    return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'. 
    '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s','$1',$str); 
  }
} 
/** End of class Cachet **/
/** End of file Cachet.php **/