<?php
/* @var $this MainController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';

?>
<div class="error-page">
    <h2>Error <?php echo $code; ?></h2>

    <div class="error">
        <?php echo CHtml::encode($message); ?>
    </div>
</div>