@php
    $btrSidebarToggleId = $btrSidebarToggleId ?? null;
    $btrOverlayId = $btrOverlayId ?? null;
    $btrToggleNavParents = $btrToggleNavParents ?? false;
@endphp

<script>
    (function () {
        var sidebarToggle = {!! $btrSidebarToggleId ? json_encode($btrSidebarToggleId) : 'null' !!};
        var overlayId = {!! $btrOverlayId ? json_encode($btrOverlayId) : 'null' !!};
        var overlay = overlayId ? document.getElementById(overlayId) : null;

        if (sidebarToggle) {
            var toggleButton = document.getElementById(sidebarToggle);
            if (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    document.body.classList.toggle('btr-sidebar-open');
                    if (overlay) overlay.classList.toggle('open');
                });
            }
        }

        if (overlay) {
            overlay.addEventListener('click', function () {
                document.body.classList.remove('btr-sidebar-open');
                overlay.classList.remove('open');
            });
        }

        if ({!! $btrToggleNavParents ? 'true' : 'false' !!}) {
            document.querySelectorAll('.btr-nav-parent').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    var children = btn.nextElementSibling;
                    btn.classList.toggle('open');
                    if (children && children.classList.contains('btr-nav-children')) {
                        children.classList.toggle('open');
                    }
                });
            });
        }

        document.querySelectorAll('.btr-nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                document.body.classList.remove('btr-sidebar-open');
                if (overlay) overlay.classList.remove('open');
            });
        });

        document.addEventListener('click', function (event) {
            document.querySelectorAll('.btr-topbar-profile-menu[open]').forEach(function (menu) {
                if (!menu.contains(event.target)) {
                    menu.removeAttribute('open');
                }
            });
        });

        function btrTickClock() {
            var el = document.getElementById('btr-clock');
            if (!el) return;
            var d = new Date();
            var pad = function (n) { return n < 10 ? '0' + n : n; };
            el.textContent = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
        }

        setInterval(btrTickClock, 1000);
        btrTickClock();
    })();
</script>
