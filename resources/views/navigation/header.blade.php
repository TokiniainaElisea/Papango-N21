<nav class="navbar bg-body-tertiary text-body border-bottom">
    <div class="container-fluid">

        <a href="#"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none px-2">
            <img src="{{ asset('icon.png') }}" alt="logo" width="30" class="me-2">
            Papango N21
        </a>

        <div class="d-flex">
            <button type="button" class="btn btn-sm btn-outline-primary" id="toggleButton" title="Changer le thème">
                <i class="bi bi-sun" id="themeIcon"></i>
            </button>
        </div>

    </div>
</nav>


<script>
    const toggleButton = document.querySelector('#toggleButton');
    const themeIcon = document.querySelector('#themeIcon');

    // Récupération du thème sauvegardé
    let currentTheme = localStorage.getItem('theme') ?? 'dark';


    // Applique le thème
    const applyTheme = (theme) => {

        document.documentElement.setAttribute('data-bs-theme', theme);

        if (theme === 'dark') {

            themeIcon.classList.remove('bi-moon');
            themeIcon.classList.add('bi-sun');

        } else {

            themeIcon.classList.remove('bi-sun');
            themeIcon.classList.add('bi-moon');

        }

        localStorage.setItem('theme', theme);
        currentTheme = theme;
    };


    // Appliquer le thème au chargement
    applyTheme(currentTheme);


    // Changement de thème
    toggleButton.addEventListener('click', () => {

        const newTheme = currentTheme === 'dark' ?
            'light' :
            'dark';

        applyTheme(newTheme);

    });
</script>
