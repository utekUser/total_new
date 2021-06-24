<style>
	ul.dropdownnew,
    ul.dropdownnew-inside {
        list-style-type: none;
        padding: 0;
    }	
    ul.dropdownnew-inside {
        position: absolute;
        left: -9999px;
        z-index: 1000;
    }
	ul.dropdownnew li {
		position: relative;
	}    
    ul.dropdownnew li.dropdownnew-top {
        display: inline;
        float: left;
        margin: 0 1px 0 0;
    }
    ul.dropdownnew li.dropdownnew-top a {
        padding: 3px 10px 4px;
        display: block;
    }
    ul.dropdownnew a.dropdownnew-top { 
		background: transparent; 
	}
    ul.dropdownnew a.dropdownnew-top:hover { 
		padding: 2px 10px 5px; 
		text-decoration: underline 
	}
    ul.dropdownnew li.dropdownnew-top:hover .dropdownnew-inside {
        display: block;
        left: 0;
    }
    ul.dropdownnew .dropdownnew-inside { 
		background: transparent; 
	}
    ul.dropdownnew .dropdownnew-inside a:hover { 
		background: transparent; 
	}
</style>
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
<div id="topmenumew" style="padding-top: 15px;">      
    <ul class="dropdownnew">
		<?php $i = 0; ?>
		<?php if (is_array($menu)) :
			foreach ($menu as $notParent) : ?> 
		        <li class="<?php if ($i == 0) { ?>menu-li-first<?php } ?> dropdownnew-top">
		            <a class="<?php if ($i == 0) { ?>menu-first<?php } ?> dropdownnew-top" href="/<?php echo $notParent['punkt']['url']; ?>/">
						<?php echo $notParent['punkt']['name']; ?>
					</a>   
					<?php if (count($notParent['podpunkt']) > 0) : ?>
			            <ul class="dropdownnew-inside">
			                <div class="_nb-popup-tail"><i></i></div>
							<?php if (is_array($notParent['podpunkt'])) :
								foreach ($notParent['podpunkt'] as $parent) : ?>        
					                <li><a href="/<?php echo $parent['url']; ?>/"><?php echo $parent['name']; ?></a></li>
								<?php endforeach;
							endif; ?>
						</ul>
					<?php endif; ?>
		        </li>
				<?php $i++;
			endforeach;
		endif; ?>
    </ul>
</div>