<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//@var $this yii\web\View 
//@var $model kouosl\takvim\models\Takvim 

$this->title = $model->tatilgunleri;
$this->params['breadcrumbs'][] = ['label' => 'Takvims', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="takvim-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->tatilgunleri], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->tatilgunleri], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tatilgunleri',
        ],
    ]) ?>

</div>
