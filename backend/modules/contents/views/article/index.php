<?php

use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contents\models\searchs\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?php if (Helper::checkRoute('create')) { 
        echo Html::a('Create Article', ['create'], ['class' => 'btn btn-success']); }?>
    </p>
    <?php Pjax::begin(); ?>            <?= GridView::widget([
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
            // 'created_at',
            // 'updated_at',

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => Helper::filterActionColumn('{view}{update}{delete}')
        ],
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>
