<?php
$sixArr = array(
	"7ecedb66-d9ee-11e9-af70-2c4d5457fd19",
	"77da1b70-d9fa-11e9-af70-2c4d5457fd19",
	"4c5493b8-d9f0-11e9-af70-2c4d5457fd19",
	"92de303a-d9ea-11e9-af70-2c4d5457fd19"
);
/* echo '<pre>';
  print_r($_GET);
  echo '</pre>'; */
?>
<?php if ($this->showFilter) : ?>
	<div id="filter-menu">
		<form method="GET" action="/catalog/search/" name="filter-menu">
			<input type="hidden" name="catalog-search-text" value="<?php echo (isset($_GET['catalog-search-text']) ? $_GET['catalog-search-text'] : ""); ?>" />
			<?php foreach ($this->propArr as $key => $properties) : ?>
				<?php
				$valClass = "col-sm-12 one-value";
				if (in_array($key, $sixArr)) {
					$valClass = "col-sm-6 one-value";
				}
				$display = "";
				if (isset($_GET['param'][$key])) {
					$display = 'style="display: block;"';
				}
				?>
				<div class="row-fluid">
					<div class="filter-title" id="ft-<?php echo $key; ?>">
						<h4><?php echo $properties['name']; ?></h4>
					</div>
					<div class="filter-values" id="fv-<?php echo $key; ?>" <?php echo $display; ?>>
						<?php foreach ($properties['values'] as $key1 => $value) : ?>
							<?php
							$checked = "";
							foreach ($_GET['param'][$key] as $key2 => $value2) {
								if ($value2 == $key1) {
									$checked = "checked";
								}
							}
							?>					
							<div class="<?php echo $valClass; ?>">
								<input 
									class="filter-sel" type="checkbox" 
									value="<?php echo $key1; ?>" name="param[<?php echo $key; ?>][]" 
									id="<?php echo $key1; ?>" <?php echo $checked; ?>/>
								<label for="<?php echo $key1; ?>"><?php echo $value; ?></label>
							</div>
		<?php endforeach; ?>
					</div>
				</div>
		<?php endforeach; ?>
			<input type="submit" id="submit-indiv" class="send-form" value="Показать" style="width: 100%;">
		</form>
	<?php /* <pre>
	  <?php print_r($this->propArr); ?>
	  </pre> */ ?>
	</div>
<?php endif; ?>