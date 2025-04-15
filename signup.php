<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Signup failed. Try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up - SkillUp</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <form method="POST" class="bg-white p-8 rounded-lg shadow-md w-96 space-y-4">
    <h2 class="text-2xl font-bold text-center text-blue-600">Create Account</h2>
    <?php if (!empty($error)) echo "<p class='text-red-500'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Username" required class="w-full p-3 border rounded">
    <input type="email" name="email" placeholder="Email" required class="w-full p-3 border rounded">
    <input type="password" name="password" placeholder="Password" required class="w-full p-3 border rounded">
    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded hover:bg-blue-700">Sign Up</button>
    <p class="text-center text-sm">Already have an account? <a href="login.php" class="text-blue-600 hover:underline">Login</a></p>
  </form>
</body>
</html>
