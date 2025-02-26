<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GRANGTAXIGO - Book Your Taxi</title>
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
      transform: translateX(20px);
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
      <div class="flex items-center space-x-2">
        <div class="taxi-drive text-3xl font-bold">
          <i class="fas fa-taxi mr-2"></i>GRANGTAXIGO
        </div>
      </div>
      <div class="hidden md:flex space-x-8 text-lg">
        <a href="#" class="hover:text-yellow-200 transition-colors duration-300">Home</a>
        <a href="#" class="hover:text-yellow-200 transition-colors duration-300">Services</a>
        <a href="#" class="hover:text-yellow-200 transition-colors duration-300">About</a>
        <a href="#" class="hover:text-yellow-200 transition-colors duration-300">Contact</a>
      </div>
      <div>
        <!-- Enhanced Auth Buttons -->
        <div class="flex items-center space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn-primary">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn-secondary">
                                        Connexion
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn-primary">
                                            Inscription
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="relative overflow-hidden bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 text-white">
    <div class="container mx-auto px-4 py-16 md:py-24">
      <div class="grid md:grid-cols-2 gap-8 items-center">
        <div class="space-y-6 z-10">
          <h1 class="text-4xl md:text-6xl font-extrabold leading-tight" id="hero-text">
            Your Ride, <br>
            <span class="text-black">Just a Tap Away</span>
          </h1>
          <p class="text-lg md:text-xl opacity-90">
            Fast, reliable, and comfortable taxi service available 24/7. Book your ride now and enjoy the journey!
          </p>
          <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
            <button class="bg-black hover:bg-gray-800 text-white px-8 py-3 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
              Book Now
            </button>
            <button class="bg-white hover:bg-gray-100 text-yellow-500 px-8 py-3 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
              Learn More
            </button>
          </div>
        </div>
        <div class="relative">
          <div class="float">
            <img src="https://purepng.com/public/uploads/large/purepng.com-ford-mustang-red-carcarvehicletransportford-961524641401fbblv.png" alt="Taxi illustration" class="rounded-lg shadow-2xl mx-auto max-w-full h-auto">
          </div>
        </div>
      </div>
    </div>
    
    <!-- Animated shapes -->
    <div class="absolute top-20 right-20 w-20 h-20 bg-white opacity-10 rounded-full float" style="animation-delay: 0.5s;"></div>
    <div class="absolute bottom-10 left-10 w-32 h-32 bg-white opacity-10 rounded-full float" style="animation-delay: 1s;"></div>
    <div class="absolute top-40 left-40 w-16 h-16 bg-white opacity-10 rounded-full float" style="animation-delay: 1.5s;"></div>
  </div>
  <!-- Features Section -->
  <div class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Why Choose GRANGTAXIGO?</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white p-6 rounded-xl shadow-lg transition-transform duration-300 hover:transform hover:scale-105">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4 mx-auto">
          <i class="fas fa-bolt text-yellow-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center mb-2">Fast Pickup</h3>
        <p class="text-gray-600 text-center">Our drivers will reach you within minutes of booking your ride.</p>
      </div>
      
      <div class="bg-white p-6 rounded-xl shadow-lg transition-transform duration-300 hover:transform hover:scale-105">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4 mx-auto">
          <i class="fas fa-shield-alt text-yellow-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center mb-2">Safe Journey</h3>
        <p class="text-gray-600 text-center">All our drivers are verified and trained for your safety.</p>
      </div>
      
      <div class="bg-white p-6 rounded-xl shadow-lg transition-transform duration-300 hover:transform hover:scale-105">
        <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-4 mx-auto">
          <i class="fas fa-tag text-yellow-500 text-2xl"></i>
        </div>
        <h3 class="text-xl font-bold text-center mb-2">Affordable Rates</h3>
        <p class="text-gray-600 text-center">Enjoy competitive pricing with no hidden charges.</p>
      </div>
    </div>
  </div>
  
  <!-- Testimonials -->
  <div class="container mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">What Our Customers Say</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-center mb-4">
          <div class="text-yellow-500">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
        </div>
        <p class="text-gray-600 text-center mb-4">"GRANGTAXIGO never disappoints! My driver arrived within 3 minutes and got me to my destination safely and on time."</p>
        <div class="flex items-center justify-center">
          <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
          <div>
            <h4 class="font-bold">Sarah Johnson</h4>
            <p class="text-sm text-gray-500">Regular Customer</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-center mb-4">
          <div class="text-yellow-500">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
          </div>
        </div>
        <p class="text-gray-600 text-center mb-4">"The app is so easy to use, and the drivers are always professional. Best taxi service in the city!"</p>
        <div class="flex items-center justify-center">
          <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
          <div>
            <h4 class="font-bold">Michael Brown</h4>
            <p class="text-sm text-gray-500">Business Traveler</p>
          </div>
        </div>
      </div>
      
      <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-center mb-4">
          <div class="text-yellow-500">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
          </div>
        </div>
        <p class="text-gray-600 text-center mb-4">"I love the fare estimator feature. No surprises, and the prices are always reasonable. Highly recommend!"</p>
        <div class="flex items-center justify-center">
          <div class="w-10 h-10 bg-gray-200 rounded-full mr-3"></div>
          <div>
            <h4 class="font-bold">Emily Chen</h4>
            <p class="text-sm text-gray-500">Student</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Footer -->
  <footer class="bg-gray-800 text-white py-12">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-4 gap-8">
        <div>
          <h3 class="text-xl font-bold mb-4">GRANGTAXIGO</h3>
          <p class="text-gray-400">Your trusted partner for safe and reliable taxi services. Available 24/7 for all your transportation needs.</p>
        </div>
        
        <div>
          <h3 class="text-lg font-bold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Home</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Services</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">About Us</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Contact</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-bold mb-4">Services</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">City Taxi</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Airport Transfer</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Corporate Travel</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">Event Transportation</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-bold mb-4">Contact Us</h3>
          <ul class="space-y-2">
            <li class="flex items-center"><i class="fas fa-map-marker-alt mr-2"></i> 123 Taxi Street, City</li>
            <li class="flex items-center"><i class="fas fa-phone mr-2"></i> +1 (555) 123-4567</li>
            <li class="flex items-center"><i class="fas fa-envelope mr-2"></i> info@quickride.com</li>
          </ul>
          <div class="mt-4 flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      
      <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
        <p>&copy; 2025 QuickRide. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Animation Script -->
  <script>
    // Animate hero text on load
    window.addEventListener('DOMContentLoaded', () => {
      gsap.from("#hero-text", {
        duration: 1, 
        y: 50, 
        opacity: 0, 
        ease: "power3.out" 
      });
      
      // Animate features on scroll
      const features = document.querySelectorAll('.grid > div');
      gsap.from(features, {
        duration: 0.8,
        y: 50,
        opacity: 0,
        stagger: 0.2,
        scrollTrigger: {
          trigger: features[0],
          start: "top 80%"
        }
      });
    });
  </script>
</body>
</html>