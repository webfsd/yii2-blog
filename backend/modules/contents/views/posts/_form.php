<?php

use backend\modules\contents\models\Post;
use backend\widgets\ActiveForm;
use common\models\Category;
use common\models\Posts;
use curder\markdown\Markdown;
use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\DateTimePicker;
use kartik\widgets\Select2;
use yii\bootstrap\Tabs;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">
    <div class="row">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-md-9">

            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'content')->widget(Markdown::className(), [
                'language' => 'zh',
                'useImageUpload' => true,
                'uploadImageUrl' => '/upload/image',
                'deleteImageUrl' => '/upload/delete-image',
                'uploadFileUrl' => '/upload/file',
                'deleteFileUrl' => '/upload/delete-file',
                'domain' => 'http://www.blog.com/',
                'rows' => 20
            ]); ?>

        </div>

        <div class="col-md-3">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-block' : 'btn btn-primary btn-block']) ?>
            </div>
            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'category')->widget(Select2::className(), [
                'data' => Category::getCategories(),
                'value' => [1],
                'language' => 'zh-CN',
                'options' => ['placeholder' => '请选择分类', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>

            <?= $form->field($model, 'tags')->widget(SelectizeTextInput::className(), [
                'loadUrl' => ['tags/list'],
                'options' => ['class' => 'form-control'],
                'clientOptions' => [
                    'plugins' => ['remove_button'],
                    'valueField' => 'name',
                    'labelField' => 'name',
                    'searchField' => ['name'],
                    'create' => true,
                ],
            ]); ?>

            <div class="form-group">
                <label for="posts-created_at" class="control-label">创建时间</label>
                <?= DateTimePicker::widget([
                    'model' => $model,
                    'attribute' => 'created_at',
                    'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-m-dd hh:ii'
                    ]
                ]) ?>
                <div class="hint-block"><?= $model->attributeHints()['created_at']; ?></div>
            </div>

            <?= $form->field($model, 'status')->dropDownList([
                Posts::STATUS_PUBLISH => '公开',
                Posts::STATUS_HIDDEN => '隐藏',
            ]); ?>



            <?= $form->field($model, 'enabled_comment')->dropDownList([
                Posts::STATUS_PUBLISH => '开启',
                Posts::STATUS_HIDDEN => '隐藏',
            ]); ?>

        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
