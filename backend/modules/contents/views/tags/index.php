<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <p>
        <?php if (Helper::checkRoute('create')) { 
        echo Html::a('Create Tags', ['create'], ['class' => 'btn btn-success']); }?>
    </p>
    <?php Pjax::begin(); ?>            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'id',
            'name',
            'frequency',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => Helper::filterActionColumn('{view}{update}{delete}')
        ],
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>
