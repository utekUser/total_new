<?php
if ($this->itIsGood) {
	include 'good-page.php';
} else if ($this->itIsSearch) {
	include 'search-page.php';
} else if ($this->itIsMaker) {
	include 'maker-page.php';
} else {
	include 'catalog-page.php';
}
?>