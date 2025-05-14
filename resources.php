<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resources | LantawBaka Campaign</title>
    <link rel="stylesheet" href="css/resources.css">
</head>
<body>

<header>
    <div class="site-title">LantawBaka Cow Welfare Awareness Campaign</div>
    <nav class="navigation">
        <a href="index.php">Home</a>
        <a href="resources.php">Resources</a>
        <?php if (!empty($_SESSION['logged_in'])): ?>
            <span class="user-greeting">Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?>!</span>
            <form method="POST" action="index.php" class="logout-form">
                <button type="submit" name="logout">Log Out</button>
            </form>
        <?php else: ?>
            <a href="index.php#join">Join</a>
        <?php endif; ?>
    </nav>
</header>

<main class="main-content">
    <h1>Educational Resources</h1>
    <p>Empower yourself with information. Here are downloadable guides, videos, and links to help spread awareness and take action for cow welfare.</p>

    <div class="resource-grid">
        <div class="resource-card">
            <h2>🐮 Ethical Farming PDF</h2>
            <p>Download our guide on ethical farming practices and how you can help promote them.</p>
            <a href="downloads/ethical_farming_guide.pdf" target="_blank">Download PDF</a>
        </div>
        <div class="resource-card">
            <h2>📺 Video: Why Cow Welfare Matters</h2>
            <p>A short documentary on the conditions of industrial cattle farms and how we can do better.</p>
            <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Watch on YouTube</a>
        </div>
        <div class="resource-card">
            <h2>🌱 Sustainable Diet Tips</h2>
            <p>Learn how shifting your diet helps reduce animal suffering and environmental impact.</p>
            <a href="downloads/sustainable_diet_tips.pdf" target="_blank">Download PDF</a>
        </div>
        <div class="resource-card">
            <h2>🌐 Partner Organizations</h2>
            <p>Connect with other global initiatives promoting animal rights and ethical agriculture.</p>
            <a href="https://www.aspca.org/" target="_blank">Visit ASPCA</a>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2025 LantawBaka | <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a></p>
</footer>

</body>
</html>
