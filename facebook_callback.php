<?php
include 'db.php';
session_start();

$facebook_app_id = 'YOUR_FACEBOOK_APP_ID';
$facebook_app_secret = 'YOUR_FACEBOOK_APP_SECRET';
$facebook_redirect_uri = 'http://localhost/project/facebook_callback.php';

if (isset($_GET['code'])) {
    // Get the authorization code
    $code = $_GET['code'];

    // Exchange the code for an access token
    $token_url = 'https://graph.facebook.com/v12.0/oauth/access_token';
    $token_data = [
        'client_id' => $facebook_app_id,
        'client_secret' => $facebook_app_secret,
        'redirect_uri' => $facebook_redirect_uri,
        'code' => $code
    ];

    $ch = curl_init($token_url . '?' . http_build_query($token_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $token_response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($token_response, true);

    if (isset($token_data['access_token'])) {
        // Get user info using the access token
        $user_info_url = 'https://graph.facebook.com/me?fields=id,name,email';
        $ch = curl_init($user_info_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token_data['access_token']
        ]);
        $user_info_response = curl_exec($ch);
        curl_close($ch);

        $user_info = json_decode($user_info_response, true);

        if (isset($user_info['email'])) {
            // Check if user exists in database
            $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ?");
            $stmt->bind_param("s", $user_info['email']);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 0) {
                // Create new user
                $username = explode('@', $user_info['email'])[0];
                $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                $password = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
                $stmt->bind_param("sss", $username, $user_info['email'], $password);
                $stmt->execute();
                $user_id = $conn->insert_id;
            } else {
                $stmt->bind_result($user_id, $username);
                $stmt->fetch();
            }

            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $user_info['email'];

            // Redirect to home page
            header("Location: index.php");
            exit;
        }
    }
}

// If something went wrong, redirect back to login
header("Location: login.php");
exit;
?> 