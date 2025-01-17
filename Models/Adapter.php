<?php
interface RequestJSONTarget{
    public function ToJSON($dbData);
}

class JSONAdapter implements RequestJSONTarget
{
    public function ToJSON($dbData)
    {
        // echo "Started";
        $filepath = __DIR__ . "/data/RequestJSON.txt";

        // Check if the input is a valid array (of associative arrays or a single associative array)
        if (!is_array($dbData) || empty($dbData) || !isset($dbData[0])) {
            throw new InvalidArgumentException("Input must be an associative array or an array of associative arrays.");
        }

        // Ensure the directory exists
        $directory = dirname($filepath);
        if (!is_dir($directory) && !mkdir($directory, 0755, true)) {
            throw new RuntimeException("Failed to create directory: $directory.");
        }

        // Convert the map to JSON
        $jsonContent = json_encode($dbData, JSON_PRETTY_PRINT);
        // echo "json encoded";

        if ($jsonContent === false) {
            throw new RuntimeException("Failed to encode array to JSON.");
        }

        // Save the JSON content to the specified file path
        if (file_put_contents($filepath, $jsonContent) === false) {
            // echo "failed";
            throw new RuntimeException("Failed to write JSON to file: $filepath.");
        }
        // echo "Success";
    }
}


// $map = [
//     "name" => "Alice",
//     "email" => "alice@example.com",
//     "role" => "admin"
// ];
// $adapter = new JSONAdapter();
// try{
// echo $adapter->ToJSON($map);
// }
// catch (Exception $e){
//     echo " Error: " . $e->getMessage();
// }