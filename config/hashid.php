<?php

return [

    'hash_data' => [

        /*
        * Set hashing key to be encrypt and decrypt by
        */
        'key' => env('HASHID_KEY'),

        /*
         * Length for encrypted data.
         */

        'length' => env('HASHID_LENGTH', 6),
    ]
];
