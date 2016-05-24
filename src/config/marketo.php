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
            'FirstName',
            'LastName',
            'Email',
            'Phone',
            'Company',
            'Address',
            'City',
            'State',
            'PostalCode',
            'Country',
            'Website',
            'LeadSource',
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
