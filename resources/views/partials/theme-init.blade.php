<script>
(function () {
    var m = document.cookie.match(/(?:^|;\s*)todolist_theme=(light|dark)/);
    var t = m ? m[1] : 'light';
    if (t === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();
</script>
