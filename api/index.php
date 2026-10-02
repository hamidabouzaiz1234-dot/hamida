<?php
declare(strict_types=1);
session_start();

/* ============================================================
   1) CONFIG : modifie uniquement cette partie
   ============================================================ */
$site = [
    'name'    => 'Hamida Bouzaiz',
    'role'    => 'Stagiaire Full Stack',
    'school'  => 'ISTA NTIC Tanger · 2ème année',
    'email'   => 'ton@email.com',   // <-- mets ton vrai email ici
    'tagline' => "Stagiaire en développement Full Stack à l'ISTA NTIC Tanger. Je construis des applications web complètes, du back-end à l'interface.",
    'about'   => "Actuellement en 2ème année de la filière Développement Digital option Web Full Stack à l'ISTA NTIC Tanger. "
               . "Je suis motivée, curieuse et j'apprends en pratiquant : ateliers, projets de groupe et projets personnels.",

    /* --- COMPÉTENCES : ajoute / supprime des lignes --- */
    'skills'  => [
        'HTML5', 'CSS3', 'JavaScript', 'PHP', 'MySQL',
        'Laravel', 'Bootstrap', 'Git / GitHub',
        // 'React', 'Node.js', 'Tailwind CSS',   <-- ajoute ici
    ],

    /* --- ATELIERS : ajoute un bloc [ ... ] pour chaque atelier --- */
    'ateliers' => [
        [
            'title' => 'Atelier 1 : Gestion de projet : Méthodes classiques',
            'date'  => '28/09/2026',
            'desc'  => "Validation des champs, protection contre les failles et envoi d'email.",
            'img'=>'C:\Users\HP\Desktop\portfolio\public\images',
        ],
        [
            'title' => 'Atelier 2 :' ,
            'date'  => '2026',
        ],
        [
            'title' => 'Atelier 3 :',
            'date'  => '2025',
        ],
        // [ 'title' => '...', 'date' => '...', 'desc' => '...', 'tags' => ['...'] ],
    ],

    /* --- PROJETS : ajoute un bloc [ ... ] pour chaque projet --- */
    'projects' => [
        [
            'title' => '#',
            'desc'  =>'#',
            'stack' => '#',
            'url'   => '#',   // lien de la démo
            'code'  => '#',   // lien GitHub
        ],
     
     
    ],

    'socials' => [
        'GitHub'   => 'https://github.com/ton-pseudo',
        'LinkedIn' => 'https://linkedin.com/in/ton-pseudo',
    ],
];

/* ============================================================
   2) LOGIQUE : formulaire de contact
   ============================================================ */
function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$flash = null;
$old   = ['name' => '', 'email' => '', 'message' => ''];

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'name'    => trim($_POST['name'] ?? ''),
        'email'   => trim($_POST['email'] ?? ''),
        'message' => trim($_POST['message'] ?? ''),
    ];

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        $flash = ['error', 'Session expirée. Recharge la page et réessaie.'];
    } elseif (!empty($_POST['website'])) {            // honeypot anti-spam
        $flash = ['ok', 'Message envoyé.'];
    } elseif ($old['name'] === '' || $old['message'] === '' || !filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $flash = ['error', 'Remplis tous les champs avec une adresse email valide.'];
    } else {
        $subject = 'Portfolio : message de ' . str_replace(["\r", "\n"], '', $old['name']);
        $headers = 'From: ' . $site['email'] . "\r\nReply-To: " . $old['email'] . "\r\nContent-Type: text/plain; charset=UTF-8";
        if (@mail($site['email'], $subject, $old['message'], $headers)) {
            $flash = ['ok', 'Message envoyé. Je te réponds rapidement.'];
            $old = ['name' => '', 'email' => '', 'message' => ''];
        } else {
            $flash = ['error', "L'envoi a échoué. Écris-moi directement à " . $site['email'] . '.'];
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@500;700;800&family=JetBrains+Mono:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --bg: #0c1220; --panel: #151d30; --line: #26324d;
      --text: #e8ecf5; --muted: #8f9bb8;
      --accent: #ffb454; --accent-ink: #1a1204;
      --ok: #5fd0a0; --err: #ff7a7a;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; scroll-padding-top: 4.5rem; }
    body { background: var(--bg); color: var(--text); font: 400 1rem/1.7 'Inter', system-ui, sans-serif; }
    a { color: inherit; text-decoration: none; }
    ul { list-style: none; }
    :focus-visible { outline: 2px solid var(--accent); outline-offset: 3px; }

    .wrap { max-width: 1040px; margin: 0 auto; padding: 0 1.5rem; }
    .narrow { max-width: 640px; }
    h1, h2, h3, .brand { font-family: 'Bricolage Grotesque', sans-serif; line-height: 1.15; }
    h2 { font-size: 2rem; margin-bottom: 1.5rem; }
    section { padding: 5rem 1.5rem 2rem; }

    /* Navigation */
    .top { position: sticky; top: 0; z-index: 10; background: rgba(12,18,32,.88); backdrop-filter: blur(8px); border-bottom: 1px solid var(--line); }
    .top nav { display: flex; justify-content: space-between; align-items: center; padding-block: 1rem; }
    .brand { font-weight: 800; font-size: 1.15rem; }
    .top ul { display: flex; gap: 1.5rem; color: var(--muted); font-size: .95rem; }
    .top ul a:hover { color: var(--text); }

    /* Hero */
    .hero { display: grid; grid-template-columns: 1.2fr 1fr; gap: 3rem; align-items: center; min-height: calc(100vh - 4rem); }
    .school { font: 500 .85rem 'JetBrains Mono', monospace; color: var(--accent); margin-bottom: 1rem; }
    .hero h1 { font-size: clamp(2.2rem, 5vw, 3.6rem); font-weight: 800; letter-spacing: -.02em; }
    .lead { color: var(--muted); font-size: 1.1rem; max-width: 34rem; margin: 1.25rem 0 2rem; }
    .actions { display: flex; gap: .8rem; flex-wrap: wrap; }
    .btn { display: inline-block; padding: .75rem 1.5rem; border-radius: 6px; border: 1px solid var(--accent); background: var(--accent); color: var(--accent-ink); font: 700 .95rem 'Inter', sans-serif; cursor: pointer; transition: transform .15s; }
    .btn:hover { transform: translateY(-2px); }
    .btn.ghost { background: transparent; color: var(--text); border-color: var(--line); }

    /* Carte code */
    .code { background: var(--panel); border: 1px solid var(--line); border-radius: 8px; padding: 1.5rem; overflow-x: auto; font: 400 .9rem/1.8 'JetBrains Mono', monospace; }
    .code .c { color: #62708f; } .code .k { color: var(--accent); }
    .code .s { color: #8fc7ff; } .code .v { color: var(--ok); }

    /* À propos */
    .about { display: grid; grid-template-columns: 1.3fr 1fr; gap: 2.5rem; align-items: start; }
    .about p { color: var(--muted); max-width: 38rem; }
    .skills { display: flex; flex-wrap: wrap; gap: .5rem; }
    .skills li, .tags li { font: 500 .8rem 'JetBrains Mono', monospace; padding: .3rem .7rem; border: 1px solid var(--line); border-radius: 4px; }
    .tags { display: flex; flex-wrap: wrap; gap: .4rem; }

    /* Ateliers (liste chronologique) */
    .ateliers { border-left: 2px solid var(--line); }
    .atelier { position: relative; padding: 0 0 1.8rem 1.8rem; }
    .atelier::before { content: ''; position: absolute; left: -7px; top: .5rem; width: 12px; height: 12px; border-radius: 50%; background: var(--accent); }
    .atelier time { font: 500 .8rem 'JetBrains Mono', monospace; color: var(--muted); }
    .atelier h3 { font-size: 1.2rem; margin: .2rem 0 .3rem; }
    .atelier p { color: var(--muted); font-size: .95rem; margin-bottom: .6rem; max-width: 40rem; }

    /* Projets */
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
    .card { background: var(--panel); border: 1px solid var(--line); border-radius: 8px; padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }
    .card h3 { font-size: 1.3rem; }
    .card > p { color: var(--muted); font-size: .95rem; }
    .card .tags { margin-top: auto; }
    .links { display: flex; gap: 1.2rem; font-weight: 500; }
    .links a { color: var(--accent); border-bottom: 1px solid transparent; }
    .links a:hover { border-color: var(--accent); }

    /* Contact */
    form { display: grid; gap: 1.1rem; }
    label { display: grid; gap: .4rem; color: var(--muted); font-size: .9rem; }
    input, textarea { width: 100%; padding: .8rem .9rem; background: var(--panel); border: 1px solid var(--line); border-radius: 6px; color: var(--text); font: inherit; }
    input:focus, textarea:focus { outline: none; border-color: var(--accent); }
    .hp { position: absolute; left: -9999px; }
    .flash { padding: .8rem 1rem; border-radius: 6px; margin-bottom: 1.2rem; border: 1px solid; }
    .flash.ok { color: var(--ok); border-color: var(--ok); }
    .flash.error { color: var(--err); border-color: var(--err); }

    /* Footer */
    footer { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-top: 5rem; padding-block: 2rem; border-top: 1px solid var(--line); color: var(--muted); font-size: .9rem; }
    footer a { margin-left: 1rem; }
    footer a:hover { color: var(--text); }

    @media (max-width: 800px) {
      .hero, .about { grid-template-columns: 1fr; }
      .hero { min-height: auto; padding-top: 3rem; }
      .top ul { gap: .8rem; font-size: .8rem; }
      .brand { font-size: 1rem; }
    }
    @media (prefers-reduced-motion: reduce) {
      html { scroll-behavior: auto; }
      .btn { transition: none; }
    }
  </style>
</head>
<body>

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
  <span class="s">'stack'</span>  =&gt; [<?= implode(', ', array_map(fn($s) => "<span class=\"v\">'" . e($s) . "'</span>", array_slice($site['skills'], 0, 3))) ?>],
  <span class="s">'dispo'</span>  =&gt; <span class="v">true</span>,
];</code></pre>
  </section>

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

  <section id="ateliers" class="wrap">
    <h2>Ateliers</h2>
    <div class="ateliers">
      <?php foreach ($site['ateliers'] as $a): ?>
        <article class="atelier">
          <time><?= e($a['date']) ?></time>
          <h3><?= e($a['title']) ?></h3>
          <p><?= e($a['desc']) ?></p>
          <ul class="tags">
            <?php foreach ($a['tags'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
          </ul>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="projects" class="wrap">
    <h2>Projets</h2>
    <div class="grid">
      <?php foreach ($site['projects'] as $p): ?>
        <article class="card">
          <h3><?= e($p['title']) ?></h3>
          <p><?= e($p['desc']) ?></p>
          <ul class="tags">
            <?php foreach ($p['stack'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
          </ul>
          <p class="links">
            <a href="<?= e($p['url']) ?>">Démo</a>
            <a href="<?= e($p['code']) ?>">Code source</a>
          </p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section id="contact" class="wrap narrow">
    <h2>Contact</h2>
    <?php if ($flash): ?>
      <p class="flash <?= $flash[0] ?>" role="status"><?= e($flash[1]) ?></p>
    <?php endif; ?>

    <form method="post" action="#contact">
      <input type="hidden" name="csrf" value="<?= e($_SESSION['csrf']) ?>">
      <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" aria-hidden="true">
      <label>Nom
        <input type="text" name="name" value="<?= e($old['name']) ?>" required>
      </label>
      <label>Email
        <input type="email" name="email" value="<?= e($old['email']) ?>" required>
      </label>
      <label>Message
        <textarea name="message" rows="5" required><?= e($old['message']) ?></textarea>
      </label>
      <button class="btn" type="submit">Envoyer le message</button>
    </form>
  </section>
</main>

<footer class="wrap">
  <p>&copy; <?= date('Y') ?> <?= e($site['name']) ?></p>
  <p>
    <?php foreach ($site['socials'] as $label => $url): ?>
      <a href="<?= e($url) ?>" target="_blank" rel="noopener"><?= e($label) ?></a>
    <?php endforeach; ?>
  </p>
</footer>

</body>
</html>