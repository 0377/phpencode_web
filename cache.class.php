<?php

//dingchengliang  simple cache.

//���ļ�
function cache_read($file)
{  
	$file =  cachefilepath($file,$folder);
	//echo $file . '===';
	if(file_exists($file))
	{  include($file);	 
	   return $content;
	}
}
 
//д��������
function cache_write($file,$content)
{
	$file = cachefilepath($file,$folder);
	if(is_array($content))
	{
		$content= var_export($content,1);
	}
	else
	{
		$content='array()';
	}	 
	/*$content = '<?  $content = unserialize (\'' . serialize($content) . '\');  ?>';	  */
	$content = '<?  $content =    ' .  ($content) . '  ;  ?>';	 
	
	if(function_exists('file_put_contents'))
	{
		file_put_contents($file,$content);
	}
	else
	{
		$fp=fopen($file,'w');
		  flock($fp,2);  //����
		fwrite($fp,$content);
			if(flock($fp,3))    //�������
		fclose($fp);
	}
}
function cachefilepath($file)
{  
	$folder=$GLOBALS['db_cache_path'];
	return  $folder.'cache.'.($file) .'.php';
}
function cache_outofdate($file, $long){
  $file = cachefilepath($file);
  if(!is_file($file))  return true;
  
  $t = filemtime ($file);
  if(time()-$t > $long)  return true;
  else return false;
  
}