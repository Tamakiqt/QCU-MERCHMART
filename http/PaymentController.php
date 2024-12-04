<?php
session_start();
require_once '../server/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['amount']) || !is_numeric($data['amount'])) {
        echo json_encode(['error' => 'Invalid amount provided']);
        exit;
    }

    $amount = intval($data['amount']); // Ensure it's an integer

    try {
        $curl = curl_init();
        $_SESSION['pending_payment'] = true;

       // Redirect to the main page after payment success
        $success_url = "http://localhost:8000/client-index.php?status=success";

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
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Basic " . base64_encode('sk_test_bvUKmu6zqfJb183jiL7ZUcJE'),
                "content-type: application/json"
            ],
            CURLOPT_POSTFIELDS => $payload
        ]);

        $response = curl_exec($curl);
        if ($error = curl_error($curl)) {
            throw new Exception("Curl error: $error");
        }

        $responseData = json_decode($response, true);

        if (isset($responseData['data']['attributes']['checkout_url'])) {
            echo json_encode([
                'success' => true,
                'checkout_url' => $responseData['data']['attributes']['checkout_url']
            ]);
        } else {
            throw new Exception('Failed to initiate payment.');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    } finally {
        curl_close($curl);
    }
}
?>
