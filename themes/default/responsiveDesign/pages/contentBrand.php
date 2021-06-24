<?php /* ?>
<h1><?php echo Engine_Application::getPageHeader(); ?></h1>
<?php echo $this->layout()->content; ?> 
<?php */ ?>
<h1 id="page-title" class="hidden-xs"><?php echo $this->pageTitle; ?></h1>
<?php echo $this->layout()->content; ?> 