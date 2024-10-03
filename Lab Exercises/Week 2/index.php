<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Profile</title>
    <link rel="stylesheet" href="styles.css" />
    <script src="index.js"></script>
  </head>
  <body>
    <button onclick="collapse()">Collapse Sections</button>
    <button onclick="changeIcon()">Change Icon</button>
    <div class="personal-info">
      <div>
        <img
          id="male-img"
          src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png"
        />
        <img
          id="female-img"
          src="https://cdn-icons-png.flaticon.com/512/3135/3135789.png"
        />
      </div>
      <div class="contact-info">
        <h1>Luke Gilbert</h1>
        <ul>
          <li>Structural Engineer</li>
          <li>Will Rudd Davidson</li>
          <li>Glasgow</li>
          <li>Email: lukegilbert.416@gmail.com</li>
          <li>Mobile: 01234 567 890</li>
        </ul>
      </div>
    </div>
    <div id="page-1">
      <h2>Overview</h2>
      <p>
        Overall, I am a dedicated structural engineer with a diverse portfolio
        of projects and a growing interest in technology. I am committed to
        contributing to the advancement of the field and delivering innovative
        solutions that meet the needs of my clients.
      </p>
      <h2>Engineering</h2>
      <p>
        I am a structural engineer with a strong foundation in steel, concrete,
        and timber structures. Throughout my career, I have worked on a variety
        of projects across the retail, commercial, and education sectors. My
        experience includes designing and analyzing shopping malls,
        supermarkets, office buildings, warehouses, schools, and universities.
        In each project, I have focused on ensuring structural stability,
        load-bearing capacity, safety, accessibility, and durability.
      </p>
      <h2>Tech Interests</h2>
      <p>
        In addition to my core structural engineering skills, I am also
        interested in the intersection of technology and construction. I am
        particularly drawn to web development and its potential to improve
        efficiency and collaboration within the engineering field. I am
        exploring the possibilities of utilizing web-based tools and platforms
        to streamline design processes, facilitate data management, and enhance
        communication among project stakeholders.
      </p>
    </div>
    <div id="page-2">
      <h2>Overview</h2>
      <h2>Engineering</h2>
      <h2>Tech Interests</h2>
    </div>

    <?php 
      include "script.php";
    ?>
  </body>
</html>
