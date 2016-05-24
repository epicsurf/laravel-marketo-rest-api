<?php

return [

    /*
     * Information needed to authenticate to the Marketo REST API.
     */
    'auth' => [
        'client_id' => env('MARKETO_CLIENT_ID'),
        'client_secret' => env('MARKETO_CLIENT_SECRET'),
        'munchkin_id' => env('MARKETO_MUNCHKIN_ID'),
    ],

    'fields' => [

        /*
         * Exclusive list of valid Marketo fields that may be inserted.
         */
        'valid' => [
            'firstName',
            'lastName',
            'email',
            'phone',
            'company',
            'address',
            'city',
            'state',
            'postalCode',
            'country',
            'website',
            'leadSource',
        ],

        /*
         * Marketo fields to be ignored if empty. This can prevent (among other
         * things) unchecked checkboxes from updating values.
         */
        'ignore' => [],

        /*
         * Whether or not to prune fields to only those listed as valid.
         */
        'prune' => env('MARKETO_PRUNE_FIELDS', false),

    ],

];
