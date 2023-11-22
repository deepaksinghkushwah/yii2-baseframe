<?php

use yii\helpers\Url;

echo \yii\widgets\Menu::widget([
    'options' => ['class' => 'sidebar-menu treeview'],
    'items' => [
        ['label' => 'Navigation', 'options' => ['class' => 'header']],
        ['label' => "<i class='fa fa-home'></i> <span>Home</span>", 'url' => Url::to(['/backend/default/index'], true)],
        ['label' => "<i class='fa fa-lock'></i> <span>RBAC</span>", 'url' => Url::to(['/admin/role'], true)],
        ['label' => "<i class='fa fa-user'></i> <span>User Manager</span>", 'url' => Url::to(['/backend/user/index'], true)],
        
        
        ['label' => "<i class='fa fa-edit'></i> <span>Pages Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                ['label' => 'List All Page Categories', 'url' => Url::to(['/backend/pagecategory/index'], true)],
                ['label' => 'Create Page Category', 'url' => Url::to(['/backend/pagecategory/create'], true)],
                ['label' => 'Create Page', 'url' => Url::to(['/backend/page/create'], true)],
                ['label' => 'List All Pages', 'url' => Url::to(['/backend/page/index'], true)],
                ['label' => 'Manage Comments', 'url' => Url::to(['/backend/comment/index'], true)],
            ],
        ],
        ['label' => "<i class='fa fa-suitcase'></i> <span>Site Manager</span>",
            'url' => ['#'],
            'template' => '<a href="{url}" >{label}<i class="fa fa-angle-left pull-right"></i></a>',
            'items' => [
                ['label' => "<i class='fa fa-image'></i> <span>Themes</span>", 'url' => Url::to(['/backend/theme/index'], true)],
                ['label' => "<i class='fa fa-image'></i> <span>Banner</span>", 'url' => Url::to(['/backend/banner/index'], true)],
                ['label' => "<i class='fa fa-gears'></i> <span>General Settings</span>", 'url' => Url::to(['/backend/setting'], true)],
                ['label' => "<i class='fa fa-gears'></i> <span>Menu Manager</span>", 'url' => Url::to(['/backend/menu/index'], true)],
                ['label' => "<i class='fa fa-gears'></i> <span>Media Manager</span>", 'url' => Url::to(['/backend/media/index'], true)],
            ],
        ],
        ['label' => "<i class='fa fa-minus'></i> <span>Logout</span>", 'url' => Url::to(['/site/logout'], true)],
    ],
    'submenuTemplate' => "\n<ul class='treeview-menu'>\n{items}\n</ul>\n",
    'encodeLabels' => false, //allows you to use html in labels
    'activateParents' => true,]);

