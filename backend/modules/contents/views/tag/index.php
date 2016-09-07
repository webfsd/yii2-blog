<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contents\models\searchs\Tag */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?php if (Helper::checkRoute('create')) { 
        echo Html::a('Create Tag', ['create'], ['class' => 'btn btn-success']); }?>
    </p>
    <?php Pjax::begin(); ?>            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'id',
            'tag_name',
            'tag_type',
            'data_id',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => Helper::filterActionColumn('{view}{update}{delete}')
        ],
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>
