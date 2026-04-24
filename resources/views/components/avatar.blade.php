@props(['user'])

<div class="flex items-center justify-center w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white font-bold text-lg">
    {{ strtoupper(substr($user->firstname, 0, 1)) }}
</div>
