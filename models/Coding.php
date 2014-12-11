<?php
/**
 * Coding-map
 * 
 * @author phpbin
 */
class Coding
{
	/**
	 * 获取数据
	 * 
	 * @param integer $page
	 * @return array
	 */
	public function getData($page=1)
	{
		$page = max(1, $page);
		$url = 'https://coding.net/api/public/all?page='.$page.'&pageSize=20';
		$json = $this->html($url);
		$arrs = json_decode($json, true);
		
		$return = array();
		foreach ( $arrs['data']['list'] as $val)
		{
			$val['user_info'] = $this->getUser($val['owner_user_name']);
			$val['proj_info'] = $this->getPorject($val['owner_user_name']);
			$return[] = $val;
		}
		
		return $return;
	}

	/**
	 * 用户详细
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function getUser($name)
	{
		$url = 'https://coding.net/api/user/key/'.$name;
		$json = $this->html($url);
		$arrs = json_decode($json, true);
		return $arrs['data'];
	}

	/**
	 * 项目列表 
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function getPorject($name)
	{
		$url = 'https://coding.net/api/user/'.$name.'/public_projects?page=1&pageSize=100&type=joined';
		$json = $this->html($url);
		$arrs = json_decode($json, true);
		return $arrs['data']['list'];
	}
	
  /**
   * 获取HTML
   * 
   * @param string $url
   * @return mixed
   */
  public function html($url)
  {
	  $ch = curl_init($url);
	  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	  //curl_setopt($ch, CURLOPT_PROXY, 'http://10.100.10.100:3128');
	  $html = curl_exec($ch);
	  curl_close($ch);
	  return $html;
  }
}
/** End of class Coding **/
?>