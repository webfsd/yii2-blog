<?php

use backend\modules\contents\models\Post;
use dosamigos\selectize\SelectizeTextInput;
use kartik\widgets\DateTimePicker;
use yii\bootstrap\Tabs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\contents\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-9">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>

        <div class="col-md-3">
            <?= Tabs::widget([
                'renderTabContent' => false,
                'items' => [
                    ['label' => '选项', 'options' => ['id' => 'options']],
                    ['label' => '附件', 'options' => ['id' => 'files']],
                ],
            ]) ?>

            <div class="tab-content">
                <div id="options" class="tab-pane active">

                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])->hint('输入一个唯一标识') ?>

                    <div class="form-group">
                        <label class="control-label"><?= $model->attributeLabels()['created_at'] ?></label>
                        <?= DateTimePicker::widget([
                            'model' => $model,
                            'attribute' => 'created_at',
                            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-m-dd hh:ii'
                            ]
                        ]) ?>
                    </div>

                    <?= $form->field($model, 'status')->dropDownList([
                        Post::STATUS_PUBLISH => '公开',
                        Post::STATUS_HIDDEN => '隐藏',
                    ])->hint('请选择状态'); ?>

                    <?= $form->field($model, 'tagNames')->widget(SelectizeTextInput::className(), [
                        'loadUrl' => ['tag/list'],
                        'options' => ['class' => 'form-control'],
                        'clientOptions' => [
                            'plugins' => ['remove_button'],
                            'valueField' => 'name',
                            'labelField' => 'name',
                            'searchField' => ['name'],
                            'create' => true,
                        ],
                    ])->hint('Use commas to separate tags'); ?>

                </div>
                <div id="files" class="tab-pane">

                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
