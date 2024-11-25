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

        <!-- Check In -->
        <a href="{{ route('guests.updateAttendance', ['slug' => 'scan']) }}" 
           class="text-center flex flex-col items-center {{ request()->routeIs('guests.updateAttendance') ? 'text-white' : 'text-gray-400' }} hover:text-yellow-300">
            <span><i class="fa-solid fa-qrcode"></i></span>
            <span class="text-xs md:text-sm">Check In</span>
        </a>

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
    nav a {
        transition: color 0.3s ease, transform 0.3s ease; /* Smooth transition for color and hover effects */
    }

    nav a:hover span:first-child {
        transform: scale(1.2); /* Membesarkan ikon pada hover */
    }

    nav a span:first-child {
        font-size: 1.5rem; /* Ukuran ikon default */
    }

    @media (min-width: 768px) {
        nav a span:first-child {
            font-size: 2rem; /* Ikon lebih besar untuk layar medium */
        }
    }
</style>

