<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Tooltip Message
    |--------------------------------------------------------------------------
    |
    | Text that appears in the tooltip when the cursor hover the bubble, before
    | the popup opens.
    |
    */

    'tooltip' => 'Gib uns Feedback',

    /*
    |--------------------------------------------------------------------------
    | Popup Title
    |--------------------------------------------------------------------------
    |
    | This is the text that will appear below the logo in the feedback popup
    |
    */

    'title' => 'Gib uns Feedback',

    /*
    |--------------------------------------------------------------------------
    | Success Message
    |--------------------------------------------------------------------------
    |
    | This message will be displayed if the feedback message is correctly sent.
    |
    */

    'success' => 'Vielen Dank für dein Feedback!',

    /*
    |--------------------------------------------------------------------------
    | Placeholder
    |--------------------------------------------------------------------------
    |
    | This text will appear as the placeholder of the textarea in which the
    | the user will type his feedback.
    |
    */

    'placeholder' => 'Schreib hier dein Feedback...',

    /*
    |--------------------------------------------------------------------------
    | Button Label
    |--------------------------------------------------------------------------
    |
    | Text of the confirmation button to send the feedback.
    |
    */

    'button' => 'Feedback senden',

    /*
    |--------------------------------------------------------------------------
    | Feedback Texts
    |--------------------------------------------------------------------------
    |
    | Must match the feedbacks array from the config file
    |
    */
    'feedbacks' => [
        'like' => [
            'title' => 'Ich finde etwas gut',
            'label' => 'Was hat dir gefallen?',
        ],
        'dislike' => [
            'title' => 'Ich mag etwas nicht',
            'label' => 'Was mochtest du nicht?',
        ],
        'suggestion' => [
            'title' => 'Ich habe einen Vorschlag',
            'label' => 'Wie lautet dein Vorschlag?',
        ],
        // 'bug' => [
        //     'title' => 'I found a bug',
        //     'label' => 'Please explain what happened',
        // ],
    ],
];
