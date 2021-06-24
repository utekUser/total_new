<div class="one-new">
	<div class="date-views">
		<span class="news-date">
			<img src="/themes/default/images/newdesign/clock.png" />&nbsp;
			<?php echo $this->Date($this->currentNew['posted'], 'date'); ?>&nbsp;
		</span>
		<span class="news-views">
			<img src="/themes/default/images/newdesign/eye.png" />&nbsp;
			<?php echo $this->currentNew['view']; ?>
		</span>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 padding-lr-0">
		<?php if (!$this->currentNew['picture_display'] && $this->currentNew['picture'] != '') : ?>
			<a class="gallery" href="/<?php echo $this->currentNew['picture']; ?>b.jpg"><img class="img-detailed" style="margin-bottom: 0;" alt="" src="/<?php echo $this->currentNew['picture']; ?>p.jpg" /></a>
		<?php endif; ?>
		<?php for ($i = 1; $i <= 5; $i++) : ?>
			<?php if ($this->currentNew['picture' . $i] != '') : ?>
				<a class="gallery" href="/<?php echo $this->currentNew['picture' . $i]; ?>b.jpg">
					<img class="img-detailed" alt="" src="/<?php echo $this->currentNew['picture' . $i]; ?>p.jpg" />
				</a>
			<?php endif; ?>
		<?php endfor; ?>
	</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 news-short padding-lr-0">
		<?php echo $this->currentNew['short']; ?>
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 news-short padding-lr-0">
		<?php echo $this->currentNew['text']; ?>
	</div>
</div>