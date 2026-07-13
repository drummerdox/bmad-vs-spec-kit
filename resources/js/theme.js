const COOKIE_NAME = 'todolist_theme';
const MAX_AGE = 365 * 24 * 60 * 60;

function writeThemeCookie(theme) {
    document.cookie = `${COOKIE_NAME}=${theme};path=/;max-age=${MAX_AGE};SameSite=Lax`;
}

window.themeSwitcher = function themeSwitcher() {
    return {
        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',

        setTheme(theme) {
            if (theme !== 'light' && theme !== 'dark') {
                return;
            }

            this.theme = theme;
            document.documentElement.classList.toggle('dark', theme === 'dark');
            writeThemeCookie(theme);
        },
    };
};
