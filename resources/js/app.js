import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const btn = document.getElementById('theme-toggle');
const darkIcon = document.getElementById('theme-toggle-dark-icon');
const lightIcon = document.getElementById('theme-toggle-light-icon');

if (!btn) {
    console.log('theme toggle not found');
}

if (
    localStorage.theme === 'dark' ||
    (!('theme' in localStorage) &&
        window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
    document.documentElement.classList.add('dark');
    darkIcon?.classList.remove('hidden');
} else {
    lightIcon?.classList.remove('hidden');
}

btn?.addEventListener('click', () => {
    darkIcon.classList.toggle('hidden');
    lightIcon.classList.toggle('hidden');
    document.documentElement.classList.toggle('dark');

    localStorage.theme = document.documentElement.classList.contains('dark')
        ? 'dark'
        : 'light';
});