<div class="section-block">
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 one-section">
		<a href="/articles/">Все разделы</a>
	</div>
	<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
		<p>Выбор раздела:</p>
		<?php $section = array(); ?>
		<?php foreach ($this->section as $sectionValue) : ?>
			<?php $section[$sectionValue['id']] = $sectionValue['url']; ?>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 one-section">
				<?php if ($this->sectionName == $sectionValue['name']) : ?>
					<span class="active">
						<b><?php echo $sectionValue['name']; ?></b>
						<span>(<?php echo $sectionValue['amount']; ?>)</span>
					</span>
				<?php else : ?>
					<?php echo $this->Link('/articles/' . $sectionValue['url'] . '/', $sectionValue['name'], $sectionValue['name']); ?>
					<span>(<?php echo $sectionValue['amount']; ?>)</span>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?php foreach ($this->paginator as $someArticle) : ?>
	<div class="row-fluid one-new">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 padding-lr-0">
			<?php if ($someArticle['picture'] != '') : ?>
				<div class="news-photo">
					<a href="<?php echo '/articles/' . $section[$someArticle['section_id']] . '/' . ($someArticle['url'] ? $someArticle['url'] . '-' : '') . $someArticle['id'] . '.html'; ?>">
						<img alt="" src="/<?php echo $someArticle['picture']; ?>p.jpg" />
					</a>
				</div>
			<?php endif; ?>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 padding-lr-0">
			<div class="date-views">
				<span class="news-date">
					<img src="/themes/default/images/newdesign/clock.png" />&nbsp;
					<?php echo $this->Date($someArticle['posted'], 'date'); ?>&nbsp;
				</span>
				<span class="news-views">
					<img src="/themes/default/images/newdesign/eye.png" />&nbsp;
					<?php echo $someArticle['view']; ?>
				</span>
			</div>
			<div class="news-link">
				<?php echo $this->Link('/articles/' . $section[$someArticle['section_id']] . '/' . ($someArticle['url'] ? $someArticle['url'] . '-' : '') . $someArticle['id'] . '.html', $someArticle['name']); ?>
			</div>
			<div class="news-short">
				<?php echo $someArticle['short']; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
<?php if ($this->paginator->count() > 1) : ?>
	<div class="paginator">
		<?php echo $this->paginationControl($this->paginator, 'Sliding', 'user-page.tpl'); ?>
	</div>
<?php endif; ?>