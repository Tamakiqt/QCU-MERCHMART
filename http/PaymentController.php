<?php
session_start();
require_once '../server/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['amount']) || !is_numeric($data['amount'])) {
        echo json_encode(['error' => 'Invalid amount provided']);
        exit;
    }

    $amount = intval($data['amount']);
    
    try {
        $curl = curl_init();
        
        // Store payment info in session
        $_SESSION['pending_payment'] = true;

        // Make sure these URLs match your actual domain/path
        $success_url = "http://localhost:8000/checkout-success.php";
        $failure_url = "http://localhost:8000/checkout-failed.php";

        $payload = json_encode([
            "data" => [
                "attributes" => [
                    "amount" => $amount,
                    "description" => "Payment for order",
                    "currency" => "PHP",
                    "success_url" => $success_url,
                    "failure_url" => $failure_url
                ]
            ]
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paymongo.com/v1/links",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic " . base64_encode('sk_test_bvUKmu6zqfJb183jiL7ZUcJE'),
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        if ($err) {
            throw new Exception('Curl Error: ' . $err);
        }

        $responseData = json_decode($response, true);
        
        if (isset($responseData['data']['attributes']['checkout_url'])) {
            echo json_encode([
                'success' => true,
                'checkout_url' => $responseData['data']['attributes']['checkout_url']
            ]);
        } else {
            error_log('PayMongo Response: ' . print_r($responseData, true));
            throw new Exception('Failed to create payment link: ' . ($responseData['errors'][0]['detail'] ?? 'Unknown error'));
        }

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    } finally {
        if (isset($curl)) {
            curl_close($curl);
        }
    }
}
?>