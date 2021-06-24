<!doctype html>
<html>
    <head>
        <?php include 'responsiveDesign/head.php'; ?>
    </head>
    <body>
        <?php
        include 'responsiveDesign/afterBodyStart.php';
        $auth1 = Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session('Zend_Auth_User'));
        if ($auth1->hasIdentity()) :
            include 'responsiveDesign/modalBlocks/isAuth.php';
        endif;
        if (Engine_Auth::getAuth()) :
            include 'responsiveDesign/modalBlocks/adminPanel.php';
        endif;
        include 'responsiveDesign/modalBlocks/modalWindow.php';
        include 'responsiveDesign/header.php';
        include 'responsiveDesign/topMenu.php';
        ?>
        <div id="content">
            <?php $select = Engine_Application::getPageConf();
            if ($select['main']) :
                ?>            
                <?php include 'responsiveDesign/pages/slider.php'; ?>
                <div class="container">
                    <?php include 'responsiveDesign/pages/main.php'; ?>
                </div>
            <?php else : ?>
				<?php if ($this->itIsCatalog) : ?>
					<div class="container">
						<div class="col-sm-12 visible-xs-block padding-lr-0">
							<?php include 'responsiveDesign/breadCrumbs.php'; ?>
							<h1 id="page-title"><?php echo $this->pageTitle; ?></h1>
						</div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 left-column-trade">
                            <?php include 'responsiveDesign/leftColumnCatalogFilter.php'; ?>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 content-trade">
							<div class="hidden-xs">
								<?php include 'responsiveDesign/breadCrumbs.php'; ?>
							</div>
							<?php include 'responsiveDesign/pages/contentBrand.php'; ?>
                        </div>
                    </div>			
                <?php elseif ($auth1->hasIdentity()) : ?>
                    <div class="container">
						<div class="col-sm-12 visible-xs-block padding-lr-0">
							<?php include 'responsiveDesign/breadCrumbs.php'; ?>
							<h1 id="page-title"><?php echo $this->pageTitle; ?></h1>
						</div>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 left-column-trade">
                            <?php include 'responsiveDesign/leftColumn.php'; ?>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 content-trade">
							<div class="hidden-xs">
								<?php include 'responsiveDesign/breadCrumbs.php'; ?>
							</div>
							<?php include 'responsiveDesign/pages/contentBrand.php'; ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="container">
						<?php include 'responsiveDesign/breadCrumbs.php'; ?>
						<div class="col-sm-12 visible-xs-block padding-lr-0">
							<h1 id="page-title"><?php echo $this->pageTitle; ?></h1>
						</div>
                        <?php include 'responsiveDesign/pages/contentBrand.php'; ?>               
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
<?php include 'responsiveDesign/footer.php';
include 'responsiveDesign/beforeBodyEnd.php';
?>        
    </body>
</html>