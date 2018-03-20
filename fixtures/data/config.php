<?php

return [
    [
        'param' => 'ADMIN_EMAIL',
        'value' => 'example@gmail.com',
        'default' => 'example@gmail.com',
        'label' => 'Admin Email',
        'type' => 'string',
    ],
    [
        'param' => 'SUPPORT_EMAIL',
        'value' => 'example@gmail.com',
        'default' => 'example@gmail.com',
        'label' => 'Support Email',
        'type' => 'string',
    ],
    [
        'param' => 'INBOX_DATA',
        'value' => 'a:3:{s:8:"hostname";s:8:"hostname";s:8:"username";s:8:"username";s:8:"password";s:8:"password";}',
        'default' => 'hostname, username, password',
        'label' => 'Inbox Data',
        'type' => 'array',
    ],
    [
        'param' => 'HEADER_FOR_EMAIL_SEARCH',
        'value' => 'Конференція',
        'default' => 'Subject',
        'label' => 'Header for email search',
        'type' => 'string',
    ],
    [
        'param' => 'EMAIL_READING_LIMIT',
        'value' => '5',
        'default' => '5',
        'label' => 'Email Reading Limit',
        'type' => 'string',
    ],
    [
        'param' => 'VERIFICATION_WORDS_TO_TAG_UA',
        'value' => 'a:1:{i:0;s:25:"Ключові слова";}',
        'default' => 'Ключові слова',
        'label' => 'Verification words to tag Ua',
        'type' => 'array',
    ],
    [
        'param' => 'VERIFICATION_WORDS_TO_TAG_RU',
        'value' => 'a:1:{i:0;s:27:"Ключевые слова";}',
        'default' => 'Ключевые слова',
        'label' => 'Verification words to tag Ru',
        'type' => 'array',
    ],
    [
        'param' => 'VERIFICATION_WORDS_TO_TAG_US',
        'value' => 'a:3:{i:0;s:8:"Keywords";i:1;s:9:"Key words";i:2;s:10:"Кey words";}',
        'default' => 'Keywords',
        'label' => 'Verification words to tag Us',
        'type' => 'array',
    ],
];