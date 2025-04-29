<?php
include 'db.php';
session_start();
$error = "";

// Check for OAuth errors
if (isset($_SESSION['oauth_error'])) {
    $error = $_SESSION['oauth_error'];
    unset($_SESSION['oauth_error']);
}

// Google OAuth Configuration
$google_client_id = 'YOUR_GOOGLE_CLIENT_ID';
$google_client_secret = 'YOUR_GOOGLE_CLIENT_SECRET';
$google_redirect_uri = 'http://localhost/project/google_callback.php';

// Facebook OAuth Configuration
$facebook_app_id = 'YOUR_FACEBOOK_APP_ID';
$facebook_app_secret = 'YOUR_FACEBOOK_APP_SECRET';
$facebook_redirect_uri = 'http://localhost/project/facebook_callback.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (empty($password)) {
        $error = "Password cannot be empty.";
    } else {
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
                $_SESSION['email'] = $email;
                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "No user found with this email.";
        }
        $stmt->close();
    }
}

// Generate Google OAuth URL
$google_auth_url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    'client_id' => $google_client_id,
    'redirect_uri' => $google_redirect_uri,
    'response_type' => 'code',
    'scope' => 'email profile',
    'access_type' => 'online',
    'prompt' => 'select_account'
]);

// Generate Facebook OAuth URL
$facebook_auth_url = "https://www.facebook.com/v12.0/dialog/oauth?" . http_build_query([
    'client_id' => $facebook_app_id,
    'redirect_uri' => $facebook_redirect_uri,
    'state' => bin2hex(random_bytes(16)),
    'scope' => 'email,public_profile'
]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login - SkillUp</title>
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
    .loading {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.9);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }
    .loading.active {
      display: flex;
    }
    .spinner {
      width: 40px;
      height: 40px;
      border: 4px solid #f3f3f3;
      border-top: 4px solid #3498db;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    #particles-js {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
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

  <!-- Loading Animation -->
  <div class="loading" id="loading">
    <div class="spinner"></div>
  </div>

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
      <h2 class="text-3xl font-bold text-white mb-4">Welcome Back!</h2>
      <p class="text-white text-lg mb-8">Access your account and continue your learning journey.</p>

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

    <!-- Right Side - Login Form -->
    <div class="w-1/2">
      <form method="POST" 
            class="glass-effect p-8 rounded-2xl shadow-2xl space-y-6 animate__animated animate__fadeInRight"
            onsubmit="showLoading()"
      >
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login to Your Account</h2>
        
        <?php if (!empty($error)): ?>
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded animate__animated animate__shakeX">
            <p class="text-red-700"><?php echo htmlspecialchars($error); ?></p>
          </div>
        <?php endif; ?>

        <div class="space-y-4">
          <div class="transform transition-all duration-300 hover:scale-[1.02]">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
            <input 
              type="email" 
              id="email"
              name="email" 
              placeholder="Enter your email" 
              required 
              class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
            >
          </div>
          
          <div class="transform transition-all duration-300 hover:scale-[1.02]">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input 
              type="password" 
              id="password"
              name="password" 
              placeholder="Enter your password" 
              required 
              class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-300"
            >
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input type="checkbox" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
            <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
          </div>
          <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition duration-300">Forgot password?</a>
        </div>

        <button 
          type="submit" 
          class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold p-3 rounded-lg transition-all duration-300 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-[1.02] animate__animated animate__pulse animate__infinite"
        >
          Sign In
        </button>

        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Or continue with</span>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <a href="<?php echo htmlspecialchars($google_auth_url); ?>" 
             class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300 transform hover:scale-[1.02]">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5 mr-2">
            Google
          </a>
          <a href="<?php echo htmlspecialchars($facebook_auth_url); ?>" 
             class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-300 transform hover:scale-[1.02]">
            <img src="https://www.svgrepo.com/show/475647/facebook-color.svg" alt="Facebook" class="w-5 h-5 mr-2">
            Facebook
          </a>
        </div>

        <p class="text-center text-sm text-gray-600">
          Don't have an account? 
          <a href="signup.php" class="text-blue-600 hover:text-blue-800 font-medium transition duration-300">Create an account</a>
        </p>
      </form>
    </div>
  </div>

  <script>
    function showLoading() {
      document.getElementById('loading').classList.add('active');
    }

    // Initialize particles.js
    particlesJS('particles-js', {
      particles: {
        number: {
          value: 80,
          density: {
            enable: true,
            value_area: 800
          }
        },
        color: {
          value: '#ffffff'
        },
        shape: {
          type: 'circle'
        },
        opacity: {
          value: 0.5,
          random: false
        },
        size: {
          value: 3,
          random: true
        },
        line_linked: {
          enable: true,
          distance: 150,
          color: '#ffffff',
          opacity: 0.4,
          width: 1
        },
        move: {
          enable: true,
          speed: 2,
          direction: 'none',
          random: false,
          straight: false,
          out_mode: 'out',
          bounce: false
        }
      },
      interactivity: {
        detect_on: 'canvas',
        events: {
          onhover: {
            enable: true,
            mode: 'repulse'
          },
          onclick: {
            enable: true,
            mode: 'push'
          },
          resize: true
        }
      },
      retina_detect: true
    });
  </script>
</body>
</html>
