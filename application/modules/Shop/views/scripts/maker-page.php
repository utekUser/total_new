<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-lr-0 catalog-page">	
	<?php $maker = $this->maker; ?>
	<?php if ($maker['description'] != "") : ?>
		<?php echo $maker['description']; ?>
	<?php endif; ?>	
	<?php if ($maker['linkto'] != "") : ?>
		<iframe scrolling="yes" frameborder="0" width="100%" height="1200" src="<?php echo $maker['linkto']; ?>" name="maker-iframe" id="maker-iframe"></iframe>
	<?php endif; ?>
</div>

<?php function translit($s) {
	$s = (string) $s;
	$s = strip_tags($s);
	$s = str_replace(array("\n", "\r"), " ", $s);
	$s = preg_replace("/\s+/", ' ', $s);
	$s = trim($s);
	$s = function_exists('mb_strtolower') ? mb_strtolower($s,'utf-8') : strtolower($s);
	$s = strtr($s, array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'e', 'ж' => 'j', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'ъ' => '', 'ь' => ''));
	$s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
	$s = str_replace(" ", "-", $s);
	return $s;
} ?>