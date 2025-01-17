<?php
interface RequestJSONTarget{
    public function ToJSON($dbData);
}

class JSONAdapter implements RequestJSONTarget
{
    public function ToJSON($dbData)
    {
        
        $filepath = __DIR__ . "/data/RequestJSON.txt";

        
        if (!is_array($dbData) || empty($dbData) || !isset($dbData[0])) {
            throw new InvalidArgumentException("Input must be an associative array or an array of associative arrays.");
        }

        
        $directory = dirname($filepath);
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            throw new RuntimeException("Failed to create directory: $directory.");
        }

        
        $jsonContent = json_encode($dbData, JSON_PRETTY_PRINT);
        

        if ($jsonContent === false) {
            throw new RuntimeException("Failed to encode array to JSON.");
        }

        
        if (file_put_contents($filepath, $jsonContent) === false) {
            
            throw new RuntimeException("Failed to write JSON to file: $filepath.");
        }
        
    }
}

//test
// $map = [
//     "name" => "Alice",
//     "email" => "alice@example.com",
//     "role" => "admin"
// ];
// $adapter = new JSONAdapter();
// 
// echo $adapter->ToJSON($map);