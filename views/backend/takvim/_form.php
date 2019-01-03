<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

//@var $this yii\web\View 
//@var $model kouosl\takvim\models\Takvim
//@var $form yii\widgets\ActiveForm 
?>

<div class="takvim-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tatilgunleri')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
