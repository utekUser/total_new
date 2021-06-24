<style>
	.dropdown-submenu {
		position: relative;
	}

	.dropdown-submenu>.dropdown-menu {
		top: 0;
		left: 100%;
		margin-top: -6px;
		margin-left: -1px;
		-webkit-border-radius: 0 6px 6px 6px;
		-moz-border-radius: 0 6px 6px 6px;
		border-radius: 0 6px 6px 6px;
	}

	.dropdown-submenu:hover>.dropdown-menu {
		display: block;
	}

	.dropdown-submenu>a:after {
		display: block;
		content: " ";
		float: right;
		width: 0;
		height: 0;
		border-color: transparent;
		border-style: solid;
		border-width: 5px 0 5px 5px;
		border-left-color: #cccccc;
		margin-top: 7px;
		margin-right: -5px;
	}

	.dropdown-submenu:hover>a:after {
		border-left-color: #f5c90c;
	}

	.dropdown-submenu.pull-left {
		float: none;
	}

	.dropdown-submenu.pull-left>.dropdown-menu {
		left: -100%;
		margin-left: 10px;
		-webkit-border-radius: 6px 0 6px 6px;
		-moz-border-radius: 6px 0 6px 6px;
		border-radius: 6px 0 6px 6px;
	}
</style>
<div id="top-menu-block" class="hidden-xs">
	<div class="container">
		<div class="topMenuWrapper">
			<div id="topMenuWrapper">
				<div class="col-lg-3 col-md-3 col-sm-4 padding-lr-0">
					<nav class="navbar navbar-default nav-b-total" role="navigation">
						<div class="collapse navbar-collapse js-navbar-collapse menu-catalog">
							<ul class="nav navbar-nav">
								<li class="dropdown mega-dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown">Каталог <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span> 
											<span class="icon-bar"></span> 
										</button>
									</a>
									<ul class="dropdown-menu mega-dropdown-menu row first-submenu-catalog">
										<?php foreach ($this->groups as $link => $name) : ?>
											<li class="<?php if (is_array($name['children'])) echo "dropdown-submenu"; ?>">
												<a href="/catalog/<?php echo $link . '/'; ?>">
													<?php echo $name['title']; ?>
												</a>											
												<?php if (is_array($name['children'])) : ?>
													<ul class="dropdown-menu second-submenu-catalog">
														<?php foreach ($name['children'] as $subLink => $subName) : ?>
															<li class="<?php if (is_array($subName['children'])) echo "dropdown-submenu"; ?>">
																<a href="/catalog/<?php echo $link . '/' . $subLink . '/'; ?>">
																	<?php echo $subName['title']; ?>
																</a>															
																<?php if (is_array($subName['children'])) : ?>
																	<ul class="dropdown-menu third-submenu-catalog">
																		<?php foreach ($subName['children'] as $subSubLink => $subSubName) : ?>
																			<li>
																				<a href="/catalog/<?php echo $link . '/' . $subLink . '/' . $subSubLink . '/'; ?>">
																					<?php echo $subSubName; ?>
																				</a>
																			</li>
																		<?php endforeach; ?>
																	</ul>
																<?php endif; ?>
															</li>
														<?php endforeach; ?>
													</ul>
												<?php endif; ?>
											</li>
										<?php endforeach; ?>
									</ul>
								</li>
							</ul>
						</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-8">
					<div id="top-menu"><?php echo $this->layout()->topmenu; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>