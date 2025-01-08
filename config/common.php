<?php

return [
    'days_of_week' => [
        0 => 'Chủ Nhật',
        1 => 'Thứ Hai',
        2 => 'Thứ Ba',
        3 => 'Thứ Tư',
        4 => 'Thứ Năm',
        5 => 'Thứ Sáu',
        6 => 'Thứ Bảy',
    ],
    'google_map' => [
        'url' => 'https://www.google.com/maps',
    ],
    'checkin_threshold' => env('CHECKIN_THRESHOLD', 30),
    'checkin_limit' => env('CHECKIN_LIMIT', 30),
];
