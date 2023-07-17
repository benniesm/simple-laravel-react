<?php

function successResponse($type, $items, $list)
{
    $formatData = function ($item) use ($type) {
        return [
            'type' => $type,
            'id' => $item['id'],
            'attributes' => $item
        ];
    };

    $data_object = [];
    if ($list) {
        foreach ($items as $item) {
            $data = $formatData($item);        
            array_push($data_object, $data);
        }
    } else {
        $data_object = $formatData($items);
    }

    return $data_object;
}

function errorResponse($title, $message)
{
    $error_object = [
        'title' => $title,
        'detail' => $message
    ];

    return $error_object;
}
