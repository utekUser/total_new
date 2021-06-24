<?php
function CoolSize($size) {
    $mb = 1024*1024;
    if ( $size > $mb ) {
        $mysize = sprintf ("%01.2f",$size/$mb) . " Mb";
    } elseif ( $size >= 1024 ) {
        $mysize = sprintf ("%01.2f",$size/1024) . " Kb";
    } else {
        $mysize = $size . " b";
    }
    return $mysize;
}

function spacer($w,$h){
    return "<img width=$w height=$h src='images/empty.gif' border=0>";
}






function rus2translit($string) {
    $converter = array(
        '�' => 'a',   '�' => 'b',   '�' => 'v',
        '�' => 'g',   '�' => 'd',   '�' => 'e',
        '�' => 'e',   '�' => 'zh',  '�' => 'z',
        '�' => 'i',   '�' => 'y',   '�' => 'k',
        '�' => 'l',   '�' => 'm',   '�' => 'n',
        '�' => 'o',   '�' => 'p',   '�' => 'r',
        '�' => 's',   '�' => 't',   '�' => 'u',
        '�' => 'f',   '�' => 'h',   '�' => 'c',
        '�' => 'ch',  '�' => 'sh',  '�' => 'sch',
        '�' => '\'',  '�' => 'y',   '�' => '\'',
        '�' => 'e',   '�' => 'yu',  '�' => 'ya',
        
        '�' => 'A',   '�' => 'B',   '�' => 'V',
        '�' => 'G',   '�' => 'D',   '�' => 'E',
        '�' => 'E',   '�' => 'Zh',  '�' => 'Z',
        '�' => 'I',   '�' => 'Y',   '�' => 'K',
        '�' => 'L',   '�' => 'M',   '�' => 'N',
        '�' => 'O',   '�' => 'P',   '�' => 'R',
        '�' => 'S',   '�' => 'T',   '�' => 'U',
        '�' => 'F',   '�' => 'H',   '�' => 'C',
        '�' => 'Ch',  '�' => 'Sh',  '�' => 'Sch',
        '�' => '\'',  '�' => 'Y',   '�' => '\'',
        '�' => 'E',   '�' => 'Yu',  '�' => 'Ya',
    );
    return strtr($string, $converter);
}
function str2url($str) {
    $str = iconv("UTF-8", "cp1251", $str);
    // ��������� � ��������
    $str = rus2translit($str);
    // � ������ �������
    $str = strtolower($str);
    // ������� ��� �������� ��� �� "-"
    $str = preg_replace('~[^-a-z0-9.]+~u', '-', $str);
    // ������� ��������� � �������� '-'
    $str = trim($str, "-");
    return $str;
}




function rus2lat($str)
{
	$chars = array(
			'�'=>'j','�'=>'J',
			'�'=>'c','�'=>'C',
			'�'=>'u','�'=>'U',
			'�'=>'k','�'=>'K',
			'�'=>'e','�'=>'E',
			'�'=>'n','�'=>'N',
			'�'=>'g','�'=>'G',
			'�'=>'sh','�'=>'Sh',
			'�'=>'csh','�'=>'CSH',
			'�'=>'z','�'=>'Z',
			'�'=>'h','�'=>'H',
			'�'=>'_','�'=>'_',
			'�'=>'f','�'=>'F',
			'�'=>'y','�'=>'Y',
			'�'=>'v','�'=>'V',
			'�'=>'a','�'=>'A',
			'�'=>'p','�'=>'P',
			'�'=>'r','�'=>'R',
			'�'=>'o','�'=>'O',
			'�'=>'l','�'=>'L',
			'�'=>'d','�'=>'D',
			'�'=>'j','�'=>'J',
			'�'=>'e','�'=>'E',
			'�'=>'ya','�'=>'YA',
			'�'=>'ch','�'=>'CH',
			'�'=>'s','�'=>'s',
			'�'=>'m','�'=>'M',
			'�'=>'i','�'=>'I',
			'�'=>'t','�'=>'T',
			'�'=>'_','�'=>'_',
			'�'=>'b','�'=>'B',
			'�'=>'u','�'=>'U',
			'�'=>'e','�'=>'E',
			' '=>'_'
	);
	for ($i=0;$i<strlen($str);$i++){
		if ($chars[$str[$i]]!='')
		$res .= $chars[$str[$i]];
		else 
		$res .= $str[$i];
	}
	return $res;
}

// �������� ��������� ��������
function xrmdir($path)
{
  $result=true;
  if ($dir = opendir($path))
  {
    while (($file = @readdir($dir)) !== false)
    {
      $tmp = $path.DIRECTORY_SEPARATOR.$file;
      if (is_dir($tmp) && $file!="." && $file!="..")
      {
        if (!xrmdir($tmp))
          $result=false;
      }
      else if (is_file($tmp))
        if (!@unlink($tmp))
          $result=false;
    }
   closedir($dir);
  }
  else 
	$result=false;  
  if (!rmdir($path))
      $result=false;  
  return $result;
}
?>