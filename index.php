<?php
session_start();
require 'db.php';  // include database connection

// Handle registration
if (isset($_POST['register'])) {
    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare(
        "INSERT INTO users (username, password, email, first_name, last_name, dob)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        'ssssss',
        $_POST['username'],
        $hashed,
        $_POST['email'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['dob']
    );
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['first_name'] = $_POST['first_name'];
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = [
            'first_name' => $_POST['first_name'],
            'username' => $_POST['username']
        ];
    } else {
        $error = "Registration failed: " . $stmt->error;
    }
    $stmt->close();
}

// Handle login
if (isset($_POST['login'])) {
    $stmt = $mysqli->prepare(
        "SELECT id, username, password, first_name FROM users WHERE username = ?"
    );
    $stmt->bind_param('s', $_POST['login_username']);
    $stmt->execute();
    $stmt->bind_result($id, $username, $passwordHash, $firstName);
    if ($stmt->fetch() && password_verify($_POST['login_password'], $passwordHash)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = [
            'first_name' => $firstName,
            'username' => $username
        ];
    } else {
        $error = "Invalid credentials.";
    }
    $stmt->close();
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>LantawBaka Cow Welfare Awareness Campaign</title>
    <style>
        body {
            background-color:rgb(236, 236, 236);
        }
        .hero {
            background-image: url('baka.jpg');
            background-size: cover;
            background-position: center;
            padding: 60px 20px;
        }
        .testimonial-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            margin: 10px 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<header>
    <div class="site-title">LantawBaka Cow Welfare Awareness Campaign</div>
    <nav class="navigation">
        <a href="#about">About</a>
        <a href="#join">Join</a>
        <a href="#contact">Contact</a>
    </nav>
    <div class="auth-container">
        <?php if (empty($_SESSION['logged_in'])): ?>
            <form class="sign-in-form" method="POST">
                <input type="text" name="login_username" placeholder="Username" required>
                <input type="password" name="login_password" placeholder="Password" required>
                <button type="submit" name="login">Sign In</button>
            </form>
        <?php else: ?>
            <div class="user-info">
                <p>Hello, <strong><?= htmlspecialchars($_SESSION['first_name']) ?></strong></p>
                <form method="POST">
                    <button type="submit" name="logout">Log Out</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</header>

<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<main>
    <section class="hero">
        <h1>Stand for Ethical Farming</h1>
        <p>Support humane treatment of cows and learn how you can help.</p>
        <p>
            At <strong>LantawBaka</strong>, we fight for responsible agriculture and compassion in animal care. 
            Together, we can reduce cruelty and support sustainable practices.
        </p>
        <ul>
            <li>Learn the truth about cow welfare in livestock industries</li>
            <li>Access free education and action guides</li>
            <li>Be part of online and in-person campaigns</li>
            <li>Get updates on laws, ethics, and green farming</li>
        </ul>
        <a href="#join"><button>Join the Cause</button></a>
    </section>

    <section class="section" id="about">
        <h2>Why Cow Welfare?</h2>
        <p>
            Cows are often subjected to poor conditions in industrial farming. Promoting ethical treatment not only improves animal lives 
            but supports better food quality, sustainability, and global well-being.
        </p>
    </section>

    <section class="section" id="testimonials">
        <h2>What Supporters Say</h2>
        <div class="testimonial-card">
            <blockquote>
                “Joining LantawBaka opened my eyes to how small changes in farming practices can make a huge difference for animal welfare.”  
                <cite>— Aria C.</cite>
            </blockquote>
        </div>
        <div class="testimonial-card">
            <blockquote>
                “I attended their workshop and now I only buy pasture-raised dairy. It’s so worth it!”  
                <cite>— Leo T.</cite>
            </blockquote>
        </div>
        <div class="testimonial-card">
            <blockquote>
                “The resources and community support here are top-notch. Proud to be part of LantawBaka!”  
                <cite>— Maya R.</cite>
            </blockquote>
        </div>
    </section>

    <section class="section" id="join">
        <?php if (empty($_SESSION['logged_in'])): ?>
            <h2>Register to Join</h2>
            <form method="POST" class="register-form">
                <input type="text" name="first_name" placeholder="First Name" required>
                <input type="text" name="last_name" placeholder="Last Name" required>
                <input type="date" name="dob" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="register">Join Now</button>
            </form>
        <?php else: ?>
            <h2>Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?>!</h2>
            <p>You're now part of the movement. Your username: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></p>
        <?php endif; ?>
    </section>

    <?php if (!empty($_SESSION['logged_in'])): ?>
    <section class="section" id="member-area">
        <h2>Member Dashboard</h2>
        <p>Thanks for being part of the campaign, <?= htmlspecialchars($_SESSION['first_name']) ?>!</p>
        <ul>
            <li>📚 Access exclusive learning materials</li>
            <li>📢 Submit ideas for awareness campaigns</li>
            <li>🗓️ RSVP to upcoming community events</li>
        </ul>
        <a href="resources.php"><button>Explore Resources</button></a>
    </section>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 LantawBaka Cow Welfare Awareness Campaign | <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a></p>
</footer>

</body>
</html>
