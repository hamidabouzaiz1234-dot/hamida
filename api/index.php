<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portfolio - Mon Projet</title>
  <style>
    /* Global & Variables */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    :root {
      --bg-main: #0f172a;
      --bg-card: #1e293b;
      --accent: #38bdf8;
      --accent-hover: #0284c7;
      --text: #f8fafc;
      --text-muted: #94a3b8;
      --border: #334155;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      background-color: var(--bg-main);
      color: var(--text);
      line-height: 1.6;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    /* Navigation */
    header {
      position: fixed;
      top: 0;
      width: 100%;
      background-color: rgba(15, 23, 42, 0.85);
      backdrop-filter: blur(8px);
      border-bottom: 1px solid var(--border);
      z-index: 1000;
    }

    nav {
      max-width: 1100px;
      margin: 0 auto;
      padding: 1.2rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .logo {
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--accent);
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      list-style: none;
    }

    .nav-links a:hover {
      color: var(--accent);
      transition: color 0.3s;
    }

    /* Structures de section */
    section {
      padding: 6rem 2rem 4rem;
      max-width: 1100px;
      margin: 0 auto;
    }

    .section-title {
      font-size: 2rem;
      margin-bottom: 2.5rem;
      text-align: center;
      position: relative;
    }

    .section-title::after {
      content: '';
      display: block;
      width: 60px;
      height: 4px;
      background: var(--accent);
      margin: 0.5rem auto 0;
      border-radius: 2px;
    }

    /* Section Accueil (Hero) */
    .hero {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
    }

    .hero h1 {
      font-size: 3.5rem;
      line-height: 1.2;
      margin-bottom: 1rem;
    }

    .hero h1 span {
      color: var(--accent);
    }

    .hero p {
      font-size: 1.2rem;
      color: var(--text-muted);
      max-width: 600px;
      margin-bottom: 2rem;
    }

    .btn {
      display: inline-block;
      padding: 0.8rem 1.8rem;
      background-color: var(--accent);
      color: #0f172a;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .btn:hover {
      background-color: var(--accent-hover);
      color: #ffffff;
      transform: translateY(-2px);
    }

    /* Section À Propos */
    .about-box {
      background-color: var(--bg-card);
      border: 1px solid var(--border);
      padding: 2.5rem;
      border-radius: 12px;
    }

    .skills {
      display: flex;
      flex-wrap: wrap;
      gap: 0.8rem;
      margin-top: 1.5rem;
    }

    .skill-tag {
      background-color: rgba(56, 189, 248, 0.1);
      border: 1px solid var(--accent);
      color: var(--accent);
      padding: 0.4rem 1rem;
      border-radius: 20px;
      font-size: 0.9rem;
    }

    /* Section Projets */
    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .project-card {
      background-color: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 12px;
      overflow: hidden;
      transition: transform 0.3s, border-color 0.3s;
    }

    .project-card:hover {
      transform: translateY(-5px);
      border-color: var(--accent);
    }

    .project-img {
      width: 100%;
      height: 180px;
      background-color: #334155;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--text-muted);
      font-weight: 600;
    }

    .project-info {
      padding: 1.5rem;
    }

    .project-info h3 {
      margin-bottom: 0.5rem;
    }

    .project-info p {
      color: var(--text-muted);
      font-size: 0.95rem;
      margin-bottom: 1.2rem;
    }

    .project-link {
      color: var(--accent);
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }

    /* Section Contact */
    .contact-form {
      max-width: 600px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    .form-group input,
    .form-group textarea {
      width: 100%;
      padding: 0.9rem;
      background-color: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: 8px;
      color: var(--text);
      font-size: 1rem;
    }

    .form-group input:focus,
    .form-group textarea:focus {
      outline: none;
      border-color: var(--accent);
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 2rem;
      border-top: 1px solid var(--border);
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    /* Adaptations Mobile */
    @media (max-width: 768px) {
      .hero h1 { font-size: 2.5rem; }
      .nav-links { gap: 1rem; font-size: 0.9rem; }
      section { padding-top: 5rem; }
    }
  </style>
</head>
<body>

  <!-- Navigation -->
  <header>
    <nav>
      <div class="logo">Portfolio.</div>
      <ul class="nav-links">
        <li><a href="#hero">Accueil</a></li>
        <li><a href="#about">À propos</a></li>
        <li><a href="#projects">Projets</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section id="hero" class="hero">
    <h1>Bonjour, je suis <br><span>[Ton Prénom]</span>.</h1>
    <p>Développeur Web / Créateur de projets. Bienvenue sur mon portfolio où je présente mes réalisations et compétences.</p>
    <a href="#projects" class="btn">Voir mes projets</a>
  </section>

  <!-- À Propos -->
  <section id="about">
    <h2 class="section-title">À propos</h2>
    <div class="about-box">
      <p>Passiomé par la technologie et le développement, je conçois des applications web modernes, rapides et adaptées à tous les écrans (responsive design).</p>
      
      <div class="skills">
        <span class="skill-tag">HTML5</span>
        <span class="skill-tag">CSS3</span>
        <span class="skill-tag">JavaScript</span>
        <span class="skill-tag">Git / GitHub</span>
        <span class="skill-tag">Responsive Design</span>
      </div>
    </div>
  </section>

  <!-- Projets -->
  <section id="projects">
    <h2 class="section-title">Mes Projets</h2>
    <div class="projects-grid">
      
      <!-- Carte Projet 1 -->
      <div class="project-card">
        <div class="project-img">[ Image / Aperçu ]</div>
        <div class="project-info">
          <h3>Nom du Projet 1</h3>
          <p>Courte description du projet, ses objectifs et les technologies utilisées pour le concevoir.</p>
          <a href="#" class="project-link">Découvrir le projet &rarr;</a>
        </div>
      </div>

      <!-- Carte Projet 2 -->
      <div class="project-card">
        <div class="project-img">[ Image / Aperçu ]</div>
        <div class="project-info">
          <h3>Nom du Projet 2</h3>
          <p>Courte description du projet, ses objectifs et les technologies utilisées pour le concevoir.</p>
          <a href="#" class="project-link">Découvrir le projet &rarr;</a>
        </div>
      </div>

      <!-- Carte Projet 3 -->
      <div class="project-card">
        <div class="project-img">[ Image / Aperçu ]</div>
        <div class="project-info">
          <h3>Nom du Projet 3</h3>
          <p>Courte description du projet, ses objectifs et les technologies utilisées pour le concevoir.</p>
          <a href="#" class="project-link">Découvrir le projet &rarr;</a>
        </div>
      </div>

    </div>
  </section>

  <!-- Contact -->
  <section id="contact">
    <h2 class="section-title">Me Contacter</h2>
    <form class="contact-form" action="#" method="POST">
      <div class="form-group">
        <input type="text" placeholder="Votre nom" required>
      </div>
      <div class="form-group">
        <input type="email" placeholder="Votre adresse email" required>
      </div>
      <div class="form-group">
        <textarea rows="5" placeholder="Votre message..." required></textarea>
      </div>
      <button type="submit" class="btn" style="border: none; cursor: pointer; width: 100%;">Envoyer le message</button>
    </form>
  </section>

  <!-- Pied de page -->
  <footer>
    <p>&copy; 2026 [Ton Nom]. Tous droits réservés.</p>
  </footer>

</body>
</html>