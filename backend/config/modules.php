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
    'markdown'=>[
        'class'=>'curder\markdown\Module',
    ],
];