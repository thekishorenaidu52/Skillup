<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $username = htmlspecialchars(trim($_POST['username']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Signup failed. Try again.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign Up - SkillUp</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0px); }
    }
    @keyframes gradient {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .gradient-text {
      background: linear-gradient(135deg, #2563eb, #4f46e5);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .animate-float {
      animation: float 3s ease-in-out infinite;
    }
    .input-focus {
      transition: all 0.3s ease;
    }
    .input-focus:focus {
      transform: translateY(-2px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .glass-effect {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .gradient-bg {
      background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
    }
    .logo-container {
      position: relative;
      width: 60px;
      height: 60px;
    }
    .logo-circle {
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 50%;
      border: 3px solid transparent;
      border-top-color: #2563eb;
      border-right-color: #4f46e5;
      animation: rotate 3s linear infinite;
    }
    .logo-inner {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 80%;
      height: 80%;
      background: linear-gradient(135deg, #2563eb, #4f46e5);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .logo-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 gradient-bg">
  <!-- Particles.js Background -->
  <div id="particles-js"></div>
  <div class="w-full max-w-6xl flex items-center justify-center">
    <!-- Left Side - Logo and Branding -->
    <div class="w-1/2 pr-8 animate__animated animate__fadeInLeft">
      <div class="flex items-center space-x-4 mb-6">
        <div class="logo-container">
          <div class="logo-circle"></div>
          <div class="logo-inner">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="SkillUp Logo" class="logo-image">
          </div>
        </div>
        <h1 class="text-4xl font-bold gradient-text">SkillUp</h1>
      </div>
      <h2 class="text-3xl font-bold text-white mb-4">Join SkillUp Today!</h2>
      <p class="text-white text-lg mb-8">Create your account and start your learning journey with us.</p>
      <div class="space-y-4">
        <div class="flex items-center space-x-3 text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Access to premium courses</span>
        </div>
        <div class="flex items-center space-x-3 text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Track your progress</span>
        </div>
        <div class="flex items-center space-x-3 text-white">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
          </svg>
          <span>Get certified</span>
        </div>
      </div>
    </div>
    <!-- Right Side - Signup Form -->
    <div class="w-1/2">
      <form method="POST" class="glass-effect p-8 rounded-2xl shadow-2xl space-y-6 animate__animated animate__fadeInRight">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Create Account</h2>
        <?php if (!empty($error)) echo "<div class='bg-red-50 border-l-4 border-red-500 p-4 rounded animate__animated animate__shakeX'><p class='text-red-700'>$error</p></div>"; ?>
        <div class="space-y-4">
          <div class="transform transition-all duration-300 hover:scale-[1.02]">
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
            <input type="text" name="username" id="username" placeholder="Username" required class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
          </div>
          <div class="transform transition-all duration-300 hover:scale-[1.02]">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" placeholder="Email" required class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
          </div>
          <div class="transform transition-all duration-300 hover:scale-[1.02]">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input type="password" name="password" id="password" placeholder="Password (min 6 chars)" required class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300">
          </div>
        </div>
        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold p-3 rounded-lg transition-all duration-300 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-[1.02] animate__animated animate__pulse animate__infinite">Sign Up</button>
        <p class="text-center text-sm text-gray-600">Already have an account? <a href="login.php" class="text-blue-600 hover:underline hover:text-blue-800 transition duration-300">Login</a></p>
      </form>
    </div>
  </div>
  <script>
    // Optionally, you can add particles.js config here for background effect
    particlesJS.load('particles-js', 'particles.json', function() {
      // callback
    });
  </script>
</body>
</html>
