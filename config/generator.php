<?php

return [
    /**
     * If any input file(image) as default will used options below.
     */
    'image' => [
        /**
         * Path for store the image.
         *
         * avaiable options:
         * 1. public
         * 2. storage
         */
        'path' => 'storage',

        /**
         * Will used if image is nullable and default value is null.
         */
        'default' => 'https://via.placeholder.com/350?text=No+Image+Avaiable',

        /**
         * Crop the uploaded image using intervention image.
         */
        'crop' => true,

        /**
         * When set to true the uploaded image aspect ratio will still original.
         */
        'aspect_ratio' => true,

        /**
         * Crop image size.
         */
        'width' => 500,
        'height' => 500,
    ],

    'format' => [
        /**
         * Will used to first year on select, if any column type year.
         */
        'first_year' => 1900,

        /**
         * If any date column type will cast and display used this format, but for input date still will used Y-m-d format.
         *
         * another most common format:
         * - M d Y
         * - d F Y
         * - Y m d
         */
        'date' => 'd/m/Y',

        /**
         * If any input type month will cast and display used this format.
         */
        'month' => 'm/Y',

        /**
         * If any input type time will cast and display used this format.
         */
        'time' => 'H:i',

        /**
         * If any datetime column type or datetime-local on input, will cast and display used this format.
         */
        'datetime' => 'd/m/Y H:i',

        /**
         * Limit string on index view for any column type text or longtext.
         */
        'limit_text' => 100,
    ],

    /**
     * It will used for generator to manage and showing menus on sidebar views.
     *
     * Example:
     * [
     *   'header' => 'Main',
     *
     *   // All permissions in menus[] and submenus[]
     *   'permissions' => ['test view'],
     *
     *   menus' => [
     *       [
     *          'title' => 'Main Data',
     *          'icon' => '<i class="bi bi-collection-fill"></i>',
     *          'route' => null,
     *
     *          // permission always null when isset submenus
     *          'permission' => null,
     *
     *          // All permissions on submenus[] and will empty[] when submenus equals to []
     *          'permissions' => ['test view'],
     *
     *          'submenus' => [
     *                 [
     *                     'title' => 'Tests',
     *                     'route' => '/tests',
     *                     'permission' => 'test view'
     *                  ]
     *               ],
     *           ],
     *       ],
     *  ],
     *
     * This code below always changes when you use a generator and maybe you must lint or format the code.
     */
    'sidebars' => [
    [
        'header' => 'Employee',
        'permissions' => [
            'department view',
            'employee view',
            'gpslocation view',
            'branch office view'
        ],
        'menus' => [
            [
                'title' => 'Employee',
                'icon' => '<i class="bi bi-list"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'department view',
                    'employee view',
                    'gpslocation view',
                    'branch office view'
                ],
                'submenus' => [
                    [
                        'title' => 'Employees List',
                        'route' => '/employees',
                        'permission' => 'employee view'
                    ],
                    [
                        'title' => 'Branch Offices',
                        'route' => '/branch-offices',
                        'permission' => 'branch office view'
                    ],
                    [
                        'title' => 'Departments',
                        'route' => '/departments',
                        'permission' => 'department view'
                    ],
                    [
                        'title' => 'Gps Locations',
                        'route' => '/gpslocations',
                        'permission' => 'gpslocation view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'Attendances',
        'permissions' => [
            'attendance view',
            'izinsakit view',
            'attendance revision view',
            'leave request view',
            'ranking view',
            'offday view',
            'not present view'
        ],
        'menus' => [
            [
                'title' => 'Attendances',
                'icon' => '<i class="bi bi-calendar"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'attendance view',
                    'izinsakit view',
                    'attendance revision view',
                    'leave request view',
                    'ranking view',
                    'offday view',
                    'not present view'
                ],
                'submenus' => [
                    [
                        'title' => 'Attendances',
                        'route' => '/attendances',
                        'permission' => 'attendance view'
                    ],
                    [
                        'title' => 'Izin Or Sakit',
                        'route' => '/izinsakits',
                        'permission' => 'izinsakit view'
                    ],
                    [
                        'title' => 'Attendance Revisions',
                        'route' => '/attendance-revisions',
                        'permission' => 'attendance revision view'
                    ],
                    [
                        'title' => 'Leave Requests',
                        'route' => '/leave-requests',
                        'permission' => 'leave request view'
                    ],
                    [
                        'title' => 'Ranking Points',
                        'route' => '/rankings',
                        'permission' => 'ranking view'
                    ],
                    [
                        'title' => 'Offdays',
                        'route' => '/offdays',
                        'permission' => 'offday view'
                    ],
                    [
                        'title' => 'Not Presents',
                        'route' => '/not-presents',
                        'permission' => 'not present view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'Payroll',
        'permissions' => [
            'earning view',
            'deduction view',
            'monthly view'
        ],
        'menus' => [
            [
                'title' => 'Payroll',
                'icon' => '<i class="bi bi-cash-stack"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'earning view',
                    'deduction view',
                    'monthly view'
                ],
                'submenus' => [
                    [
                        'title' => 'Monthly Payroll',
                        'route' => '/monthlies',
                        'permission' => 'monthly view'
                    ],
                    [
                        'title' => 'Static Earnings',
                        'route' => '/earnings',
                        'permission' => 'earning view'
                    ],
                    [
                        'title' => 'Static Deductions',
                        'route' => '/deductions',
                        'permission' => 'deduction view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'News',
        'permissions' => [
            'categorynews view',
            'news view'
        ],
        'menus' => [
            [
                'title' => 'News',
                'icon' => '<i class="bi bi-newspaper"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'categorynews view',
                    'news view'
                ],
                'submenus' => [
                    [
                        'title' => 'Category News',
                        'route' => '/categorynews',
                        'permission' => 'categorynews view'
                    ],
                    [
                        'title' => 'News',
                        'route' => '/news',
                        'permission' => 'news view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'Banners',
        'permissions' => [
            'banner view'
        ],
        'menus' => [
            [
                'title' => 'Banners Management',
                'icon' => '<i class="bi bi-image"></i>',
                'route' => '/banners',
                'permission' => 'banner view',
                'permissions' => [],
                'submenus' => []
            ]
        ]
    ],
    [
        'header' => 'Banks',
        'permissions' => [
            'bank view'
        ],
        'menus' => [
            [
                'title' => 'Banks Management',
                'icon' => '<i class="bi bi-bank"></i>',
                'route' => '/banks',
                'permission' => 'bank view',
                'permissions' => [],
                'submenus' => []
            ]
        ]
    ],
    [
        'header' => 'Website',
        'permissions' => [
            'company view'
        ],
        'menus' => [
            [
                'title' => 'Setting Apps',
                'icon' => '<i class="bi bi-globe"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'company view'
                ],
                'submenus' => [
                    [
                        'title' => 'Setting Company',
                        'route' => '/companies',
                        'permission' => 'company view'
                    ]
                ]
            ]
        ]
    ],
    [
        'header' => 'Utilities',
        'permissions' => [
            'user view',
            'role & permission view'
        ],
        'menus' => [
            [
                'title' => 'Users & Roles',
                'icon' => '<i class="bi bi-people"></i>',
                'route' => null,
                'permission' => null,
                'permissions' => [
                    'user view',
                    'role & permission view'
                ],
                'submenus' => [
                    [
                        'title' => 'Users',
                        'route' => '/users',
                        'permission' => 'user view'
                    ],
                    [
                        'title' => 'Roles & permissions',
                        'route' => '/roles',
                        'permission' => 'role & permission view'
                    ]
                ]
            ]
        ]
    ]
]
];
