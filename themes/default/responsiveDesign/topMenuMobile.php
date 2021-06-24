<?php
foreach ($this->topmenu as $topMenu) {
	if ($topMenu['parent'] == 0) {
		$menu[$topMenu['id']]['punkt'] = $topMenu;
		$menu[$topMenu['id']]['podpunkt'] = null;
	} else {
		$menu[$topMenu['parent']]['podpunkt'][] = $topMenu;
	}
}
?>
<div id="nav-menu-m" class="navigation">
	<div class="navigation__inner">
		<span id="close-nav-m">Закрыть</span>
		<br style="clear: both;"/>
		<ul class="dropdownnew-m">			
			<?php foreach ($this->groups as $link => $name) : ?>
				<?php $rId = rand(5, 500)?>
				<li class="<?php if (is_array($name['children'])) echo "dropdown-submenu-m"; ?>">					
					<p class="tat-m-p">
						<a href="/catalog/<?php echo $link . '/'; ?>">
							<?php echo $name['title']; ?>
						</a>	
						<?php if (is_array($name['children'])) : ?>
							<img id="img-<?php echo $rId; ?>" class="dropdown-submenu-img-m" src="/themes/default/responsiveDesign/images/submenu-m.webp" />							
						<?php endif; ?>
					</p>
					
					<?php if (is_array($name['children'])) : ?>
						<ul id="ul-img-<?php echo $rId; ?>" class="dropdown-menu-m">
							<?php foreach ($name['children'] as $subLink => $subName) : ?>
								<li class="<?php /*if (is_array($subName['children'])) echo "dropdown-submenu";*/ ?>">
									<p class="tat-sub-m-p">
										<a href="/catalog/<?php echo $link . '/' . $subLink . '/'; ?>">
											<?php echo $subName['title']; ?>
										</a>		
									</p>
									<?php /*if (is_array($subName['children'])) : ?>
										<ul class="dropdown-menu third-submenu-catalog">
											<?php foreach ($subName['children'] as $subSubLink => $subSubName) : ?>
												<li>
													<a href="/catalog/<?php echo $link . '/' . $subLink . '/' . $subSubLink . '/'; ?>">
														<?php echo $subSubName; ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									<?php endif;*/ ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
			<?php $i = 0; ?>
			<?php if (is_array($menu)) :
				foreach ($menu as $notParent) :
					?> 
					<?php $rId = rand(501, 700)?>
					<li class="<?php if ($i == 0) { ?>menu-li-first<?php } ?> dropdownnew-top">
						<p class="tat-m-p">
							<a class="<?php if ($i == 0) { ?>menu-first<?php } ?> dropdownnew-top" href="/<?php echo $notParent['punkt']['url']; ?>/">
								<?php echo $notParent['punkt']['name']; ?>
							</a>  
							<?php if (count($notParent['podpunkt']) > 0) : ?>
								<img id="img-<?php echo $rId; ?>" class="dropdown-submenu-img-m" src="/themes/default/responsiveDesign/images/submenu-m.webp" />							
							<?php endif; ?>
						</p>
						<?php if (count($notParent['podpunkt']) > 0) : ?>
							<ul id="ul-img-<?php echo $rId; ?>" class="dropdown-menu-m">								
								<?php if (is_array($notParent['podpunkt'])) :
									foreach ($notParent['podpunkt'] as $parent) :
										?>        
										<li>
											<p class="tat-sub-m-p">
												<a href="/<?php echo $parent['url']; ?>/"><?php echo $parent['name']; ?></a>
											</p>
										</li>
								<?php endforeach;
							endif;
							?>
							</ul>
						<?php endif; ?>
					</li>
		<?php
		$i++;
	endforeach;
endif;
?>
		</ul>
	</div>
</div>