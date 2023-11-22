<?php

return [
    'user.passwordResetTokenExpire' => 3600,
    'adminName' => 'Super Administrator',
    'dateFormat' => 'l d, M Y',
    'employeeRole' => 'Registered',
    'profileImagePathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/profile/",
    'profileImagePathWeb' => '/images/profile/',
    'attachmentPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/attachments/",
    'attachmentPathWeb' => '/images/attachments/',
    'bannerPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/banners/",
    'bannerPathWeb' => '/images/banners/',
    'mediaPathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/images/media/",
    'mediaPathWeb' => '/images/media/',
    'themePathOs' => str_replace("\\", "/", realpath(dirname('../'))) . "/custom-theme/",
    'themePathWeb' => '/custom-theme/',
    'status' => [
        '1' => 'Active',
        '0' => 'Inactive'
    ],
    'menu' => [
        'locations' => [
            'left' => 'Left',
            'right' => 'Right',
            'top' => 'Top',
            'bottom' => 'Bottom',
        ],
        'types' => [
            '1' => 'Dropdown',
            '2' => 'List'
        ],
        'item_type' => [
            '1' => 'Indivisual',
            '2' => 'Category'
        ],
    ]
];
