<?php
session_start();

/*
 * Portfolio professionnel de Hamida Bouzaiz
 */

$nom = "Hamida Bouzaiz";
$photo = "public/images/photo.jpg";
$logo = "public/images/logo.png";
$linkedin = "https://www.linkedin.com/";

// Les trois ateliers
$ateliers = [
    [
        "numero" => "01",
        "titre" => "Méthode classique en cascade",
        "description" => "Découverte des étapes de la méthode en cascade : analyse, conception, développement, tests et maintenance.",
        "dossier" => "atelier1",
        "icone" => "↘",
        "couleur" => "sage"
    ],
    [
        "numero" => "02",
        "titre" => "Gestion de projet agile",
        "description" => "Organisation du travail en équipe, planification agile, user stories et suivi des tâches.",
        "dossier" => "atelier2",
        "icone" => "✳",
        "couleur" => "rose"
    ],
    [
        "numero" => "03",
        "titre" => "Atelier pratique Git N° 1",
        "description" => "Initiation à Git, gestion des versions, commits et collaboration autour d'un projet.",
        "dossier" => "atelier3",
        "icone" => "⌘",
        "couleur" => "blue"
    ]
];

$envoye = false;
$erreurs = [];
$nomContact = "";
$emailContact = "";
$messageContact = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["contact_submit"])) {

    $nomContact = trim($_POST["nom"] ?? "");
    $emailContact = trim($_POST["email"] ?? "");
    $messageContact = trim($_POST["message"] ?? "");

    if ($nomContact === "") {
        $erreurs[] = "Veuillez saisir votre nom.";
    }

    if (!filter_var($emailContact, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Veuillez saisir une adresse e-mail valide.";
    }

    if ($messageContact === "") {
        $erreurs[] = "Veuillez écrire votre message.";
    }

    if (empty($erreurs)) {
        $envoye = true;
    }
}

function e($valeur) {
    return htmlspecialchars(
        (string)$valeur,
        ENT_QUOTES,
        "UTF-8"
    );
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="description"
          content="Portfolio professionnel de Hamida Bouzaiz, stagiaire en Développement Digital Full Stack à l'ISTIA NTIC Tanger.">

    <title>Hamida Bouzaiz | Portfolio</title>

    <style>
        :root {
            --cream: #f8f3eb;
            --beige: #eadbc8;
            --beige-dark: #d7bea2;
            --brown: #513a2c;
            --brown-dark: #34241c;
            --text: #3f332b;
            --muted: #817266;
            --white: #fffdf9;
            --line: rgba(81, 58, 44, .15);
            --shadow: 0 18px 50px rgba(70, 48, 33, .10);
            --radius: 24px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 90px;
        }

        body {
            margin: 0;
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            background: var(--cream);
            color: var(--text);
            line-height: 1.7;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .container {
            width: min(1120px, calc(100% - 40px));
            margin: auto;
        }

        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(248, 243, 235, .88);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid var(--line);
        }

        .nav-inner {
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
        }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            background: var(--brown);
            color: var(--cream);
            border-radius: 14px;
            font-family: Georgia, serif;
            font-size: 21px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 26px;
        }

        .nav-links a {
            font-size: 14px;
            font-weight: 650;
            color: var(--muted);
            transition: color .25s ease;
        }

        .nav-links a:hover {
            color: var(--brown-dark);
        }

        .nav-links .nav-cta {
            color: var(--cream);
            background: var(--brown);
            padding: 11px 18px;
            border-radius: 999px;
        }

        .menu-toggle {
            display: none;
            border: 1px solid var(--line);
            color: var(--brown);
            background: var(--white);
            border-radius: 12px;
            padding: 8px 12px;
            cursor: pointer;
        }

        .hero {
            padding: 82px 0 74px;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            align-items: center;
            gap: 64px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--brown);
            background: #efe3d3;
            border: 1px solid #e5d2bc;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 800;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;
            background: #78916b;
            border-radius: 50%;
        }

        h1 {
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(46px, 6vw, 76px);
            line-height: 1.04;
            letter-spacing: -2.8px;
            color: var(--brown-dark);
            margin: 24px 0 20px;
        }

        h1 span {
            color: #a47b58;
            font-style: italic;
        }

        .hero-description {
            max-width: 610px;
            color: var(--muted);
            font-size: 17px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 13px;
            margin-top: 30px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 9px;
            border: 1px solid transparent;
            border-radius: 999px;
            padding: 13px 21px;
            font-weight: 750;
            font-size: 14px;
            cursor: pointer;
            transition: transform .25s, box-shadow .25s;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(81, 58, 44, .15);
        }

        .btn-primary {
            background: var(--brown);
            color: white;
        }

        .btn-outline {
            border-color: #cbb49b;
            color: var(--brown);
            background: transparent;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 35px;
            padding-top: 22px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 13px;
        }

        .hero-meta strong {
            color: var(--brown);
            display: block;
            font-size: 14px;
        }

        .portrait-wrap {
            position: relative;
            max-width: 390px;
            margin: auto;
            width: 100%;
        }

        .portrait-backdrop {
            position: absolute;
            inset: 18px -16px -16px 18px;
            border-radius: 48% 48% 28px 28px;
            background: #e6d1b9;
            transform: rotate(4deg);
        }

        .portrait {
            position: relative;
            min-height: 450px;
            border-radius: 48% 48% 28px 28px;
            overflow: hidden;
            background: linear-gradient(145deg, #dfc7ad, #f2e7d8);
            border: 8px solid rgba(255, 253, 249, .7);
            box-shadow: var(--shadow);
            display: grid;
            place-items: center;
        }

        .portrait img {
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .portrait-placeholder {
            padding: 30px;
            text-align: center;
            color: var(--brown);
        }

        .portrait-placeholder .avatar-icon {
            font-size: 58px;
        }

        .portrait-placeholder strong {
            display: block;
            font-family: Georgia, serif;
            font-size: 25px;
        }

        .portrait-placeholder small {
            color: #786451;
        }

        .floating-note {
            position: absolute;
            bottom: 28px;
            left: -35px;
            background: var(--white);
            padding: 15px 19px;
            border-radius: 18px;
            box-shadow: var(--shadow);
            font-size: 13px;
            animation: float 4s ease-in-out infinite;
        }

        .floating-note strong {
            display: block;
            color: var(--brown);
            font-size: 15px;
        }

        .floating-note span {
            color: var(--muted);
        }

        section {
            padding: 78px 0;
        }

        .section-heading {
            max-width: 660px;
            margin-bottom: 36px;
        }

        .section-kicker {
            color: #9b7553;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 12px;
            font-weight: 850;
            margin-bottom: 10px;
        }

        h2 {
            font-family: Georgia, "Times New Roman", serif;
            color: var(--brown-dark);
            font-size: clamp(34px, 4vw, 48px);
            line-height: 1.15;
            margin-bottom: 14px;
        }

        .section-heading p {
            color: var(--muted);
            margin-bottom: 0;
        }

        .about {
            background: var(--white);
        }

        .about-grid {
            display: grid;
            grid-template-columns: .75fr 1.25fr;
            gap: 55px;
            align-items: start;
        }

        .about-label {
            background: var(--beige);
            border-radius: var(--radius);
            padding: 28px;
        }

        .about-label .big-number {
            font-family: Georgia, serif;
            font-size: 52px;
            color: var(--brown);
            line-height: 1;
        }

        .about-label p,
        .about-copy {
            color: var(--muted);
        }

        .skill-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: 22px;
        }

        .skill-tags span {
            background: var(--cream);
            border: 1px solid var(--line);
            color: var(--brown);
            padding: 8px 13px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .atelier-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .atelier-card {
            display: flex;
            flex-direction: column;
            min-height: 330px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            padding: 25px;
            transition: transform .3s, box-shadow .3s;
        }

        .atelier-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow);
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .card-number {
            color: #a28a74;
            font-size: 12px;
            font-weight: 850;
            letter-spacing: 1.5px;
        }

        .card-icon {
            display: grid;
            place-items: center;
            width: 49px;
            height: 49px;
            border-radius: 16px;
            font-size: 25px;
            color: var(--brown);
        }

        .sage .card-icon { background: #e3e9dc; }
        .rose .card-icon { background: #f2e1dc; }
        .blue .card-icon { background: #dfe8ef; }

        .atelier-card h3 {
            font-family: Georgia, serif;
            font-size: 24px;
            line-height: 1.25;
            color: var(--brown-dark);
            margin-bottom: 12px;
        }

        .atelier-card p {
            color: var(--muted);
            font-size: 14px;
            flex: 1;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--brown);
            font-size: 13px;
            font-weight: 850;
            margin-top: 15px;
        }

        .projects {
            background: #efe4d6;
        }

        .project-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .project-item {
            background: rgba(255, 253, 249, .8);
            border: 1px solid rgba(81, 58, 44, .12);
            padding: 23px;
            border-radius: 20px;
        }

        .project-symbol {
            font-size: 24px;
            margin-bottom: 15px;
        }

        .project-item h3 {
            color: var(--brown);
            font-size: 17px;
        }

        .project-item p {
            color: var(--muted);
            font-size: 13px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: .85fr 1.15fr;
            gap: 55px;
            align-items: start;
        }

        .contact-copy p {
            color: var(--muted);
        }

        .contact-detail {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 22px;
            color: var(--brown);
            font-weight: 700;
        }

        .detail-icon {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            background: var(--beige);
            border-radius: 14px;
        }

        .contact-form {
            background: var(--white);
            padding: 30px;
            border-radius: var(--radius);
            border: 1px solid var(--line);
            box-shadow: var(--shadow);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .field {
            margin-bottom: 17px;
        }

        .field label {
            display: block;
            color: var(--brown);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .field input,
        .field textarea {
            width: 100%;
            border: 1px solid #e1d5c8;
            background: #fdfaf6;
            border-radius: 13px;
            padding: 13px 14px;
            outline: none;
            color: var(--text);
        }

        .field input:focus,
        .field textarea:focus {
            border-color: #9b7553;
            box-shadow: 0 0 0 3px rgba(155, 117, 83, .12);
        }

        .field textarea {
            resize: vertical;
            min-height: 130px;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 12px;
            margin-bottom: 17px;
            font-size: 14px;
        }

        .alert-success {
            background: #e5efdf;
            color: #35552f;
        }

        .alert-error {
            background: #f7e4df;
            color: #8b3024;
        }

        .form-note {
            color: var(--muted);
            font-size: 12px;
            margin: 12px 0 0;
        }

        footer {
            background: var(--brown-dark);
            color: #f8f3eb;
            padding: 27px 0;
        }

        .footer-inner {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .footer-inner p {
            margin: 0;
            font-size: 13px;
            color: #d7c6b5;
        }

        .footer-links {
            display: flex;
            gap: 18px;
            font-size: 13px;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .7s, transform .7s;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-9px); }
        }

        @media (max-width: 850px) {
            .hero-grid {
                grid-template-columns: 1.15fr .85fr;
                gap: 30px;
            }

            .portrait,
            .portrait img {
                min-height: 350px;
                height: 350px;
            }

            .atelier-grid,
            .project-list {
                grid-template-columns: 1fr 1fr;
            }

            .about-grid,
            .contact-grid {
                gap: 28px;
            }
        }

        @media (max-width: 650px) {
            .container {
                width: calc(100% - 28px);
            }

            .menu-toggle {
                display: inline-flex;
            }

            .nav-links {
                display: none;
                position: absolute;
                top: 68px;
                left: 0;
                right: 0;
                padding: 20px;
                background: var(--cream);
                border-bottom: 1px solid var(--line);
                flex-direction: column;
                align-items: stretch;
                gap: 17px;
            }

            .nav-links.open {
                display: flex;
            }

            .nav-links .nav-cta {
                text-align: center;
            }

            .hero {
                padding: 55px 0 50px;
            }

            .hero-grid,
            .about-grid,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .hero-grid {
                gap: 45px;
            }

            h1 {
                font-size: clamp(44px, 13vw, 64px);
                letter-spacing: -1.8px;
            }

            .hero-description {
                font-size: 15px;
            }

            .portrait-wrap {
                max-width: 320px;
            }

            .portrait,
            .portrait img {
                min-height: 350px;
                height: 350px;
            }

            section {
                padding: 58px 0;
            }

            .atelier-grid,
            .project-list,
            .form-row {
                grid-template-columns: 1fr;
            }

            .atelier-card {
                min-height: 290px;
            }

            .contact-form {
                padding: 21px;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation: none !important;
                transition: none !important;
            }

            .reveal {
                opacity: 1;
                transform: none;
            }
        }
    </style>
</head>
<body>

<header class="navbar">
    <div class="container nav-inner">

        <a class="brand" href="#accueil">
            <?php if (is_file(__DIR__ . "/" . $logo)): ?>
                <img src="<?= e($logo) ?>" alt="Logo"
                     style="width:40px;height:40px;object-fit:contain">
            <?php else: ?>
                <span class="brand-mark">H.</span>
            <?php endif; ?>

            <span>Hamida <span style="color:#a47b58">Bouzaiz</span></span>
        </a>

        <button class="menu-toggle" id="menuToggle"
                aria-label="Ouvrir le menu"
                aria-expanded="false">☰</button>

        <nav class="nav-links" id="navLinks">
            <a href="#accueil">Accueil</a>
            <a href="#apropos">À propos</a>
            <a href="#ateliers">Mes ateliers</a>
            <a href="#projets">Projets</a>
            <a class="nav-cta" href="#contact">Me contacter ↗</a>
        </nav>

    </div>
</header>

<main>

    <!-- PAGE D'ACCUEIL -->
    <section class="hero" id="accueil">
        <div class="container hero-grid">

            <div class="reveal">
                <div class="eyebrow">
                    <span class="eyebrow-dot"></span>
                    Portfolio étudiant · 2026
                </div>

                <h1>Bonjour, je suis <span>Hamida.</span></h1>

                <p class="hero-description">
                    Stagiaire à l'ISTIA NTIC Tanger, en deuxième année
                    de formation en
                    <strong>Développement Digital, option Full Stack</strong>.
                    Je construis mes compétences à travers des ateliers
                    pratiques, des projets et l'apprentissage continu.
                </p>

                <div class="hero-actions">
                    <a class="btn btn-primary" href="#ateliers">
                        Découvrir mes ateliers ↘
                    </a>

                    <a class="btn btn-outline" href="#contact">
                        Me contacter ↗
                    </a>
                </div>

                <div class="hero-meta">
                    <div>
                        <strong>ISTIA NTIC</strong>
                        Tanger, Maroc
                    </div>

                    <div>
                        <strong>2ème année</strong>
                        Développement Digital
                    </div>

                    <div>
                        <strong>Full Stack</strong>
                        Formation professionnelle
                    </div>
                </div>
            </div>

            <div class="portrait-wrap reveal">
                <div class="portrait-backdrop"></div>

                <div class="portrait">
                    <?php if (is_file(__DIR__ . "/" . $photo)): ?>

                        <img src="<?= e($photo) ?>"
                             alt="Photo de Hamida Bouzaiz">

                    <?php else: ?>

                        <div class="portrait-placeholder">
                            <div class="avatar-icon">✿</div>
                            <strong>Votre photo ici</strong>
                            <small>
                                Ajoutez votre image :<br>
                                public/images/photo.jpg
                            </small>
                        </div>

                    <?php endif; ?>
                </div>

                <div class="floating-note">
                    <strong>En formation ✨</strong>
                    <span>Apprendre · Créer · Évoluer</span>
                </div>
            </div>

        </div>
    </section>

    <!-- À PROPOS -->
    <section class="about" id="apropos">
        <div class="container about-grid">

            <div class="about-label reveal">
                <div class="big-number">
                    01<span style="color:#a47b58">.</span>
                </div>

                <h3>À propos de moi</h3>

                <p>
                    Un parcours construit autour de la curiosité,
                    de la pratique et de la progression.
                </p>
            </div>

            <div class="about-copy reveal">
                <div class="section-kicker">Qui suis-je ?</div>

                <h2>Apprendre aujourd'hui, construire demain.</h2>

                <p>
                    Je m'appelle Hamida Bouzaiz et je suis stagiaire
                    à l'ISTIA NTIC Tanger. En deuxième année de
                    Développement Digital, option Full Stack, je
                    m'intéresse à la création de sites web, à la
                    gestion de projet et aux outils qui facilitent
                    le travail en équipe.
                </p>

                <p>
                    Ce portfolio rassemble mes ateliers et mes
                    réalisations. Il représente mon évolution,
                    les compétences que je développe et les projets
                    que je souhaite partager.
                </p>

                <div class="skill-tags">
                    <span>Développement web</span>
                    <span>HTML & CSS</span>
                    <span>PHP</span>
                    <span>Gestion de projet</span>
                    <span>Méthode agile</span>
                    <span>Git</span>
                </div>
            </div>

        </div>
    </section>

    <!-- LES ATELIERS -->
    <section id="ateliers">
        <div class="container">

            <div class="section-heading reveal">
                <div class="section-kicker">Mon parcours pratique</div>
                <h2>Mes ateliers</h2>
                <p>
                    Découvrez les ateliers réalisés pendant ma formation
                    et consultez les supports et projets associés.
                </p>
            </div>

            <div class="atelier-grid">

                <?php foreach ($ateliers as $atelier): ?>

                    <article class="atelier-card <?= e($atelier["couleur"]) ?> reveal">

                        <div class="card-top">
                            <span class="card-number">
                                ATELIER <?= e($atelier["numero"]) ?>
                            </span>

                            <span class="card-icon">
                                <?= e($atelier["icone"]) ?>
                            </span>
                        </div>

                        <h3><?= e($atelier["titre"]) ?></h3>

                        <p><?= e($atelier["description"]) ?></p>

                        <a class="card-link"
                           href="<?= e($atelier["dossier"]) ?>/photo1.jpg">
                            Voir l'atelierrrrrrrrrrr →
                        </a>

                    </article>

                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- PROJETS -->
    <section class="projects" id="projets">
        <div class="container">

            <div class="section-heading reveal">
                <div class="section-kicker">Travaux & réalisations</div>
                <h2>Quelques projets à découvrir</h2>
                <p>
                    Retrouvez ici les ateliers et les réalisations
                    effectuées pendant votre formation.
                </p>
            </div>

            <div class="project-list">

                <article class="project-item reveal">
                    <div class="project-symbol">↘</div>
                    <h3>Méthode en cascade</h3>
                    <p>Supports, étapes et documents de l'atelier classique.</p>
                    <a class="card-link" href="atelier1/index.php">
                        Consulter →
                    </a>
                </article>

                <article class="project-item reveal">
                    <div class="project-symbol">✳</div>
                    <h3>Gestion agile</h3>
                    <p>Organisation du projet, user stories et planification du sprint.</p>
                    <a class="card-link" href="atelier2/index.php">
                        Consulter →
                    </a>
                </article>

                <article class="project-item reveal">
                    <div class="project-symbol">⌘</div>
                    <h3>Pratique Git</h3>
                    <p>Exercices et exemples liés à la gestion des versions.</p>
                    <a class="card-link" href="atelier3/index.php">
                        Consulter →
                    </a>
                </article>

            </div>
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact">
        <div class="container contact-grid">

            <div class="contact-copy reveal">
                <div class="section-kicker">Restons en contact</div>

                <h2>Un projet ou une question ?</h2>

                <p>
                    Vous pouvez m'écrire à l'aide du formulaire.
                    Je serai ravie d'échanger avec vous autour
                    de mes projets et de mon parcours.
                </p>

                <a class="contact-detail"
                   href="<?= e($linkedin) ?>"
                   target="_blank"
                   rel="noopener noreferrer">

                    <span class="detail-icon">in</span>
                    <span>Retrouvez-moi sur LinkedIn ↗</span>
                </a>

                <div class="contact-detail">
                    <span class="detail-icon">⌖</span>
                    <span>Tanger, Maroc</span>
                </div>
            </div>

            <form class="contact-form reveal"
                  method="post"
                  action="#contact">

                <?php if ($envoye): ?>
                    <div class="alert alert-success" role="status">
                        Merci <?= e($nomContact) ?> !
                        Le formulaire a bien été validé.
                        <br>
                        Attention : cette version ne transmet pas
                        encore le message par e-mail.
                    </div>
                <?php endif; ?>

                <?php if (!empty($erreurs)): ?>
                    <div class="alert alert-error" role="alert">
                        <?php foreach ($erreurs as $erreur): ?>
                            <div><?= e($erreur) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="form-row">

                    <div class="field">
                        <label for="nom">Votre nom</label>
                        <input id="nom"
                               name="nom"
                               type="text"
                               placeholder="Ex. Sara"
                               value="<?= e($nomContact) ?>"
                               required>
                    </div>

                    <div class="field">
                        <label for="email">Votre e-mail</label>
                        <input id="email"
                               name="email"
                               type="email"
                               placeholder="nom@exemple.com"
                               value="<?= e($emailContact) ?>"
                               required>
                    </div>

                </div>

                <div class="field">
                    <label for="message">Votre message</label>
                    <textarea id="message"
                              name="message"
                              placeholder="Écrivez votre message ici..."
                              required><?= e($messageContact) ?></textarea>
                </div>

                <button class="btn btn-primary"
                        type="submit"
                        name="contact_submit"
                        value="1">
                    Valider le formulaire ↗
                </button>

                <p class="form-note">
                    Le formulaire doit être relié à un service
                    d'e-mail pour transmettre réellement les messages.
                </p>

            </form>
        </div>
    </section>

</main>

<footer>
    <div class="container footer-inner">

        <p>
            © <?= date("Y") ?> Hamida Bouzaiz — Portfolio personnel.
        </p>

        <div class="footer-links">
            <a href="#accueil">Accueil ↑</a>
            <a href="#ateliers">Ateliers</a>
            <a href="<?= e($linkedin) ?>"
               target="_blank"
               rel="noopener noreferrer">
                LinkedIn ↗
            </a>
        </div>

    </div>
</footer>

<script>
    // Menu mobile
    const menuToggle = document.getElementById("menuToggle");
    const navLinks = document.getElementById("navLinks");

    menuToggle.addEventListener("click", () => {
        const ouvert = navLinks.classList.toggle("open");

        menuToggle.setAttribute(
            "aria-expanded",
            String(ouvert)
        );

        menuToggle.textContent = ouvert ? "✕" : "☰";
    });

    navLinks.querySelectorAll("a").forEach((lien) => {
        lien.addEventListener("click", () => {
            navLinks.classList.remove("open");
            menuToggle.setAttribute("aria-expanded", "false");
            menuToggle.textContent = "☰";
        });
    });

    // Animations au défilement
    const elements = document.querySelectorAll(".reveal");

    if ("IntersectionObserver" in window) {
        const observer = new IntersectionObserver((entrees) => {
            entrees.forEach((entree) => {
                if (entree.isIntersecting) {
                    entree.target.classList.add("visible");
                    observer.unobserve(entree.target);
                }
            });
        }, {
            threshold: 0.12
        });

        elements.forEach((element) => {
            observer.observe(element);
        });
    } else {
        elements.forEach((element) => {
            element.classList.add("visible");
        });
    }
</script>

</body>
</html>