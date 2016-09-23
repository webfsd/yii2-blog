<?php
return [
    'admin' => [
        'class' => 'mdm\admin\Module',
        // 'layout' => 'left-menu', // yii2-admin的导航菜单
    ],
    'contents' => [
        'class' => 'backend\modules\contents\Content',
    ],
    'gridview' => [
        'class' => '\kartik\grid\Module'
    ],
    'markdown' => [
        'class' => 'kartik\markdown\Module',
        // the controller action route used for markdown editor preview
        'previewAction' => '/markdown/parse/preview',

        // the list of custom conversion patterns for post processing
        'customConversion' => [
            '<table>' => '<table class="table table-bordered table-striped">'
        ],

        // whether to use PHP SmartyPantsTypographer to process Markdown output
        'smartyPants' => true
    ],
    'curdermarkdown'=>[
        'class'=>'curder\markdown\Module',
    ],
];