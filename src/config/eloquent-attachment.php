<?php

return [

    'tmp_path'             => public_path('system/'),

    'uploaded_file_suffix' => '_path',

    'attachment_driver'    => [

        // 'image' => [

        //     'transformations' => [

        //     ],
        //     'thumbnails'      => array(
        //         // 1st thumbnail
        //         [
        //             // where to save the thumbnail
        //             'path'            => 'upload/images/thumbs/',
        //             // prefix for the thumbnail filename
        //             'prefix'          => 'thumb_',
        //             // transformations for the thumbnail, refer to the Image module on available methods
        //             'transformations' => array(
        //                 'resize' => array(500, 500, Image::AUTO), // width, height, master dimension
        //                 'crop'   => array(100, 100, null, null), // width, height, offset_x, offset_y
        //             ),
        //             // desired quality of the saved thumbnail, default 100
        //             'quality'         => 50,
        //         ],

        //     ),

        // ],
    ],
];
