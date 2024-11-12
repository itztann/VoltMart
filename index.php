<?php
    require_once 'session.php';
    require_once 'db_connection.php';
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoltMart | Electronics Store</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://css.gg/search.css' rel='stylesheet'>
</head>

<nav class="">
    <div class="sidebar-top">
        <div class="sidebar-img-back">
            <svg xmlns="http://www.w3.org/2000/svg" id="sidebar-back" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="white" d="M20 11v2H8l5.5 5.5l-1.42 1.42L4.16 12l7.92-7.92L13.5 5.5L8 11h12Z"/></svg>
            <img src="mart.png" class="sidebar-logo">
        </div>

        <div class="search">
            <i class="gg-search"></i>
            <input type="text" id="nav-input" placeholder="search items...">
        </div>

        <div class="sidebar-links">
            <a href="index.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="products.php">View products</a>
            <a href="aboutUs.php">About us</a>
            <a href="#" class="dead-links">Cart</a>
            <a href="#" class="dead-links">History</a>
            <a href="#contacts">Contact Us</a>
        </div>
    </div>
    <div class="sidebar-exit">
        <a href="logout.php" class="exit">Exit / Logout</a>
    </div>
</nav>

<body>
    <div class="header-transition">
        <header>
            <div class="header-left">
                <div class="hamburger-menu">
                    <div class="hamburger"></div>
                </div>
                <img src="mart.png" class="voltmart-logo">
            </div>
        </header>
    </div>

    <!-- product showcase -->
    <section class="product-showcase">
        <p>Hello, <?php echo htmlspecialchars($username); ?>!</p>
        <p>Let's shop With VoltMart</p> 
        <video autoplay muted loop playsinline>
            <source src="products images/Microsoft surface 5.mp4" type="video/mp4">
            <!-- <source src="products images/Laptop commercial.mp4" type="video/mp4"> -->
        </video>
    </section>

    <footer id="contacts"> 
        <div class="ftr-txt">
            <!--Instagram-->
            <div class="ftr-ig">
                <div class="ftr-section">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ftr-logo" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="white" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3Z"/></svg>                
                    <p>Instagram</p>
                </div>
                <div class="ig">
                    <a href="https://www.instagram.com/VoltMart/" target="_blank">@VoltMart</a>
                </div>
            </div>

            <!--Whatsapp-->
            <div class="ftr-wa">
                <div class="ftr-section">
                    <svg xmlns="http://www.w3.org/2000/svg" class="ftr-logo" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="white" d="M19.05 4.91A9.816 9.816 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01zm-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.264 8.264 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.183 8.183 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07c0 1.22.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28z"/></svg>
                    <p>Whatsapp</p>
                </div>
                <div class="wa">
                    <div>
                        <p></p>
                        <p>+62 815 3492 8934</p>
                    </div>
                </div>
            </div>

            <!-- VoltMart -->
            <div class="ftr-company">
                <p>Visit VoltMart at:</p>
                <div class="company">
                    <a href="https://voltmart.com/">voltmart.com</a>
                    <div class="ftr-section">
                        <svg xmlns="http://www.w3.org/2000/svg" class="ftr-logo" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="white" d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8A1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.25-1.25M12 7a5 5 0 0 1 5 5a5 5 0 0 1-5 5a5 5 0 0 1-5-5a5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3Z"/></svg>                
                        <a href="https://www.instagram.com/bnccbinus/">@VoltMart</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="ftr-img">
            <img src="mart.png" class="voltmart-logo">
        </div>
    </footer>
    <script src="app.js"></script>
</body>
</html>