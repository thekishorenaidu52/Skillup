<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillUp - Learn & Get Certified</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link src="stylesheet" href="./output.css"></link>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script> 
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet"> <!-- Google Fonts -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }

  </style>
  <script>
    AOS.init();
  </script>
</head>

<body class="bg-gray-50">

  
  <?php session_start(); ?>
<header class="bg-white shadow-md p-6 flex justify-between items-center sticky top-0 z-50">
  <h1 class="text-3xl font-bold text-blue-600">SkillUp</h1>
  <div class="flex items-center space-x-6">
    <input type="text" placeholder="Search courses..." class="px-4 py-2 border rounded-full focus:outline-none focus:ring w-64" />
    
    <?php if (isset($_SESSION['username'])): ?>
      <span class="text-blue-600 font-semibold">Hi, <?= $_SESSION['username'] ?></span>
      <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
    <?php else: ?>
      <a href="login.php" class="text-blue-600 hover:underline">Login</a>
      <a href="signup.php" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">Sign Up</a>
    <?php endif; ?>
  </div>
</header>


  
  <section class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-28 px-6 text-center">
    <h2 class="text-5xl font-extrabold mb-4 animate__animated animate__fadeInUp">Upgrade Your Skills & Get Certified</h2>
    <p class="text-xl mb-6 animate__animated animate__fadeInUp animate__delay-1s">Join thousands of learners worldwide. Access high-quality courses and earn valuable certifications.</p>
    <a href="#courses" class="bg-white text-blue-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-200 transition">Explore Courses</a>
  </section>

  
  <section id="courses" class="py-16 px-6 max-w-7xl mx-auto">
    <h3 class="text-3xl font-bold text-center mb-10">Popular Courses</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
      
      <div class="flex  rounded-lg shadow-xl transform transition hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
        <div class=" p-2 w-full">
        <h4 class="text-xl font-semibold mb-2">Web Development</h4>
        <p class="mb-4">Learn to build websites using HTML, CSS, JavaScript, and React.</p>
        <a href="enroled.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enroll</a>
        </div>
        <div class="bg-blue-200 w-full"><img class="w-full h-full" src="src/1.png" alt=""></div>
      </div>

      
      
      <div class="flex  rounded-lg shadow-xl transform transition hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
        <div class=" p-2 w-full">
        <h4 class="text-xl font-semibold mb-2">Data Science</h4>
        <p class="mb-4">the process of extracting meaningful and knowledge from data using scientific methods</p>
        <a href="enroled.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enroll</a>
        </div>
        <div class="bg-blue-200 w-full object-cover"><img class="w-full h-70" src="src/2 (2).png" alt=""></div>
      </div>



      <div class="flex  rounded-lg shadow-xl transform transition hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
        <div class=" p-2 w-full">
        <h4 class="text-xl font-semibold mb-2">UI/UX</h4>
        <p class="mb-4">Learn how to design stunning interfaces with Figma and Adobe XD.</p>
        <a href="enroled.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enroll</a>
        </div>
        <div class="bg-blue-200 w-full object-cover"><img class="w-full h-full" src="src/3.jpg" alt=""></div>
      </div>
      

      <div class="flex  rounded-lg shadow-xl transform transition hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
        <div class=" p-2 w-full">
        <h4 class="text-xl font-semibold mb-2">Digital Marketing</h4>
        <p class="mb-4">Become an expert in SEO, social media marketing, and Google Ads.</p>
        <a href="enroled.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enroll</a>
        </div>
        <div class="bg-blue-200 w-full object-cover"><img class="w-full h-full" src="src/4.jpg" alt=""></div>
      </div>

      <div class="flex  rounded-lg shadow-xl transform transition hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
        <div class=" p-2 w-full">
        <h4 class="text-xl font-semibold mb-2">Photography</h4>
        <p class="mb-4">Learn the art of photography, editing, and camera techniques.</p>
        <a href="enroled.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enroll</a>
        </div>
        <div class="bg-blue-200 w-full object-cover"><img class="w-full h-full" src="src/5.jpg" alt=""></div>
      </div>

      <div class="flex  rounded-lg shadow-xl transform transition hover:scale-105 hover:shadow-2xl" data-aos="fade-up">
        <div class=" p-2 w-full">
          <h4 class="text-xl font-semibold mb-2">Mobile App Development</h4>
          <p class="mb-4">Learn to build mobile apps using Swift, Java, and Flutter.</p>
        
        <a href="enroled.html" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Enroll</a>
        </div>
        <div class="bg-blue-200 w-full object-cover"><img class="w-full h-full" src="src/6.webp" alt=""></div>
      </div>

  </section>

  <!-- Certifications Section -->
  <section id="certifications" class="bg-blue-600 text-white py-16 px-6">
    <h3 class="text-3xl font-bold text-center mb-10">Get Certified & Advance Your Career</h3>
    <div class="max-w-4xl mx-auto text-center">
      <p class="text-xl mb-6">Our certification programs are designed to help you stand out. After completing a course, take an online exam and receive your certification.</p>
      <a href="Explore Certifications.html" class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-200 transition">Explore Certifications</a>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-white text-center py-6 mt-16 border-t">
    <p class="text-gray-600">&copy; 2025 SkillUp. All rights reserved.</p>
  </footer>

</body>
</html>
