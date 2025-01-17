<?php

class DB
{

    public static function save($object, $file, $idField)
    {
        $file = __DIR__ . $file;

        if (isset($object[$idField])) $object[$idField] = self::getLatestId($file, $idField) + 1;
        else throw new Exception($idField . " field not found in object");

        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
        $data[] = $object;
        if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT))) return $object[$idField];
        return -1;
    }

    public static function getLatestId($file, $idField)
    {

        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        if ($data === null || !is_array($data) || empty($data)) {
            return 0;
        }

        // Extract the IDs and find the maximum
        $ids = array_map(function ($item) use ($idField) {
            return isset($item[$idField]) ? (int)$item[$idField] : 0;
        }, $data);

        return !empty($ids) ? max($ids) : 0;
    }

    public static function findById($file, $id, $idField)
    {
        $file = __DIR__ . $file;

        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        if ($data === null || !is_array($data) || empty($data)) {
            return null;
        }

        foreach ($data as $item) {
            if (isset($item[$idField]) && $item[$idField] == $id) {
                return $item;
            }
        }

        return null;
    }

    public static function all($file)
    {
        $file = __DIR__ . $file;

        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        if ($data === null || !is_array($data) || empty($data)) {
            return [];
        }

        return $data;
    }

    public static function findBy($file, $field, $value)
    {
        $file = __DIR__ . $file;

        $data = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        if ($data === null || !is_array($data) || empty($data)) {
            return null;
        }

        foreach ($data as $item) {
            if (isset($item[$field]) && $item[$field] == $value) {
                return $item;
            }
        }

        return null;
    }

}
