<?php

return [
    [
        'id' => 1000000,
        'specialist_id' => 1,
        'company' => 'Test Company',
        'start_date' => (new DateTimeImmutable('today'))->format('Y-m-d'),
        'end_date' => (new DateTimeImmutable('today'))->format('Y-m-d'),
    ],
];
