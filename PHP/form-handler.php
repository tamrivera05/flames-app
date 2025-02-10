<?php
    header('Access-Control-Allow-Origin: http://localhost:3000');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');

    class Zodiac {
        public $zodiacSign;
        public $symbol;
        public $startDate;
        public $endDate;

        public function __construct($date) {
            $this->assignZodiacSign($date);
        }

        public function assignZodiacSign($date) {
            $zodiacData = file("Zodiac.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($zodiacData as $line) {
                list($zodiacSign, $symbol, $start, $end) = explode("; ", $line);
                if ($this->isDateInRange($date, $start, $end)) {
                    $this->zodiacSign = $zodiacSign;
                    $this->symbol = $symbol;
                    $this->startDate = $start;
                    $this->endDate = $end;
                    break;
                }
            }
        }

        private function isDateInRange($date, $start, $end) {
            $dateObj = strtotime($date);
            $startObj = strtotime($start);
            $endObj = strtotime($end);
            
            if ($startObj > $endObj) {
                return ($dateObj >= $startObj || $dateObj <= $endObj);
            }
            return ($dateObj >= $startObj && $dateObj <= $endObj);
        }

        public static function ComputeZodiacCompatibility($zodiacSign1, $zodiacSign2) {
            $compatibilityChart = [
                "Aries" => ["a Great Match!" => ["Aries", "Leo", "Sagittarius", "Gemini", "Libra", "Aquarius"], "a Favorable Match!" => ["Pisces"], "Not Favorable :(" => ["Taurus", "Virgo", "Capricorn", "Cancer", "Scorpio"]],
                "Leo" => ["a Great Match!" => ["Aries", "Leo", "Sagittarius", "Gemini", "Libra", "Aquarius"], "a Favorable Match!" => ["Cancer", "Scorpio", "Pisces"], "Not Favorable :(" => ["Taurus", "Virgo", "Capricorn"]],
                "Sagittarius" => ["a Great Match!" => ["Aries", "Leo", "Sagittarius", "Gemini", "Libra", "Aquarius"], "a Favorable Match!" => ["Cancer", "Scorpio", "Pisces"], "Not Favorable :(" => ["Taurus", "Virgo", "Capricorn"]],
                "Taurus" => ["a Great Match!" => ["Taurus", "Virgo", "Capricorn", "Cancer", "Scorpio", "Pisces"], "a Favorable Match!" => ["Leo", "Libra"], "Not Favorable :(" => ["Aries", "Sagittarius", "Gemini", "Aquarius"]],
                "Virgo" => ["a Great Match!" => ["Taurus", "Virgo", "Capricorn", "Cancer", "Scorpio"], "a Favorable Match!" => ["Leo", "Aquarius", "Pisces"], "Not Favorable :(" => ["Aries", "Sagittarius", "Gemini", "Libra"]],
                "Capricorn" => ["a Great Match!" => ["Taurus", "Virgo", "Capricorn", "Cancer", "Scorpio", "Pisces"], "a Favorable Match!" => ["Leo", "Libra"], "Not Favorable :(" => ["Aries", "Sagittarius", "Gemini", "Aquarius"]],
                "Gemini" => ["a Great Match!" => ["Aries", "Leo", "Gemini", "Libra", "Aquarius"], "a Favorable Match!" => ["Sagittarius", "Virgo", "Capricorn"], "Not Favorable :(" => ["Taurus", "Cancer", "Scorpio", "Pisces"]],
                "Libra" => ["a Great Match!" => ["Leo", "Sagittarius", "Gemini", "Libra", "Aquarius"], "a Favorable Match!" => ["Aries", "Taurus", "Pisces"], "Not Favorable :(" => ["Virgo", "Capricorn", "Cancer", "Scorpio"]],
                "Aquarius" => ["a Great Match!" => ["Aries", "Leo", "Sagittarius", "Gemini", "Libra", "Aquarius"], "a Favorable Match!" => ["Pisces", "Scorpio"], "Not Favorable :(" => ["Taurus", "Virgo", "Capricorn", "Cancer"]],
                "Cancer" => ["a Great Match!" => ["Taurus", "Virgo", "Capricorn", "Cancer", "Scorpio", "Pisces"], "a Favorable Match!" => ["Leo", "Sagittarius"], "Not Favorable :(" => ["Aries", "Gemini", "Libra", "Aquarius"]],
                "Scorpio" => ["a Great Match!" => ["Taurus", "Virgo", "Capricorn", "Cancer", "Scorpio", "Pisces"], "a Favorable Match!" => ["Aries", "Leo"], "Not Favorable :(" => ["Sagittarius", "Gemini", "Libra", "Aquarius"]],
                "Pisces" => ["a Great Match!" => ["Taurus", "Capricorn", "Cancer", "Scorpio", "Pisces"], "a Favorable Match!" => ["Aries", "Leo", "Sagittarius", "Virgo"], "Not Favorable :(" => ["Gemini", "Libra", "Aquarius"]]
            ];
            
            foreach (["a Great Match!", "a Favorable Match!", "Not Favorable :("] as $level) {
                if (in_array($zodiacSign2, $compatibilityChart[$zodiacSign1][$level])) {
                    return $level;
                }
            }
            return "Unknown";
        }
    }

    class Person {

        public $firstName;
        public $lastName;
        public $birthday;
        public $zodiac;

        public function __construct($firstName, $lastName, $birthday) {
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->birthday = $birthday;
            $this->zodiac = new Zodiac($birthday);
        }

        public function getFullName() {
            return "$this->lastName, $this->firstName";
        }
    }


    $flames = [
        1 => 'Friends',
        2 => 'Lovers',
        3 => 'Anger',
        4 => 'Married',
        5 => 'Engaged',
        0 => 'Soulmates',
    ];

    $name1 = strtolower(str_replace(' ', '', $_POST['$input1, $input2']));
    $name2 = strtolower(str_replace(' ', '', $_POST['$input4, $input5']));
    
    $name1Count = count_chars($name1, 1);
    $name2Count = count_chars($name2, 1);
    
    $commonCount = 0;
    foreach ($name1Count as $char => $count1) {
        if (isset($name2Count[$char])) {
            $commonCount += min($count1, $name2Count[$char]);
        }
    }
    
    $totalCommon = $commonCount;
    $resultIndex = $totalCommon % 6;
    $result = $flames[$resultIndex];

    $input1 = $_POST['firstName1'];
    $input2 = $_POST['lastName1'];
    $input3 = $_POST['birthdate1'];

    $input4 = $_POST['firstName2'];
    $input5 = $_POST['lastName2'];
    $input6 = $_POST['birthdate2'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $person1 = new Person($input1, $input2, $input3);
        $person2 = new Person($input4, $input5, $input6); 
        $zodiacCompatibility = Zodiac::ComputeZodiacCompatibility($person1->zodiac->zodiacSign, $person2->zodiac->zodiacSign);
        
        echo json_encode([
            "fullName1" => $person1->getFullName(),
            "fullName2" => $person2->getFullName(),
            "birthdate1" => $person1->birthday,
            "birthdate2" => $person2->birthday,
            "zodiacSign1" => $person1->zodiac->zodiacSign,
            "zodiacSign2" => $person2->zodiac->zodiacSign,
            "symbol1" => $person1->zodiac->symbol,
            "symbol2" => $person2->zodiac->symbol,
            "zodiacCompatibility" => $zodiacCompatibility,
            "flamesResult" => $result
        ]);
    }

    
?>
