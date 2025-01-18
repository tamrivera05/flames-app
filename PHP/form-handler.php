<?php
    header('Access-Control-Allow-Origin: http://localhost:3000');

    $input1 = $_POST['name1'];
    $input2 = $_POST['birthdate1'];
    $input3 = $_POST['zodiacSign1'];

    $input4 = $_POST['name2'];
    $input5 = $_POST['birthdate2'];
    $input6 = $_POST['zodiacSign2'];

    // FLAMES mapping
    $flames = [
        1 => 'Friends',
        2 => 'Lovers',
        3 => 'Anger',
        4 => 'Married',
        5 => 'Engaged',
        0 => 'Soulmates', // 0 corresponds to 'S'
    ];

    // Clean and normalize the input names (remove spaces, make lowercase)
    $name1 = strtolower(str_replace(' ', '', $input1));
    $name2 = strtolower(str_replace(' ', '', $input4));

    // Count the frequency of each letter in both names
    $name1Count = count_chars($name1, 1); // Frequency of letters in name1
    $name2Count = count_chars($name2, 1); // Frequency of letters in name2

    // Count the common letters
    $commonCount = 0;
    foreach ($name1Count as $char => $count1) {
        if (isset($name2Count[$char])) {
            // Add the minimum count of the common letter from both names
            $commonCount += min($count1, $name2Count[$char]);
        }
    }   

    // Calculate the total number of common letters
    $totalCommon = $commonCount;

    // Calculate the FLAMES result
    $resultIndex = $totalCommon % 6; // Get the remainder when divided by 6
    $result = $flames[$resultIndex]; // Get the corresponding FLAMES result



    echo json_encode([$result, $input1, $input2, $input3,$input4, $input5, $input6]);
?> 