<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            items: 1,
            dots: true,
            dotsClass: 'owl-dotes',
            autoplay: true,
            autoplayHoverPause: true,
            loop: true,
        });
    });
</script>
<?php
$slidesCount = count($this->layout()->slides);
if ($slidesCount) :
    ?>
    <div class="owl-carousel">
        <?php foreach ($this->layout()->slides as $value) : ?>
            <div>
                <a href="<?php echo ($value->url ? $value->url : '#'); ?>">
                    <img src="/<?php echo $value->file; ?>" />
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<hr class="slider-mobile visible-xs-block" />