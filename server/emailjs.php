<?php
function send_email_using_emailjs($to, $subject, $body) {
    $public_key = "urk05-DC39haP5pMg";  
    $service_id = "service_ix6fx3v";  
    $template_id = "template_9m356og";  

    
    $params = array(
        'to_email' => $to,
        'subject' => $subject,
        'body' => $body
    );

    
    $url = "https://api.emailjs.com/api/v1.0/email/send";
    $data = array(
        "service_id" => $service_id,
        "template_id" => $template_id,
        "user_id" => $public_key,
        "template_params" => $params
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json"
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
      
        echo "Email sent successfully: $response";
        return true;
    } else {
    
        echo "Error: Unable to send email";
        return false;
    }
}
?>


