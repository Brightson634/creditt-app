<script src="{{ asset('assets/backend/dash/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/dash/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/backend/dash/lib/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('assets/backend/dash/lib/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/backend/dash/lib/toastr/toastr.min.js') }}"></script>
<script src=" {{ asset('assets/backend/dash/js/azia.js') }}"></script>
<script>
    // Function to scroll to a section smoothly
    function scrollToSection(targetId) {
        const targetElement = document.getElementById(targetId);
        if (targetElement) {
            window.scrollTo({
                top: targetElement.offsetTop - 70,
                behavior: 'smooth'
            });
        }
    }

    // Handle clicks on anchor links (same-page scrolling)
    document.querySelectorAll('a[href*="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            const [path, hash] = href.split('#');
            const currentPath = window.location.pathname;
            if (!hash || (path === currentPath || path === '')) {
                e.preventDefault();
                const targetId = hash;
                scrollToSection(targetId);
            }
        });
    });

    // Handle hash in URL on page load (cross-page redirection)
    window.addEventListener('load', () => {
        const hash = window.location.hash.substring(1);
        if (hash) {
            scrollToSection(hash);
        }
    });

    const yearSpan = document.getElementById('currentYear');
    yearSpan.innerText = (new Date()).getFullYear();
</script>