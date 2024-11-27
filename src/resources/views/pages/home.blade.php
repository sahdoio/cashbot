<x-guest-layout>
    <header class="flex justify-between items-center py-4 px-6 bg-white shadow-md dark:bg-zinc-900">
        <h1 class="text-2xl font-bold text-black dark:text-white">Welcome to Laravel</h1>
        <a
            href="{{ route('login') }}"
            class="text-lg font-medium text-[#FF2D20] hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-[#FF2D20]"
        >
            Login
        </a>
    </header>
</x-guest-layout>
