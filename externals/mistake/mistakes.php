<?php
define('_ENGINE', TRUE);
    include '../../kernel/main/conf.php';
    
	function after_store($url, $mis, $comment, $name){
		$mlb=cms::setup_value('error_mail');
		if(conf::$uside && $mlb!=''){
			$mailsend=explode(',',$mlb);
			foreach ($mailsend as $key=>$value){
				$m=mail($value,
							'��������� �� ������ �� ����� http://'.$_SERVER['HTTP_HOST'],
							'������ �������:<br>'.
							'<b>����� ��������:</b> '.$url."<br>".
							'<b>������:</b> '.$mis."<br>".
//							'<b>��� e-mail:</b> '.vars('address')."<br>".
							'<b>�����������:</b> '.vars('time')."<br>".$comment,
					    	"From: \"".$name."\" <".vars('address').">\n" .
							"Content-Transfer-Encoding: 8bit\n" .
							"MIME-Version: 1.0\n" .
							"Content-Type: text/html; charset=windows-1251\n".
							"X-Mailer: PHP/" . phpversion()
					);
	      }
		};
	}
?>
<!-- ������ �������� ��������� �� ������ http://mistakes.ru/script/mistakes_dev -->
<!-- ������ 3.0 -->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<TITLE>��������� ������</TITLE>
<style type="text/css">
body {
margin: 20px 25px;
font-size:14px;
font-family:Helvetica, Sans-serif, Arial;
line-height:2em;
}
form
{margin: 0;}
.text {
font-weight: bold;
font-size:12px;
color:#777;
}
.copyright
{
font-size:11px;
color:#777;
}
</style>

<script language="JavaScript"> 
var p=top;
function readtxt()
{ if(p!=null)document.forms.mistake.url.value=p.loc
 if(p!=null)document.forms.mistake.mis.value=p.mis
}
function hide()
{ var win=p.document.getElementById('mistake');
win.parentNode.removeChild(win);
}
</script>

<?php 
if($_POST['submit']) { 
    # ��������� ��������� - �������� "yousite.ru" �� ��� ������ �����:
		$title = '��������� �� ������ �� ����� yousite.ru';
        $url = (trim($_POST['url'])); 
        $mis =  substr(htmlspecialchars(trim($_POST['mis'])), 0, 100000); 
		$comment =  substr(htmlspecialchars(trim($_POST['comment'])), 0, 100000);
		$mess = '
		����� ��������: '.$url.'
		������: '.$mis.'
		�����������: '.$comment.'
		'.$_POST['mess']; 
		# Email �����, �� ������� ������ ��������� ���������: 
        $to = 'alex@r70.ru';
        # �� ���� ������ ��������� - ����� ������� ��� �����:  
        $from=$_SERVER['HTTP_HOST']; 
        $strSQL = "
INSERT INTO ".conf::$dbprefix."mistake 
            		(`posted`,`address`,`error`,`�omments`,`fixed`) 
            		VALUES('".date('Y-m-d H:i:00')."','".$url."','".$mis."','".$comment."',0)";
        mysql_query($strSQL);
        after_store($url, $mis, $comment,'������');
//        mail($to, $title, $mess, 'From: '.$from); 
        echo '<br><br><br><center>�������!<br>���� ��������� ����������.<br><br><br><input onclick="hide()" type="button" value="������� ����" id="close" name="close"><br><br><br><center>'; 
exit();
} 
?>

</head>
<body onload=readtxt()>
<span class="text">
����� �������� :
 </span>
<br /> 
<form name="mistake" action="" method=post>
<input type="text" name="url" size="30">
              <br />
              <span class="text">
              ������ :
              </span>
              <br /> 
              <textarea rows="5" name="mis" cols="30"></textarea> 
              <br />
              <span class="text">
              ����������� :
              </span>
              <br /> 
              <textarea rows="5" name="comment" cols="30"></textarea> 
              <div style="margin-top: 7px"><input type="submit" value="���������" name="submit">
              <input onclick="hide()" type="button" value="������" id="close" name="close"> 
              </div>
</form> 

</body></html>
