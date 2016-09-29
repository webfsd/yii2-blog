<?php

use common\widgets\Label;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use mdm\admin\components\Helper;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contents\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?php //echo Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Helper::checkRoute('create')) {
            echo Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']);
        } ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'category',
                'format' => 'html',
                'value' => function ($model) {
                    $categories = ArrayHelper::map($model->category, 'id', 'name');
                    $label = [];
                    foreach ( $categories as $key => $category) {
                        $label[] = Label::widget([
                            'name' => $category,
                            'frequency' => $key
                        ]);
                    }
                    $categoryStr = join(' ',$label);
                    return $categoryStr;
                }
            ],
            [
                'attribute' => 'title',
                'format' => 'html',
                'value' => function ($model, $index, $dataColumn) {
                    return $model->title . Html::a('<span class="glyphicon glyphicon-link"></span>', '');
                }
            ],
            'slug',
            [
                'attribute' => 'author_id',
                'value' => 'author.username',
            ],
            'created_at',
            'views',
            [ // 文章标签
                'attribute' => 'tags',
                'format' => 'html',
                'value' => function ($model) {
                    $tags = $model->tags;
                    $label = [];
                    if (!$tags) return '';
                    foreach (explode(',', $tags) as $key => $tag) {
                        $label[] = Label::widget([
                            'name' => $tag,
                            'frequency' => $key
                        ]);
                    }

                    $tagStr = join(' ', $label);
                    return $tagStr;
                }
            ],
            // 'comment_count',
            // 'sort',
            // 'enabled_comment',
            // 'description',
            // 'content:ntext',
            // 'password',
            // 'status',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view} {update} {delete}')
            ],
        ],
    ]); ?>
