<?php

return [
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => [
        'font_dir' => storage_path('fonts/'),
        'font_cache' => storage_path('fonts/'),
        'temp_dir' => storage_path('fonts/'),
        'chroot' => base_path(),
        'log_output_file' => null,
        'default_media_type' => 'screen',
        'default_paper_size' => 'b5',
        'default_font' => 'noto-sans-jp',
        'is_font_subsetting_enabled' => true,
        'pdf_backend' => 'CPDF',
        'default_media_type' => 'screen',
        'dpi' => 96,
        'font_height_ratio' => 1.1,
        'is_html5_parser_enabled' => true,
        'is_remote_enabled' => true,
        'is_php_enabled' => true,
        'is_javascript_enabled' => false,
        'is_font_subsetting_enabled' => false,
        'pdfa' => false,
        'pdfx' => false,
    ],
];
