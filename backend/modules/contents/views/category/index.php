<?php

use common\models\Category;
use yii\helpers\Html;
use yii\grid\GridView;
use mdm\admin\components\Helper;

use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\contents\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php if (Helper::checkRoute('create')) {
            echo Html::a(Yii::t('app', 'Create Category'), ['create'], ['class' => 'btn btn-success']);
        } ?>
    </p>
    <?php Pjax::begin(); ?>            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'content' => function ($model, $key, $index, $column) {
                    $count = Category::getSubCategoriesCount($model->id);
                    if ($count == 0) {
                        $str = ' 新增';
                        return $model->name . Html::a($str, ['/contents/category/create', 'parent' => $model->id]);
                    } else {
                        $str = '(' . $count . '个分类)';
                        return $model->name . Html::a($str, ['/contents/category', 'parent' => $model->id]);
                    }
                }
            ],
//            'id',
//            'name',
            'slug',
//            'parent',
            [
                'attribute'=>'parent',
                'content'=>function ($model, $key, $index, $column) {
                   if($model->parent == 0){
                       return '顶级分类';
                   } else{
                       return Category::getCategoryNameByParentId($model->parent)->name;
                   }
                },
            ],
            'order',
            'count',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => Helper::filterActionColumn('{view}{update}{delete}')
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
