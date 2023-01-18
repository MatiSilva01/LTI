<?php require_once __DIR__.'/../i18n/index.php' ?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/#page-top">
            <img src="/assets/img/logo_h.png" width="140">
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <?= _("Menu") ?>
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/#about"><?= _("Sobre nós") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#projects"><?= _("Projeto") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/services/ipleiria"><?= _("IPLeiria") ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/#signup"><?= _("Contactos") ?></a>
                </li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='i18nDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'><?= _("Idioma")?></a>
                    <ul class='dropdown-menu' aria-labelledby='i18nDropdown'>
                        <?php
                            foreach ($validLangs as $lang) {
                                echo "<li><a class='dropdown-item change-i18n' href='#' data-value='$lang'>" . _($lang) . "</a></li>";
                            }
                        ?>
                    </ul>
                </li>

                <?php
                session_start();

                if (isset($_SESSION["user"])) {
                    # Require para fazer desserializar
                    require_once __DIR__ . '/../volunteer/volunteer.php';
                    require_once __DIR__ . '/../institution/institution.php';

                    $user = unserialize($_SESSION["user"]);


                    echo "
                    <li class='nav-item dropdown'>
                        <a class='nav-link dropdown-toggle' href='#' id='profileDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                          <img src='data:image/jpeg;base64,$user->foto' class='rounded-circle avatar' height='32' width='32' alt='Avatar' loading='lazy' />
                          <span class='ml-6'>$user->nome</span>
                        </a>
                        <ul class='dropdown-menu' aria-labelledby='profileDropdown'>
                            <li><a class='dropdown-item' href='/user/profile.php'>" . _("Perfil") . "</a></li>
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='/user/area.php'>" . _("Área") . "</a></li>
                            <li><hr class='dropdown-divider'></li>
                            <li><a class='dropdown-item' href='/user/logout.php'>" . _("Terminar Sessão") . "</a></li>
                        </ul>
                    </li>";
                } else {
                    echo "<a class=\"nav-link\" href=\"/auth.php\">" . _("Iniciar Sessão") . "</a>";
                }
                ?>


            </ul>
        </div>
    </div>
</nav>

<script>
    $('#logout').click(() => {
        $.ajax({
            url: '/user/logout.php',
            method: 'POST'
        }).done(() => window.location.reload())
    })

    $('.change-i18n').click(function() {
        const $el = $(this);
        document.cookie = `i18n=${$el.data('value')}; path=/`;
        window.location.reload();
    })
</script>