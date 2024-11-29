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

        // Make sure to use your exact folder path
        $success_url = "http://localhost:8000/QCU%20E-COMMERCE/handle-success.php";
        $failure_url = "http://localhost:8000/QCU%20E-COMMERCE/cart.php";

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paymongo.com/v1/links",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'data' => [
                    'attributes' => [
                        'amount' => $amount,
                        'description' => 'Test Payment for QCU-MERCHMART',
                        'currency' => 'PHP',
                        'success_url' => $success_url,
                        'cancel_url' => $failure_url
                    ]
                ]
            ]),
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic c2tfdGVzdF9idlVLbXU2enFmSmIxODNqaUw3WlVjSkU6",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $responseData = json_decode($response, true);
        
        if (isset($responseData['data']['attributes']['checkout_url'])) {
            echo json_encode([
                'success' => true,
                'checkout_url' => $responseData['data']['attributes']['checkout_url']
            ]);
        } else {
            throw new Exception('Failed to create payment link');
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