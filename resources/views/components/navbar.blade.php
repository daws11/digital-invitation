<!-- Navigation Bar -->
<nav class="fixed bottom-0 left-0 w-full bg-primary-dark border-t shadow-md z-10">
    <div class="container mx-auto flex justify-around py-2 max-w-screen-md">
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-chart-line"></i></span>
            <span class="text-xs md:text-sm">Dashboard</span>
        </a>

        <!-- Data Tamu -->
        <a href="{{ route('home') }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('home') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-users"></i></span>
            <span class="text-xs md:text-sm">Data Tamu</span>
        </a>

        <!-- Scan QR -->
        <!-- Scan QR -->
        <div class="text-center flex flex-col items-center">
            <a href="{{ route('scan-qr.show') }}" class="w-16 h-16 bg-orange-400 text-white rounded-full shadow-lg hover:bg-orange-500 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-orange-300 -mt-8">
                <i class="fa-solid fa-qrcode text-2xl"></i>
            </a>
            <span class="text-xs text-white md:text-sm">Scan QR</span>
        </div>

        <!-- Welcome Page -->
        <a href="{{ route('guests.show', ['slug' => 'tamu-undangan']) }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('guests.show') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-smile"></i></span>
            <span class="text-xs md:text-sm">Welcome</span>
        </a>

        <!-- Logout -->
        <a href="{{ route('logout') }}" 
           class="text-center flex flex-col items-center text-gray-400 hover:text-yellow-300"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span><i class="fa-solid fa-right-from-bracket"></i></span>
            <span class="text-xs md:text-sm">Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>
<style>
    nav a, nav button {
        transition: all 0.3s ease;
    }

    nav a:hover span:first-child,
    nav button:hover {
        transform: scale(1.1);
    }

    @media (min-width: 768px) {
        nav a span:first-child {
            font-size: 2rem;
        }
    }
</style>
