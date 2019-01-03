<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Takvim */

$this->title = 'Create Takvim';
$this->params['breadcrumbs'][] = ['label' => 'Takvims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="takvim-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
