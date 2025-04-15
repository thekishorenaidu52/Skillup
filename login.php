<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        }
    }
    $error = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login - SkillUp</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <form method="POST" class="bg-white p-8 rounded-lg shadow-md w-96 space-y-4">
    <h2 class="text-2xl font-bold text-center text-blue-600">Login</h2>
    <?php if (!empty($error)) echo "<p class='text-red-500'>$error</p>"; ?>
    <input type="email" name="email" placeholder="Email" required class="w-full p-3 border rounded">
    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded">
    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700">Login</button>
    <p class="text-center text-sm">Don't have an account? <a href="signup.php" class="text-blue-600 hover:underline">Sign Up</a></p>
  </form>
</body>
</html>
