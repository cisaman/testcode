<?php /* @var $this Controller */ ?>

<?php $this->beginContent('//layouts/header'); ?><?php $this->endContent(); ?>

<?php $this->beginContent('//layouts/side_bar/sidebar'); ?><?php $this->endContent(); ?>

<!-- begin MAIN PAGE CONTENT -->
<div id="page-wrapper">

    <?php echo $content; ?>

</div>
<!-- /#page-wrapper -->
<!-- end MAIN PAGE CONTENT -->

<?php $this->beginContent('//layouts/footer'); ?><?php $this->endContent(); ?>