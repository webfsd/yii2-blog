<?php

use common\models\Category;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="category-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(); ?>
    <?= $form->field($model, 'slug')->textInput() ?>

    <?= $form->field($model, 'parent')->widget(Select2::className(), [
        'data' =>  array_merge(['顶级分类'], (new Category())->getCategories() ? : []),
        'language' => 'zh-CN',
        'options' => [
            'placeholder' => '请选择上级分类',
            'options' =>  $model->isNewRecord ? [] : (new Category())->getDisabledIds($model->id),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <?= $form->field($model, 'description')->textarea() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>