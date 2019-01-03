<?php

use yii\helpers\Html;

//@var $this yii\web\View
//@var $model kouosl\takvim\models\Takvim 

$this->title = 'Update Takvim: ' . $model->tatilgunleri;
$this->params['breadcrumbs'][] = ['label' => 'Takvims', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tatilgunleri, 'url' => ['view', 'id' => $model->tatilgunleri]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="takvim-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
