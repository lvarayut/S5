<?php

namespace Enstb\Bundle\DataManagementBundle\Utils;


class DataTransform {

    static public function transform($path,$fileName)
    {
        $fileRead = $path."/".$fileName;
        $fileWrite = $path."/".substr($fileName,0,count($fileName)-5)."_transformed.txt";
        $handle = fopen($fileRead, "r") or die("Couldn't open $fileRead");
        // Read data line by line
        while (($line = fgets($handle)) !== false) {
            $dataTransformed = "";
            // Split each line by space
            $dataArray = explode(" ", $line);
            // Concatenate first and second words
            $dataTransformed .= $dataArray[0]." ";
            $dataTransformed .= $dataArray[1]." ";
            // Add hyphen between words for combining an activity into one word
            for($i=2;$i<count($dataArray)-1;$i++){
                // Don't append hyphen for the last word of activity
                if($i==count($dataArray)-2){
                    $dataTransformed .= $dataArray[$i]." ";
                }
                else{
                    $dataTransformed .= $dataArray[$i]."-";
                }
            }
            // Concatenate the last word
            $dataTransformed .= $dataArray[count($dataArray)-1];
            // Write the data
            file_put_contents($fileWrite, $dataTransformed, FILE_APPEND | LOCK_EX);
        }
        fclose($handle);
    }
} 