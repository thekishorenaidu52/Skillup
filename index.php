<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkillUp Learning Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    html {
      overflow-x: hidden;
    }
    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      background-color: #f9fafb;
      overflow-x: hidden;
    }
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0; width: 100vw; height: 100vh;
      background: url('https://www.toptal.com/designers/subtlepatterns/patterns/symphony.png');
      opacity: 0.08;
      pointer-events: none;
      z-index: 0;
    }
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    .gradient-text {
      background: linear-gradient(90deg, #2563eb, #e11d48, #f59e42, #4f46e5);
      background-size: 200% 200%;
      animation: gradientText 8s ease-in-out infinite;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      color: transparent;
    }
    @keyframes gradientText {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    .glass {
      background: rgba(255,255,255,0.8);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.10);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: 20px;
      border: 1px solid rgba(255,255,255,0.12);
    }
    .pulse {
      animation: pulseBtn 2s infinite;
    }
    @keyframes pulseBtn {
      0% { box-shadow: 0 0 0 0 rgba(59,130,246,0.18); }
      70% { box-shadow: 0 0 0 12px rgba(59,130,246,0); }
      100% { box-shadow: 0 0 0 0 rgba(59,130,246,0); }
    }
    .hero-bg, .bg-blob, .bg-float {
      position: absolute;
      z-index: 0;
      pointer-events: none;
    }
    .hero-bg {
      top: 0; left: 0; width: 100%; height: 100%;
      opacity: 0.22;
    }
    .bg-blob {
      top: -120px; left: -120px; width: 480px; height: 480px;
      opacity: 0.22;
      filter: blur(2px);
      animation: blobMove 16s ease-in-out infinite alternate;
    }
    .bg-float {
      right: -100px; bottom: -100px; width: 340px; height: 340px;
      opacity: 0.16;
      filter: blur(1.5px);
      animation: floatMove 18s ease-in-out infinite alternate;
    }
    @keyframes blobMove {
      0% { transform: scale(1) translateY(0); }
      50% { transform: scale(1.08) translateY(40px); }
      100% { transform: scale(1) translateY(0); }
    }
    @keyframes floatMove {
      0% { transform: scale(1) translateY(0); }
      50% { transform: scale(1.12) translateY(-30px); }
      100% { transform: scale(1) translateY(0); }
    }
    .hero-content {
      position: relative;
      z-index: 1;
    }
    .course-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .course-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body class="min-h-screen flex flex-col">
  <!-- SVG Blobs and Floating Shapes -->
  <svg class="bg-blob" viewBox="0 0 600 600"><g transform="translate(300,300)"><path d="M120,-153.2C153.2,-120,170.7,-60,168.2,-4.2C165.7,51.7,143.2,103.3,110,136.7C76.7,170,32.8,185,0.2,184.9C-32.3,184.7,-64.7,169.3,-99.2,145.9C-133.7,122.5,-170.3,91.1,-181.2,51.7C-192.1,12.3,-177.3,-35.1,-151.2,-74.2C-125.1,-113.3,-87.7,-144.1,-44.2,-163.2C-0.7,-182.3,48.8,-189.7,97.2,-172.2C145.7,-154.7,194.2,-112.3,120,-153.2Z" fill="#fbc2eb"/></g></svg>
  <svg class="bg-float" viewBox="0 0 600 600"><g transform="translate(300,300)"><path d="M120,-153.2C153.2,-120,170.7,-60,168.2,-4.2C165.7,51.7,143.2,103.3,110,136.7C76.7,170,32.8,185,0.2,184.9C-32.3,184.7,-64.7,169.3,-99.2,145.9C-133.7,122.5,-170.3,91.1,-181.2,51.7C-192.1,12.3,-177.3,-35.1,-151.2,-74.2C-125.1,-113.3,-87.7,-144.1,-44.2,-163.2C-0.7,-182.3,48.8,-189.7,97.2,-172.2C145.7,-154.7,194.2,-112.3,120,-153.2Z" fill="#a1c4fd"/></g></svg>

  <header class="bg-white/80 shadow-md py-1.5 px-4 flex justify-between items-center sticky top-0 z-50 animate__animated animate__fadeInDown">
    <h1 class="text-3xl font-extrabold gradient-text tracking-tight">SkillUp</h1>
    <div class="flex items-center space-x-5">
      <?php if (isset($_SESSION['username'])): ?>
        <?php 
          $username = $_SESSION['username'];
          $initials = strtoupper(substr($username, 0, 1));
          if (strpos($username, ' ') !== false) {
            $parts = explode(' ', $username);
            $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
          }
        ?>
        <button id="profileBtn" class="ml-2 focus:outline-none relative">
          <span class="w-14 h-14 flex items-center justify-center rounded-full bg-black text-white font-bold text-2xl border-2 border-white shadow-md">
            <?= $initials ?>
          </span>
        </button>
        <a href="logout.php" class="text-red-600 hover:underline">Logout</a>
      <?php else: ?>
        <a href="login.php" class="text-blue-600 hover:underline">Login</a>
        <a href="signup.php" class="bg-gradient-to-r from-blue-600 to-indigo-500 text-white px-6 py-2 rounded-full hover:from-blue-700 hover:to-indigo-600 transition font-semibold shadow pulse">Sign Up</a>
      <?php endif; ?>
    </div>
  </header>

  <section class="flex-1 flex flex-col justify-center items-center relative overflow-hidden py-28 px-6 text-center animate__animated animate__fadeIn bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Animated SVG background -->
    <svg class="hero-bg" viewBox="0 0 1440 320"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="0%"><stop offset="0%" style="stop-color:#a1c4fd;stop-opacity:1" /><stop offset="100%" style="stop-color:#fbc2eb;stop-opacity:1" /></linearGradient></defs><path fill="url(#grad1)" fill-opacity=".5" d="M0,160L60,170.7C120,181,240,203,360,197.3C480,192,600,160,720,133.3C840,107,960,85,1080,101.3C1200,117,1320,171,1380,197.3L1440,224L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"></path></svg>
    <div class="hero-content max-w-3xl mx-auto">
      <h2 class="text-5xl md:text-6xl font-extrabold mb-4 gradient-text animate__animated animate__fadeInUp">Upgrade Your Skills & Get Certified</h2>
      <p class="text-xl mb-6 animate__animated animate__fadeInUp animate__delay-1s text-gray-700">Join thousands of learners worldwide. Access high-quality courses and earn valuable certifications.</p>
      <div class="flex flex-wrap justify-center gap-4 mb-8 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="flex items-center bg-white/80 rounded-full px-5 py-2 shadow text-blue-700 font-semibold text-base gap-2"><span class="text-xl">⏳</span> Learn at your own pace</div>
        <div class="flex items-center bg-white/80 rounded-full px-5 py-2 shadow text-pink-700 font-semibold text-base gap-2"><span class="text-xl">🎓</span> Expert instructors</div>
        <div class="flex items-center bg-white/80 rounded-full px-5 py-2 shadow text-indigo-700 font-semibold text-base gap-2"><span class="text-xl">💼</span> Career-boosting certifications</div>
        <div class="flex items-center bg-white/80 rounded-full px-5 py-2 shadow text-green-700 font-semibold text-base gap-2"><span class="text-xl">📱</span> Flexible learning</div>
      </div>
      <button id="exploreBtn" class="bg-gradient-to-r from-blue-600 to-indigo-500 text-white px-8 py-3 rounded-full font-semibold hover:from-blue-700 hover:to-indigo-600 transition shadow-lg pulse text-lg tracking-wide animate__animated animate__bounceIn">Explore Courses</button>
    </div>
  </section>

  <section id="courses" class="py-16 px-6 max-w-7xl mx-auto hidden opacity-0 animate__animated" style="pointer-events:none;">
    <h3 class="text-4xl font-extrabold text-center mb-12 gradient-text animate__animated animate__fadeInDown">Popular Courses</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
      <div class="course-card bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Data Science</h2>
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">Popular</span>
          </div>
          <p class="text-gray-600 mb-6">Master data analysis, machine learning, and statistical modeling.</p>
          <div class="space-y-2">
            <div class="flex items-center text-sm text-gray-500">
              <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
              </svg>
              12 weeks
            </div>
            <div class="flex items-center text-sm text-gray-500">
              <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
              </svg>
              1,234 enrolled
            </div>
          </div>
          <div class="mt-6">
            <a href="reading-material.html" class="block text-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
              Start Learning
            </a>
          </div>
        </div>
      </div>
      <div class="course-card bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Full Stack Development</h2>
            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">New</span>
          </div>
          <p class="text-gray-600 mb-6">Learn frontend, backend, and DevOps technologies.</p>
          <div class="space-y-2">
            <div class="flex items-center text-sm text-gray-500">
              <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
              </svg>
              16 weeks
            </div>
            <div class="flex items-center text-sm text-gray-500">
              <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
              </svg>
              987 enrolled
            </div>
          </div>
          <div class="mt-6">
            <a href="fullstack-reading.html" class="block text-center bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors">
              Start Learning
            </a>
          </div>
        </div>
      </div>
      <div class="course-card bg-white rounded-xl shadow-md overflow-hidden opacity-75">
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Cloud Computing</h2>
            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">Coming Soon</span>
          </div>
          <p class="text-gray-600 mb-6">Master cloud platforms, services, and infrastructure.</p>
          <div class="space-y-2">
            <div class="flex items-center text-sm text-gray-500">
              <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"/>
              </svg>
              14 weeks
            </div>
            <div class="flex items-center text-sm text-gray-500">
              <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
              </svg>
              Join waitlist
            </div>
          </div>
          <div class="mt-6">
            <button disabled class="block w-full text-center bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
              Coming Soon
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-white/80 text-center py-6 mt-16 border-t animate__animated animate__fadeInUp">
    <p class="text-gray-600">&copy; 2025 SkillUp. All rights reserved.</p>
  </footer>

  <!-- Profile Dropdown/Modal -->
  <div id="profileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl relative flex animate__animated animate__fadeInDown">
      <button id="closeProfileModal" class="absolute top-3 right-3 text-gray-400 hover:text-red-500 text-2xl font-bold">&times;</button>
      <!-- Sidebar -->
      <div class="w-1/3 bg-gray-100 rounded-l-2xl flex flex-col items-center py-10 px-4 border-r">
        <span id="sidebarAvatar" class="w-24 h-24 flex items-center justify-center rounded-full bg-black text-white font-bold text-3xl mb-4 border-4 border-white shadow-md overflow-hidden">
          <?= $initials ?>
        </span>
        <h2 class="text-lg font-bold text-center mb-1" id="profileNameSidebar"></h2>
        <p class="text-gray-500 text-center text-sm mb-4" id="profileEmailSidebar"></p>
        <ul class="w-full space-y-2 text-center">
          <li><button class="w-full py-2 rounded bg-gray-200 font-semibold">Profile</button></li>
          <li><button class="w-full py-2 rounded hover:bg-gray-200">Photo</button></li>
          <li><button class="w-full py-2 rounded hover:bg-gray-200">Account Security</button></li>
          <li><button class="w-full py-2 rounded hover:bg-gray-200">Privacy</button></li>
          <li><button class="w-full py-2 rounded hover:bg-gray-200">Notification Preferences</button></li>
          <li><button class="w-full py-2 rounded hover:bg-gray-200">Close account</button></li>
        </ul>
        <div class="mt-8 w-full">
          <h4 class="text-md font-semibold mb-2 text-center">Enrolled Courses</h4>
          <ul id="enrolledCoursesList" class="text-gray-700 text-center text-sm"></ul>
        </div>
      </div>
      <!-- Main Profile Area -->
      <div class="w-2/3 p-10 flex flex-col justify-center">
        <div id="profileSections">
          <div id="profileSectionProfile">
            <h2 class="text-2xl font-bold mb-6">Public profile</h2>
            <form id="profileForm" class="space-y-4">
              <div>
                <label class="block font-semibold mb-1">Name</label>
                <input id="profileName" type="text" class="w-full border rounded px-4 py-2" maxlength="40" />
              </div>
              <div>
                <label class="block font-semibold mb-1">Email</label>
                <input id="profileEmail" type="email" class="w-full border rounded px-4 py-2" maxlength="60" />
              </div>
              <div>
                <label class="block font-semibold mb-1">Headline</label>
                <input id="profileHeadline" type="text" class="w-full border rounded px-4 py-2" maxlength="60" />
              </div>
              <div>
                <label class="block font-semibold mb-1">Bio</label>
                <textarea id="profileBio" class="w-full border rounded px-4 py-2" rows="3" maxlength="200"></textarea>
              </div>
              <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded font-semibold hover:bg-blue-700">Save</button>
            </form>
          </div>
          <div id="profileSectionPhoto" class="hidden">
            <h2 class="text-2xl font-bold mb-6">Profile Photo</h2>
            <div class="flex flex-col items-center space-y-4">
              <img id="profilePhotoPreview" src="" alt="Profile Photo" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md bg-gray-200" />
              <input type="file" id="profilePhotoInput" accept="image/*" class="block" />
              <button id="removePhotoBtn" class="text-red-600 hover:underline">Remove Photo</button>
            </div>
          </div>
          <div id="profileSectionAccount" class="hidden"><h2 class="text-2xl font-bold mb-6">Account Security</h2><p>Change your password and secure your account (coming soon).</p></div>
          <div id="profileSectionPrivacy" class="hidden"><h2 class="text-2xl font-bold mb-6">Privacy</h2><p>Manage your privacy settings (coming soon).</p></div>
          <div id="profileSectionNotifications" class="hidden"><h2 class="text-2xl font-bold mb-6">Notification Preferences</h2><p>Set your notification preferences (coming soon).</p></div>
          <div id="profileSectionClose" class="hidden"><h2 class="text-2xl font-bold mb-6">Close Account</h2><p>To close your account, please contact support.</p></div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const exploreBtn = document.getElementById('exploreBtn');
    exploreBtn.addEventListener('click', () => {
      window.open('courses.html', '_blank');
    });
    // Always sync localStorage with PHP session user on page load
    <?php if (isset($_SESSION['username'])): ?>
    localStorage.setItem('userName', <?= json_encode($_SESSION['username']) ?>);
    <?php endif; ?>
    <?php if (isset($_SESSION['email'])): ?>
    localStorage.setItem('userEmail', <?= json_encode($_SESSION['email']) ?>);
    <?php endif; ?>
    <?php if (isset($_SESSION['phone'])): ?>
    localStorage.setItem('userPhone', <?= json_encode($_SESSION['phone']) ?>);
    <?php endif; ?>
    // Migrate selectedCourse to enrolledCourses if needed
    (function migrateSelectedCourse() {
      const selectedCourse = localStorage.getItem('selectedCourse');
      if (selectedCourse) {
        let enrolledCourses = JSON.parse(localStorage.getItem('enrolledCourses') || '[]');
        if (!enrolledCourses.includes(selectedCourse)) {
          enrolledCourses.push(selectedCourse);
          localStorage.setItem('enrolledCourses', JSON.stringify(enrolledCourses));
        }
      }
    })();
    // Profile modal logic
    const profileBtn = document.getElementById('profileBtn');
    const profileModal = document.getElementById('profileModal');
    const closeProfileModal = document.getElementById('closeProfileModal');
    if (profileBtn && profileModal && closeProfileModal) {
      profileBtn.addEventListener('click', () => {
        profileModal.classList.remove('hidden');
        // Show enrolled courses from localStorage
        const enrolledCoursesList = document.getElementById('enrolledCoursesList');
        if (enrolledCoursesList) {
          enrolledCoursesList.innerHTML = '';
          let enrolledCourses = JSON.parse(localStorage.getItem('enrolledCourses') || '[]');
          if (enrolledCourses.length > 0) {
            enrolledCourses.forEach(course => {
              const li = document.createElement('li');
              li.textContent = course;
              enrolledCoursesList.appendChild(li);
            });
          } else {
            const li = document.createElement('li');
            li.textContent = 'No courses enrolled yet.';
            enrolledCoursesList.appendChild(li);
          }
        }
        // Load profile info from localStorage or PHP session
        document.getElementById('profileName').value = localStorage.getItem('profileName') || <?= json_encode($username) ?>;
        document.getElementById('profileEmail').value = localStorage.getItem('profileEmail') || <?= json_encode(isset($_SESSION['email']) ? $_SESSION['email'] : 'user@email.com') ?>;
        document.getElementById('profileHeadline').value = localStorage.getItem('profileHeadline') || '';
        document.getElementById('profileBio').value = localStorage.getItem('profileBio') || '';
        document.getElementById('profileNameSidebar').textContent = localStorage.getItem('profileName') || <?= json_encode($username) ?>;
        document.getElementById('profileEmailSidebar').textContent = localStorage.getItem('profileEmail') || <?= json_encode(isset($_SESSION['email']) ? $_SESSION['email'] : 'user@email.com') ?>;
      });
      // Save profile info
      document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        localStorage.setItem('profileName', document.getElementById('profileName').value);
        localStorage.setItem('profileEmail', document.getElementById('profileEmail').value);
        localStorage.setItem('profileHeadline', document.getElementById('profileHeadline').value);
        localStorage.setItem('profileBio', document.getElementById('profileBio').value);
        document.getElementById('profileNameSidebar').textContent = document.getElementById('profileName').value;
        document.getElementById('profileEmailSidebar').textContent = document.getElementById('profileEmail').value;
        alert('Profile updated!');
      });
      closeProfileModal.addEventListener('click', () => {
        profileModal.classList.add('hidden');
      });
      window.addEventListener('click', (e) => {
        if (e.target === profileModal) {
          profileModal.classList.add('hidden');
        }
      });
      // Sidebar navigation logic
      const sidebarBtns = [
        { id: 'Profile', section: 'profileSectionProfile' },
        { id: 'Photo', section: 'profileSectionPhoto' },
        { id: 'Account Security', section: 'profileSectionAccount' },
        { id: 'Privacy', section: 'profileSectionPrivacy' },
        { id: 'Notification Preferences', section: 'profileSectionNotifications' },
        { id: 'Close account', section: 'profileSectionClose' },
      ];
      sidebarBtns.forEach(btn => {
        const el = Array.from(document.querySelectorAll('ul.w-full button')).find(b => b.textContent.trim() === btn.id);
        if (el) {
          el.addEventListener('click', () => {
            sidebarBtns.forEach(b => {
              document.getElementById(b.section).classList.add('hidden');
              const btnEl = Array.from(document.querySelectorAll('ul.w-full button')).find(b2 => b2.textContent.trim() === b.id);
              if (btnEl) btnEl.classList.remove('bg-gray-200', 'font-semibold');
            });
            document.getElementById(btn.section).classList.remove('hidden');
            el.classList.add('bg-gray-200', 'font-semibold');
          });
        }
      });
      // Profile photo logic
      const profilePhotoInput = document.getElementById('profilePhotoInput');
      const profilePhotoPreview = document.getElementById('profilePhotoPreview');
      const removePhotoBtn = document.getElementById('removePhotoBtn');
      function loadProfilePhoto() {
        const photo = localStorage.getItem('profilePhoto');
        if (photo) {
          profilePhotoPreview.src = photo;
          // Update sidebar avatar to show image
          sidebarAvatar.innerHTML = `<img src="${photo}" alt="Profile Photo" class="w-full h-full object-cover rounded-full" />`;
        } else {
          profilePhotoPreview.src = '';
          // Show initials if no photo
          sidebarAvatar.textContent = "<?= $initials ?>";
        }
      }
      const sidebarAvatar = document.getElementById('sidebarAvatar');
      if (profilePhotoInput && profilePhotoPreview && removePhotoBtn) {
        loadProfilePhoto();
        profilePhotoInput.addEventListener('change', function(e) {
          const file = e.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
              localStorage.setItem('profilePhoto', evt.target.result);
              loadProfilePhoto();
            };
            reader.readAsDataURL(file);
          }
        });
        removePhotoBtn.addEventListener('click', function() {
          localStorage.removeItem('profilePhoto');
          loadProfilePhoto();
        });
      }
    }
    window.addEventListener('storage', function(event) {
      if (event.key === 'userEmail') {
        document.getElementById('displayEmail').innerText = localStorage.getItem('userEmail') || '';
      }
      if (event.key === 'userName') {
        document.getElementById('displayName').innerText = localStorage.getItem('userName') || '';
      }
      if (event.key === 'userPhone') {
        document.getElementById('displayPhone').innerText = localStorage.getItem('userPhone') || '';
      }
    });
  </script>
</body>
</html>
