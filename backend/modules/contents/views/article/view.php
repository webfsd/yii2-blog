<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use mdm\admin\components\Helper;

/* @var $this yii\web\View */
/* @var $model backend\modules\contents\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Helper::checkRoute('update')) { 
        echo Html::a('Update ', ['update','id' => $model->id], ['class' => 'btn btn-success']); }?>

        <?php if  (Helper::checkRoute('delete')) { 
Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]); } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'author_id',
            'views',
            'comment_count',
            'sort',
            'refer_url:url',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
