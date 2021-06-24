<?php foreach ($this->paginator as $news) : ?>
	<div class="row-fluid one-new">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 padding-lr-0">
			<?php if ($news['picture'] != '') : ?>
				<div class="news-photo">
					<a href="/news/<?php echo ($news['url'] ? $news['url'] . '-' : '') . $news['id'] . '.html'; ?>">
						<img alt="<?php echo $news['name'];?>" title="<?php echo $news['name'];?>" src="/<?php echo $news['picture']; ?>p.jpg" />
						<?php if ($news['stock']) : ?>
							<img src="/images/stock.png" />
						<?php endif; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 padding-lr-0">
			<div class="date-views">
				<span class="news-date">
					<img src="/themes/default/images/newdesign/clock.png" />&nbsp;
					<?php echo $this->Date($news['posted'], 'date'); ?>&nbsp;
				</span>
				<span class="news-views">
					<img src="/themes/default/images/newdesign/eye.png" />&nbsp;
					<?php echo $news['view']; ?>
				</span>
			</div>
			<div class="news-link">
				<?php echo $this->Link('/news/' . ($news['url'] ? $news['url'] . '-' : '') . $news['id'] . '.html', $news['name']); ?>
			</div>
			<div class="news-short">
				<?php echo $news['short']; ?>
			</div>
		</div>	    
	</div>
<?php endforeach; ?>
<?php if ($this->paginator->count() > 1) : ?>
	<div class="paginator">
		<?php echo $this->paginationControl($this->paginator, 'Sliding', 'user-page.tpl'); ?>
	</div>
<?php endif; ?>