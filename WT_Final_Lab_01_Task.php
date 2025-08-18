<?php

// 1
$array = [1, 2, 3, 4, 5];
$sum = array_sum($array);
echo "Sum of the elements: " . $sum . "\n";

// 2
sort($array);
$second_max = $array[count($array) - 2];
echo "Second maximum number: " . $second_max . "\n";

// 3
$rows = 5; 
echo "Right-angled star triangle:\n";
for($i = 1; $i <= $rows; $i++) {
    for($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "\n";
}

//  4
$string = "Hello World";
$reversed = strrev($string);
echo "Reversed string: " . $reversed . "\n";

//  5
$word = "programming";
$vowels = "";
$consonants = "";

for ($i = 0; $i < strlen($word); $i++) {
    $char = strtolower($word[$i]);
    if (in_array($char, ['a', 'e', 'i', 'o', 'u'])) {
        $vowels .= $word[$i];
    } else {
        $consonants .= $word[$i];
    }
}

echo "Vowels: " . $vowels . "\n";
echo "Consonants: " . $consonants . "\n";

?>
