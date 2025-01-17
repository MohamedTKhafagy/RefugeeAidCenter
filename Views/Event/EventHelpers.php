<?php
function getEventTypeName($type)
{
    $types = [
        0 => 'Health',
        1 => 'Food',
        2 => 'Clothing',
        3 => 'Education',
        4 => 'Housing'
    ];
    return $types[$type] ?? 'Other';
}
