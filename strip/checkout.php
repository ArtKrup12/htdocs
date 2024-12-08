<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//include './connect.php';
session_start();

//if (!$_SESSION['google_id']) {
//    echo "<script>
//    window.location.href='https://glbencrypt.com/testlogin.php';
//    </script>";
//    exit;
//}

//ส่ง code country
//ส่ง package id

//function getUserCountry() {
//  $ip = $_SERVER['REMOTE_ADDR']; // ดึง IP Address ของผู้ใช้งาน
//
//  // ใช้ API ของ ipinfo.io
//  $apiUrl = "http://ipinfo.io/{$ip}/geo";
//  $response = file_get_contents($apiUrl);
//  $data = json_decode($response, true);
//
//  return $data['country'] ?? 'Unknown'; // ส่งรหัสประเทศ (เช่น 'TH')
//}

// เรียกใช้ฟังก์ชัน
//$country = getUserCountry();


$now = date('Y-m-d');
//if ($_POST['package_id'] == 1) {
//    $sqlSelect = "SELECT * FROM pk_list where pk_id = '1' and user_id = '" . $_SESSION['google_id'] . "' ";
//    $querySelect = mysqli_query($conn, $sqlSelect);
//    $check_package = mysqli_fetch_array($querySelect);
//    if(!empty($check_package['id'])){
//        echo "<script>
//        alert('ไม่สามารถซื้อแพ็คเกจได้ เนื่องจากคุณได้ซื้อแพ็คเกจนี้แล้ว');
//        window.location.href='index.php';
//        </script>";
//        exit;
//    }
//
//    $expire = date('Y-m-d', strtotime("$now +1 Months"));
//
//} else if ($_POST['package_id'] == 2 || $_POST['package_id'] == 3) {
//
//    $expire = date('Y-m-d', strtotime("$now +1 Years"));
//}

$country = 'TH' ;
$package_id = 3 ;
if ($package_id == 1) {

//    $sqlInsert = "INSERT INTO pk_list (pk_id,user_id,expire_date,start_date)
//    VALUES ('" . $_POST['package_id'] . "','" . $_SESSION['google_id'] . "','" . $expire . "','" . $now . "'
//    )";
//    $queryInsert = mysqli_query($conn, $sqlInsert);

    echo "<script>
    alert('ได้ทำการสั่งซื้อเรียบร้อยแล้ว');
//    window.location.href='index.php';
    </script>";
} else {
    require __DIR__ . "/vendor/autoload.php";
    $stripe_secret_key = "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";
    \Stripe\Stripe::setApiKey($stripe_secret_key);
    if($country == 'TH'){
      if ($package_id == 2) {
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "https://glbencrypt.com/success.php?package_id=2",
            "cancel_url" => "https://glbencrypt.com/index.php",
            "locale" => ($country == 'TH' ? "th": "auto"),
            'payment_method_types' => ['promptpay'],
            'line_items' => [[
                'price_data' => [
                  'currency' => 'thb',
                  'product_data' => [
                    'name' => 'Starter Package',
                  ],

                  'unit_amount' => 17235,
                ],
                'quantity' => 1,
              ]],
            
        ]);
    } else {
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "https://glbencrypt.com/success.php?package_id=3",
            "cancel_url" => "https://glbencrypt.com/index.php",
            "locale" => ($country == 'TH' ? "th": "auto"),
            'payment_method_types' => ['promptpay'],
            'line_items' => [[
                'price_data' => [
                  'currency' => 'thb',
                  'product_data' => [
                    'name' => 'Professinal Package',
                  ],
                  'unit_amount' => 31023,
                ],
                'quantity' => 1,
              ]],
        ]);
    }
    }else{
      if ($package_id == 2) {
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "https://glbencrypt.com/success.php?package_id=2",
            "cancel_url" => "https://glbencrypt.com/index.php",
            "locale" => ($country == 'TH' ? "th": "auto"),
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                    'name' => 'Starter Package',
                  ],
                  'unit_amount' => 500,
                ],
                'quantity' => 1,
              ]],
            
        ]);
    } else {
        $checkout_session = \Stripe\Checkout\Session::create([
            "mode" => "payment",
            "success_url" => "https://glbencrypt.com/success.php?package_id=3",
            "cancel_url" => "https://glbencrypt.com/index.php",
            "locale" => ($country == 'TH' ? "th": "auto"),
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                    'name' => 'Professinal Package',
                  ],
                  'unit_amount' => 900,
                ],
                'quantity' => 1,
              ]],
        ]);
    }
    }

    header('Location:' . $checkout_session->url);
}
?>