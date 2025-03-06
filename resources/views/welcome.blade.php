<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GrandTaxiGo - احجز سيارة أجرة بسهولة</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/js/all.min.js"></script>
  <style>
    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
      100% { transform: translateY(0px); }
    }
    
    .float {
      animation: float 6s ease-in-out infinite;
    }
    
    .taxi-drive {
      transition: transform 0.5s ease-in-out;
    }
    
    .taxi-drive:hover {
      transform: translateX(-20px);
    }
    
    .city-bg {
      background-image: url('/api/placeholder/800/200');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans min-h-screen">
  <!-- Navbar -->
  <nav class="bg-yellow-500 text-white shadow-lg">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
      <div class="flex items-center space-x-2 rtl:space-x-reverse">
        <div class="taxi-drive text-3xl font-bold">
          <i class="fas fa-taxi ml-2"></i>GrandTaxiGo
        </div>
      </div>
      <div class="hidden md:flex space-x-8 rtl:space-x-reverse text-lg">
        <a href="#" class="hover:text-yellow-200 transition-colors duration-300">الرئيسية</a>
        <a href="#services" class="hover:text-yellow-200 transition-colors duration-300">خدماتنا</a>
        <a href="#about" class="hover:text-yellow-200 transition-colors duration-300">من نحن</a>
        <a href="#contact" class="hover:text-yellow-200 transition-colors duration-300">اتصل بنا</a>
        @auth
          @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300">لوحة التحكم</a>
          @elseif(Auth::user()->role === 'driver')
            <a href="{{ route('dashboard') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300">لوحة السائق</a>
          @else
            <a href="{{ route('dashboard') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300">حجوزاتي</a>
          @endif
        @else
          <a href="{{ route('login') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300">تسجيل الدخول</a>
          <a href="{{ route('register') }}" class="bg-yellow-600 text-white px-4 py-1 rounded-full hover:bg-yellow-700 transition-colors duration-300">التسجيل</a>
        @endauth
      </div>
      <div class="md:hidden">
        <button id="mobile-menu-button" class="text-white focus:outline-none">
          <i class="fas fa-bars text-2xl"></i>
        </button>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-yellow-600 pb-4">
      <div class="container mx-auto px-4 py-2 flex flex-col space-y-3">
        <a href="#" class="text-white hover:text-yellow-200 transition-colors duration-300">الرئيسية</a>
        <a href="#services" class="text-white hover:text-yellow-200 transition-colors duration-300">خدماتنا</a>
        <a href="#about" class="text-white hover:text-yellow-200 transition-colors duration-300">من نحن</a>
        <a href="#contact" class="text-white hover:text-yellow-200 transition-colors duration-300">اتصل بنا</a>
        @auth
          @if(Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300 text-center">لوحة التحكم</a>
          @elseif(Auth::user()->role === 'driver')
            <a href="{{ route('dashboard') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300 text-center">لوحة السائق</a>
          @else
            <a href="{{ route('dashboard') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300 text-center">حجوزاتي</a>
          @endif
        @else
          <a href="{{ route('login') }}" class="bg-white text-yellow-500 px-4 py-1 rounded-full hover:bg-yellow-100 transition-colors duration-300 text-center">تسجيل الدخول</a>
          <a href="{{ route('register') }}" class="bg-yellow-700 text-white px-4 py-1 rounded-full hover:bg-yellow-800 transition-colors duration-300 text-center">التسجيل</a>
        @endauth
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="relative overflow-hidden bg-gradient-to-b from-yellow-400 to-yellow-500 text-white">
    <div class="container mx-auto px-4 py-16 md:py-24">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div class="text-center md:text-right">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">احجز سيارة أجرة بسهولة وأمان</h1>
          <p class="text-xl mb-8">منصة GrandTaxiGo توفر لك خدمة حجز سيارات الأجرة بطريقة سهلة وآمنة وبأسعار مناسبة.</p>
          <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 rtl:space-x-reverse justify-center md:justify-start">
            @auth
              <a href="{{ route('dashboard') }}" class="bg-white text-yellow-500 hover:bg-yellow-100 px-8 py-3 rounded-full text-lg font-bold transition-colors duration-300">ابدأ الآن</a>
            @else
              <a href="{{ route('register') }}" class="bg-white text-yellow-500 hover:bg-yellow-100 px-8 py-3 rounded-full text-lg font-bold transition-colors duration-300">سجل الآن</a>
              <a href="{{ route('login') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-3 rounded-full text-lg font-bold transition-colors duration-300">تسجيل الدخول</a>
            @endauth
          </div>
        </div>
        <div class="float">
          <img src="https://cdn-icons-png.flaticon.com/512/2554/2554936.png" alt="Taxi Illustration" class="w-full max-w-md mx-auto">
        </div>
      </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#f9fafb" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,149.3C960,160,1056,160,1152,138.7C1248,117,1344,75,1392,53.3L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
      </svg>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">خدماتنا</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">نقدم مجموعة متنوعة من الخدمات لتلبية احتياجاتك في التنقل بكل راحة وأمان.</p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <div class="p-6">
            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-map-marker-alt text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-center mb-2">حجز سهل وسريع</h3>
            <p class="text-gray-600 text-center">احجز سيارة أجرة بضغطة زر واحدة، بدون انتظار أو مكالمات هاتفية.</p>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <div class="p-6">
            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-shield-alt text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-center mb-2">سائقين موثوقين</h3>
            <p class="text-gray-600 text-center">جميع السائقين لدينا مرخصين ومدربين لضمان رحلة آمنة ومريحة.</p>
          </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
          <div class="p-6">
            <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-money-bill-wave text-white text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-center mb-2">أسعار شفافة</h3>
            <p class="text-gray-600 text-center">أسعارنا واضحة وشفافة، بدون رسوم خفية أو زيادات مفاجئة.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="py-16 bg-white">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <div>
          <img src="https://cdn-icons-png.flaticon.com/512/4946/4946854.png" alt="About Us" class="w-full max-w-md mx-auto">
        </div>
        <div>
          <h2 class="text-3xl font-bold text-gray-800 mb-4">من نحن</h2>
          <p class="text-gray-600 mb-4">GrandTaxiGo هي منصة رائدة في مجال حجز سيارات الأجرة عبر الإنترنت، تهدف إلى تسهيل عملية التنقل وتوفير تجربة سفر مريحة وآمنة للجميع.</p>
          <p class="text-gray-600 mb-4">تأسست الشركة في عام 2023 بهدف تحسين خدمات النقل وتوفير فرص عمل للسائقين، مع التركيز على الجودة والأمان والراحة.</p>
          <p class="text-gray-600">نحن نسعى جاهدين لتقديم أفضل خدمة ممكنة لعملائنا، ونعمل باستمرار على تطوير منصتنا لتلبية احتياجاتهم المتغيرة.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">اتصل بنا</h2>
        <p class="text-gray-600 max-w-2xl mx-auto">نحن هنا للإجابة على جميع استفساراتك. لا تتردد في التواصل معنا.</p>
      </div>
      
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 bg-yellow-500 text-white">
              <h3 class="text-xl font-bold mb-4">معلومات الاتصال</h3>
              <div class="space-y-4">
                <div class="flex items-start">
                  <i class="fas fa-map-marker-alt mt-1 ml-3"></i>
                  <p>123 شارع المدينة، المغرب</p>
                </div>
                <div class="flex items-start">
                  <i class="fas fa-phone mt-1 ml-3"></i>
                  <p>+212 5XX-XXXXXX</p>
                </div>
                <div class="flex items-start">
                  <i class="fas fa-envelope mt-1 ml-3"></i>
                  <p>info@grandtaxigo.com</p>
                </div>
              </div>
              <div class="mt-8">
                <h4 class="font-bold mb-2">تابعنا على</h4>
                <div class="flex space-x-4 rtl:space-x-reverse">
                  <a href="#" class="text-white hover:text-yellow-200 transition-colors duration-300">
                    <i class="fab fa-facebook-f text-xl"></i>
                  </a>
                  <a href="#" class="text-white hover:text-yellow-200 transition-colors duration-300">
                    <i class="fab fa-twitter text-xl"></i>
                  </a>
                  <a href="#" class="text-white hover:text-yellow-200 transition-colors duration-300">
                    <i class="fab fa-instagram text-xl"></i>
                  </a>
                </div>
              </div>
            </div>
            <div class="p-6">
              <form>
                <div class="mb-4">
                  <label for="name" class="block text-gray-700 mb-2">الاسم</label>
                  <input type="text" id="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div class="mb-4">
                  <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
                  <input type="email" id="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500">
                </div>
                <div class="mb-4">
                  <label for="message" class="block text-gray-700 mb-2">الرسالة</label>
                  <textarea id="message" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                </div>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg transition-colors duration-300">إرسال</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-8">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-bold mb-4">GrandTaxiGo</h3>
          <p class="text-gray-400">منصة حجز سيارات الأجرة الرائدة في المغرب.</p>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">الرئيسية</a></li>
            <li><a href="#services" class="text-gray-400 hover:text-white transition-colors duration-300">خدماتنا</a></li>
            <li><a href="#about" class="text-gray-400 hover:text-white transition-colors duration-300">من نحن</a></li>
            <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors duration-300">اتصل بنا</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">الخدمات</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">حجز سيارة أجرة</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">رحلات مشتركة</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">رحلات خاصة</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">خدمات الشركات</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4">النشرة الإخبارية</h3>
          <p class="text-gray-400 mb-4">اشترك في نشرتنا الإخبارية للحصول على آخر الأخبار والعروض.</p>
          <form class="flex">
            <input type="email" placeholder="بريدك الإلكتروني" class="px-4 py-2 rounded-l-lg focus:outline-none flex-grow">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-r-lg transition-colors duration-300">اشتراك</button>
          </form>
        </div>
      </div>
      <div class="border-t border-gray-700 mt-8 pt-8 text-center">
        <p class="text-gray-400">&copy; 2023 GrandTaxiGo. جميع الحقوق محفوظة.</p>
      </div>
    </div>
  </footer>

  <script>
    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    mobileMenuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</body>
</html>