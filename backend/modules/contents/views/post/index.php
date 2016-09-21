<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contents\models\search\Post */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?php if (Helper::checkRoute('create')) { 
        echo Html::a('Create Post', ['create'], ['class' => 'btn btn-success']); }?>
    </p>
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'id',
            'title',
            'author_id',
            'views',
            'comment_count',
            // 'sort',
            // 'refer_url:url',
            // 'content:ntext',
            // 'created_at',
            // 'updated_at',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => Helper::filterActionColumn('{view}{update}{delete}')
        ],
        ],
        ]); ?>
        </div>
