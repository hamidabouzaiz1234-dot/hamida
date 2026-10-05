<?php
declare(strict_types=1);
session_start();

/* =====================================================
   1. CONFIGURATION
===================================================== */

$site = [
    'name' => 'Hamida Bouzaiz',
    'role' => 'Stagiaire Full Stack',
    'school' => 'ISTA NTIC Tanger · 2ème année',

    // Remplace par ton véritable email
    'email' => 'ton@email.com',

    'tagline' => "Stagiaire en développement Full Stack à l'ISTA NTIC Tanger. Je construis des applications web complètes, du back-end à l'interface.",

    'about' => "Actuellement en 2ème année de la filière Développement Digital option Web Full Stack à l'ISTA NTIC Tanger. Je suis motivée, curieuse et j'apprends en pratiquant : ateliers, projets de groupe et projets personnels.",

    /* COMPÉTENCES */
    'skills' => [
        'HTML5',
        'CSS3',
        'JavaScript',
        'PHP',
        'MySQL',
        'Laravel',
        'Bootstrap',
        'Git / GitHub'
    ],

    /* =================================================
       ATELIERS
       Sur Vercel, le dossier public/ est servi depuis la
       racine : donc le chemin est /images/... (sans public/)
    ================================================= */
    'ateliers' => [

        [
            'id' => 'atelier-1',
            'title' => 'Atelier 1 : Gestion de projet',
            'subtitle' => 'Méthode classique',
            'date' => '28/09/2026',
            'desc' => "Découverte des méthodes classiques de gestion de projet.",
            'img' => '/images/atelier1/cover.jpg',
            'photos' => [
                '/images/atelier1/photo1.jpg',
                '/images/atelier1/photo2.jpg',
            ],
            'tags' => ['Gestion de projet', 'Méthode classique']
        ],

        [
            'id' => 'atelier-2',
            'title' => 'Atelier 2 : Gestion de projet Agile',
            'subtitle' => 'Modèle Agile · Scrum',
            'date' => '2026',
            'desc' => "Mise en pratique de la méthode Agile avec le framework Scrum.",
            'img' => '/images/atelier2/cover.jpg',
            'photos' => [
                '/images/atelier2/photo1.jpg',
                '/images/atelier2/photo2.jpg',
            ],
            'tags' => ['Agile', 'Scrum']
        ],

        [
            'title' => 'Atelier 3 : Développement web',
            'date' => '2025',
            'desc' => "Réalisation d'un atelier pratique en développement web.",
            'tags' => ['Développement web', 'Pratique']
        ],

        [
            'title' => 'Atelier 4 : Développement web',
            'date' => '2026',
            'desc' => "Mise en pratique des connaissances acquises en développement web.",
            'tags' => ['HTML', 'CSS', 'JavaScript']
        ],

        [
            'title' => 'Atelier 5 : Base de données',
            'date' => '2026',
            'desc' => "Travail pratique autour de la conception et de la gestion des bases de données.",
            'tags' => ['MySQL', 'Base de données']
        ],

        [
            'title' => 'Atelier 6 : Projet pratique',
            'date' => '2026',
            'desc' => "Réalisation d'un projet pratique permettant de mettre en application les compétences acquises.",
            'tags' => ['Projet', 'Pratique']
        ]

    ],

    /* =================================================
       PROJETS
    ================================================= */
    'projects' => [

        [
            'title' => 'VENDO',
            'desc' => "VENDO est une plateforme web de petites annonces permettant aux utilisateurs de publier et de consulter des annonces.",
            'stack' => ['HTML', 'CSS', 'PHP', 'MySQL'],
            'url' => '#',
            'code' => '#'
        ]

    ],

    /* =================================================
       RÉSEAUX SOCIAUX
    ================================================= */
    'socials' => [
        'GitHub' => '#',
        'LinkedIn' => '#'
    ]
];


/* =====================================================
   2. FONCTION DE SÉCURITÉ
===================================================== */

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}


/* =====================================================
   3. FORMULAIRE DE CONTACT
===================================================== */

$flash = null;

$old = [
    'name' => '',
    'email' => '',
    'message' => ''
];

/* Création du token CSRF */
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

/* Traitement du formulaire */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $old = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'message' => trim($_POST['message'] ?? '')
    ];

    /* Vérification CSRF */
    if (
        !isset($_POST['csrf']) ||
        !is_string($_POST['csrf']) ||
        !hash_equals($_SESSION['csrf'], $_POST['csrf'])
    ) {
        $flash = ['error', 'Session expirée. Recharge la page et réessaie.'];
    }

    /* Protection anti-spam */
    elseif (!empty($_POST['website'])) {
        $flash = ['ok', 'Message envoyé.'];
    }

    /* Validation */
    elseif (
        $old['name'] === '' ||
        $old['message'] === '' ||
        !filter_var($old['email'], FILTER_VALIDATE_EMAIL)
    ) {
        $flash = ['error', 'Remplis tous les champs avec une adresse email valide.'];
    }

    /* Envoi du message */
    else {

        $name = str_replace(["\r", "\n"], '', $old['name']);

        $subject = 'Portfolio : message de ' . $name;

        $headers =
            'From: ' . $site['email'] . "\r\n" .
            'Reply-To: ' . $old['email'] . "\r\n" .
            'Content-Type: text/plain; charset=UTF-8';

        if (@mail($site['email'], $subject, $old['message'], $headers)) {

            $flash = ['ok', 'Message envoyé. Je te réponds rapidement.'];

            $old = ['name' => '', 'email' => '', 'message' => ''];

        } else {

            $flash = [
                'error',
                "L'envoi a échoué. Écris-moi directement à " . $site['email'] . '.'
            ];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= e($site['name']) ?> — <?= e($site['role']) ?></title>

    <meta name="description" content="<?= e($site['tagline']) ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=JetBrains+Mono:wght@400;500&family=Inter:wght@400;500&display=swap"
        rel="stylesheet"
    >

    <style>

        /* =====================================================
           1. VARIABLES
        ===================================================== */

        :root {
            --bg: #0c1220;
            --panel: #151d30;
            --line: #26324d;
            --text: #e8ecf5;
            --muted: #8f9bb8;
            --accent: #ffb454;
            --accent-ink: #1a1204;
            --ok: #5fd0a0;
            --err: #ff7a7a;
        }


        /* =====================================================
           2. RESET
        ===================================================== */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 4.5rem;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font: 400 1rem/1.7 'Inter', system-ui, sans-serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        ul {
            list-style: none;
        }

        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 3px;
        }


        /* =====================================================
           3. STRUCTURE
        ===================================================== */

        .wrap {
            max-width: 1040px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .narrow {
            max-width: 640px;
        }

        h1, h2, h3, .brand {
            font-family: 'Bricolage Grotesque', sans-serif;
            line-height: 1.15;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
        }

        section {
            padding: 5rem 1.5rem 2rem;
        }


        /* =====================================================
           4. NAVIGATION
        ===================================================== */

        .top {
            position: sticky;
            top: 0;
            z-index: 10;
            background: rgba(12, 18, 32, .88);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--line);
        }

        .top nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-block: 1rem;
        }

        .brand {
            font-weight: 800;
            font-size: 1.15rem;
        }

        .top ul {
            display: flex;
            gap: 1.5rem;
            color: var(--muted);
            font-size: .95rem;
        }

        .top ul a:hover {
            color: var(--text);
        }


        /* =====================================================
           5. HERO
        ===================================================== */

        .hero {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 3rem;
            align-items: center;
            min-height: calc(100vh - 4rem);
        }

        .school {
            font: 500 .85rem 'JetBrains Mono', monospace;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .lead {
            color: var(--muted);
            font-size: 1.1rem;
            max-width: 34rem;
            margin: 1.25rem 0 2rem;
        }

        .actions {
            display: flex;
            gap: .8rem;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: .75rem 1.5rem;
            border-radius: 6px;
            border: 1px solid var(--accent);
            background: var(--accent);
            color: var(--accent-ink);
            font: 700 .95rem 'Inter', sans-serif;
            cursor: pointer;
            transition: transform .15s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn.ghost {
            background: transparent;
            color: var(--text);
            border-color: var(--line);
        }


        /* =====================================================
           6. CODE CARD
        ===================================================== */

        .code {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 1.5rem;
            overflow-x: auto;
            font: 400 .9rem/1.8 'JetBrains Mono', monospace;
        }

        .code .c { color: #62708f; }
        .code .k { color: var(--accent); }
        .code .s { color: #8fc7ff; }
        .code .v { color: var(--ok); }


        /* =====================================================
           7. ABOUT
        ===================================================== */

        .about {
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 2.5rem;
            align-items: start;
        }

        .about p {
            color: var(--muted);
            max-width: 38rem;
        }

        .skills {
            display: flex;
            flex-wrap: wrap;
            gap: .5rem;
        }

        .skills li,
        .tags li {
            font: 500 .8rem 'JetBrains Mono', monospace;
            padding: .3rem .7rem;
            border: 1px solid var(--line);
            border-radius: 4px;
        }


        /* =====================================================
           8. ATELIERS
        ===================================================== */

        .ateliers {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .atelier {
            position: relative;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 10px;
            overflow: hidden;
            padding: 0;
            transition: transform .2s, border-color .2s, box-shadow .2s;
        }

        .atelier:hover {
            transform: translateY(-5px);
            border-color: var(--accent);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .22);
        }

        .atelier::before {
            display: none;
        }

        /* Toute la carte devient cliquable */
        .atelier.clickable {
            cursor: pointer;
        }

        .atelier-link::after {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .atelier-more {
            display: inline-block;
            margin-top: .9rem;
            color: var(--accent);
            font-weight: 500;
            font-size: .9rem;
        }

        /* Image de chaque atelier */
        .atelier-image {
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: var(--bg);
        }

        .atelier-image img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            margin: 0;
            border: 0;
            border-radius: 0;
            transition: transform .3s;
        }

        .atelier:hover .atelier-image img {
            transform: scale(1.04);
        }

        /* Contenu */
        .atelier-content {
            padding: 1.3rem;
        }

        .atelier time {
            font: 500 .8rem 'JetBrains Mono', monospace;
            color: var(--accent);
        }

        .atelier h3 {
            font-size: 1.2rem;
            margin: .35rem 0 .55rem;
        }

        .atelier p {
            color: var(--muted);
            font-size: .95rem;
            margin-bottom: .9rem;
        }


        /* =====================================================
           9. TAGS
        ===================================================== */

        .tags {
            display: flex;
            flex-wrap: wrap;
            gap: .4rem;
        }


        /* =====================================================
           10. BOUTONS PHOTOS
        ===================================================== */

        .photos-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: .8rem;
            margin-top: 1.5rem;
        }


        /* =====================================================
           11. GALERIES PHOTOS
        ===================================================== */

        .atelier-photos {
            margin-top: 4rem;
            scroll-margin-top: 5rem;
        }

        .atelier-photos h3 {
            font-size: 1.5rem;
            margin-bottom: 1.2rem;
        }

        .photos-sub {
            color: var(--muted);
            margin: -.8rem 0 1.2rem;
            font-size: .95rem;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1rem;
        }

        .photo-item {
            display: block;
            overflow: hidden;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--panel);
        }

        .photo-item img {
            display: block;
            width: 100%;
            height: 190px;
            object-fit: cover;
            transition: transform .3s;
        }

        .photo-item:hover img {
            transform: scale(1.04);
        }


        /* =====================================================
           12. PROJECTS
        ===================================================== */

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .card {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: transform .2s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card h3 {
            font-size: 1.3rem;
        }

        .card > p {
            color: var(--muted);
            font-size: .95rem;
        }

        .card .tags {
            margin-top: auto;
        }

        .links {
            display: flex;
            gap: 1.2rem;
            font-weight: 500;
        }

        .links a {
            color: var(--accent);
            border-bottom: 1px solid transparent;
        }

        .links a:hover {
            border-color: var(--accent);
        }


        /* =====================================================
           13. CONTACT
        ===================================================== */

        form {
            display: grid;
            gap: 1.1rem;
        }

        label {
            display: grid;
            gap: .4rem;
            color: var(--muted);
            font-size: .9rem;
        }

        input,
        textarea {
            width: 100%;
            padding: .8rem .9rem;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 6px;
            color: var(--text);
            font: inherit;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--accent);
        }

        textarea {
            resize: vertical;
        }

        .hp {
            position: absolute;
            left: -9999px;
        }

        .flash {
            padding: .8rem 1rem;
            border-radius: 6px;
            margin-bottom: 1.2rem;
            border: 1px solid;
        }

        .flash.ok {
            color: var(--ok);
            border-color: var(--ok);
        }

        .flash.error {
            color: var(--err);
            border-color: var(--err);
        }


        /* =====================================================
           14. FOOTER
        ===================================================== */

        footer {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 5rem;
            padding-block: 2rem;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: .9rem;
        }

        footer a {
            margin-left: 1rem;
        }

        footer a:hover {
            color: var(--text);
        }


        /* =====================================================
           15. RESPONSIVE
        ===================================================== */

        @media (max-width: 800px) {

            .hero,
            .about,
            .ateliers {
                grid-template-columns: 1fr;
            }

            .photos-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero {
                min-height: auto;
                padding-top: 3rem;
            }

            .top ul {
                gap: .8rem;
                font-size: .8rem;
            }

            .brand {
                font-size: 1rem;
            }
        }

        @media (max-width: 500px) {

            .top nav {
                flex-direction: column;
                gap: 1rem;
            }

            .top ul {
                flex-wrap: wrap;
                justify-content: center;
            }

            section {
                padding-top: 3rem;
            }

            h2 {
                font-size: 1.7rem;
            }

            .photos-grid {
                grid-template-columns: 1fr;
            }

            .atelier-image {
                height: 200px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            html {
                scroll-behavior: auto;
            }

            .btn,
            .card,
            .atelier,
            .atelier-image img,
            .photo-item img {
                transition: none;
            }
        }

    </style>

</head>


<body>

<!-- =====================================================
     NAVIGATION
===================================================== -->

<header class="top">
    <nav class="wrap">

        <a class="brand" href="#top"><?= e($site['name']) ?></a>

        <ul>
            <li><a href="#about">À propos</a></li>
            <li><a href="#ateliers">Ateliers</a></li>
            <li><a href="#projects">Projets</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>

    </nav>
</header>


<main id="top">

<!-- =====================================================
     HERO
===================================================== -->

<section class="hero wrap">

    <div>
        <p class="school"><?= e($site['school']) ?></p>

        <h1>Bonjour, je suis <?= e($site['name']) ?>.</h1>

        <p class="lead"><?= e($site['tagline']) ?></p>

        <p class="actions">
            <a class="btn" href="#projects">Voir mes projets</a>
            <a class="btn ghost" href="#contact">Me contacter</a>
        </p>
    </div>

    <pre class="code" aria-label="Résumé du profil en code PHP"><code><span class="c">&lt;?php</span>
<span class="k">$dev</span> = [
  <span class="s">'nom'</span>    =&gt; <span class="v">'<?= e($site['name']) ?>'</span>,
  <span class="s">'ecole'</span>  =&gt; <span class="v">'ISTA NTIC Tanger'</span>,
  <span class="s">'stack'</span>  =&gt; [
    <?php
    $firstSkills = array_slice($site['skills'], 0, 3);

    echo implode(
        ",\n    ",
        array_map(
            fn($s) => '<span class="v">\'' . e($s) . '\'</span>',
            $firstSkills
        )
    );
    ?>

  ],
  <span class="s">'dispo'</span>  =&gt; <span class="v">true</span>,
];</code></pre>

</section>


<!-- =====================================================
     ABOUT
===================================================== -->

<section id="about" class="wrap">

    <h2>À propos</h2>

    <div class="about">

        <p><?= e($site['about']) ?></p>

        <ul class="skills">
            <?php foreach ($site['skills'] as $skill): ?>
                <li><?= e($skill) ?></li>
            <?php endforeach; ?>
        </ul>

    </div>

</section>


<!-- =====================================================
     ATELIERS
===================================================== -->

<section id="ateliers" class="wrap">

    <h2>Ateliers</h2>

    <!-- LES 6 ATELIERS -->
    <div class="ateliers">

        <?php foreach ($site['ateliers'] as $a): ?>
            <?php $hasPhotos = !empty($a['photos']); ?>

            <article class="atelier<?= $hasPhotos ? ' clickable' : '' ?>">

                <!-- IMAGE -->
                <?php if (!empty($a['img'])): ?>
                    <div class="atelier-image">
                        <img
                            src="<?= e($a['img']) ?>"
                            alt="<?= e($a['title']) ?>"
                            loading="lazy"
                        >
                    </div>
                <?php endif; ?>

                <!-- INFORMATIONS -->
                <div class="atelier-content">

                    <time><?= e($a['date']) ?></time>

                    <h3>
                        <?php if ($hasPhotos): ?>
                            <a class="atelier-link" href="#photos-<?= e($a['id']) ?>">
                                <?= e($a['title']) ?>
                            </a>
                        <?php else: ?>
                            <?= e($a['title']) ?>
                        <?php endif; ?>
                    </h3>

                    <p><?= e($a['desc']) ?></p>

                    <!-- TAGS -->
                    <?php if (!empty($a['tags'])): ?>
                        <ul class="tags">
                            <?php foreach ($a['tags'] as $t): ?>
                                <li><?= e($t) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php if ($hasPhotos): ?>
                        <span class="atelier-more">📸 Voir les photos →</span>
                    <?php endif; ?>

                </div>

            </article>

        <?php endforeach; ?>

    </div>


    <!-- BOUTONS VERS LES GALERIES -->
    <div class="photos-buttons">
        <?php foreach ($site['ateliers'] as $a): ?>
            <?php if (!empty($a['photos'])): ?>
                <a class="btn photos-button" href="#photos-<?= e($a['id']) ?>">
                    📸 <?= e($a['subtitle']) ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>


    <!-- GALERIES : une par atelier -->
    <?php foreach ($site['ateliers'] as $a): ?>
        <?php if (empty($a['photos'])) continue; ?>

        <div id="photos-<?= e($a['id']) ?>" class="atelier-photos">

            <h3><?= e($a['title']) ?></h3>
            <p class="photos-sub"><?= e($a['subtitle']) ?></p>

            <div class="photos-grid">
                <?php foreach ($a['photos'] as $i => $src): ?>
                    <a
                        class="photo-item"
                        href="<?= e($src) ?>"
                        target="_blank"
                        rel="noopener"
                    >
                        <img
                            src="<?= e($src) ?>"
                            alt="<?= e($a['title']) ?> - photo <?= $i + 1 ?>"
                            loading="lazy"
                        >
                    </a>
                <?php endforeach; ?>
            </div>

        </div>
    <?php endforeach; ?>

</section>


<!-- =====================================================
     PROJECTS
===================================================== -->

<section id="projects" class="wrap">

    <h2>Projets</h2>

    <div class="grid">

        <?php foreach ($site['projects'] as $p): ?>

            <article class="card">

                <h3><?= e($p['title']) ?></h3>

                <p><?= e($p['desc']) ?></p>

                <ul class="tags">
                    <?php foreach ($p['stack'] as $t): ?>
                        <li><?= e($t) ?></li>
                    <?php endforeach; ?>
                </ul>

                <p class="links">

                    <?php if (!empty($p['url']) && $p['url'] !== '#'): ?>
                        <a href="<?= e($p['url']) ?>" target="_blank" rel="noopener">Démo</a>
                    <?php endif; ?>

                    <?php if (!empty($p['code']) && $p['code'] !== '#'): ?>
                        <a href="<?= e($p['code']) ?>" target="_blank" rel="noopener">Code source</a>
                    <?php endif; ?>

                </p>

            </article>

        <?php endforeach; ?>

    </div>

</section>


<!-- =====================================================
     CONTACT
===================================================== -->

<section id="contact" class="wrap narrow">

    <h2>Contact</h2>

    <?php if ($flash): ?>
        <p class="flash <?= e($flash[0]) ?>" role="status">
            <?= e($flash[1]) ?>
        </p>
    <?php endif; ?>

    <form method="post" action="#contact">

        <!-- CSRF -->
        <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">

        <!-- Anti-spam -->
        <input
            type="text"
            name="website"
            class="hp"
            tabindex="-1"
            autocomplete="off"
            aria-hidden="true"
        >

        <label>
            Nom
            <input type="text" name="name" value="<?= e($old['name']) ?>" required>
        </label>

        <label>
            Email
            <input type="email" name="email" value="<?= e($old['email']) ?>" required>
        </label>

        <label>
            Message
            <textarea name="message" rows="5" required><?= e($old['message']) ?></textarea>
        </label>

        <button class="btn" type="submit">Envoyer le message</button>

    </form>

</section>

</main>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer class="wrap">

    <p>&copy; <?= date('Y') ?> <?= e($site['name']) ?></p>

    <p>
        <?php foreach ($site['socials'] as $label => $url): ?>
            <a href="<?= e($url) ?>" target="_blank" rel="noopener">
                <?= e($label) ?>
            </a>
        <?php endforeach; ?>
    </p>

</footer>

</body>
</html>