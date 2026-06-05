<!-- Top Navbar -->
<nav style="
    background: white;
    border-bottom: 1px solid #e8dfe1;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 997;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

    <!-- Brand -->
    <a href="index.php" style="
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        color: #1a1a1a;
        text-decoration: none;
        letter-spacing: 0.05em;
        font-style: italic;">
        Taja Beauty
    </a>

    <!-- Hamburger Button -->
    <button id="sidebarToggle" style="
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        gap: 5px;
        padding: 5px;">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </button>
</nav>

<!-- Overlay -->
<div id="overlay" style="
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.4);
    z-index: 998;
    backdrop-filter: blur(2px);">
</div>

<!-- Sidebar -->
<div id="sidebar" style="
    position: fixed;
    top: 0; right: -300px;
    width: 280px; height: 100%;
    background: #1a1a1a;
    z-index: 999;
    transition: right 0.35s ease;
    display: flex;
    flex-direction: column;
    padding: 0;">

    <!-- Sidebar Header -->
    <div style="
        padding: 24px 24px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        display: flex;
        justify-content: space-between;
        align-items: center;">
        <span style="
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 1.2rem;
            color: #b76e79;">
            Taja Beauty
        </span>
        <button id="closeBtn" style="
            background: none;
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            width: 32px;
            height: 32px;
            cursor: pointer;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;">
            ✕
        </button>
    </div>

    <!-- Nav Links -->
    <ul style="list-style: none; padding: 20px 0; margin: 0; flex: 1;">
        <li>
            <a href="index.php" style="
                display: block;
                padding: 14px 24px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 0.8rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-family: 'Jost', sans-serif;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                transition: all 0.3s ease;">
                🏠 &nbsp; Home
            </a>
        </li>
        <li>
            <a href="products.php" style="
                display: block;
                padding: 14px 24px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 0.8rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-family: 'Jost', sans-serif;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                transition: all 0.3s ease;">
                🛍️ &nbsp; Products
            </a>
        </li>
        <li>
            <a href="categories.php" style="
                display: block;
                padding: 14px 24px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 0.8rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-family: 'Jost', sans-serif;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                transition: all 0.3s ease;">
                📂 &nbsp; Categories
            </a>
        </li>
        <li>
            <a href="cart.php" style="
                display: block;
                padding: 14px 24px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 0.8rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-family: 'Jost', sans-serif;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                transition: all 0.3s ease;">
                🛒 &nbsp; Cart
            </a>
        </li>
        <li>
            <a href="orders.php" style="
                display: block;
                padding: 14px 24px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 0.8rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-family: 'Jost', sans-serif;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                transition: all 0.3s ease;">
                📦 &nbsp; Orders
            </a>
        </li>
        <li>
            <a href="users.php" style="
                display: block;
                padding: 14px 24px;
                color: rgba(255,255,255,0.8);
                text-decoration: none;
                font-size: 0.8rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-family: 'Jost', sans-serif;
                border-bottom: 1px solid rgba(255,255,255,0.05);
                transition: all 0.3s ease;">
                👥 &nbsp; Users
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer -->
    <div style="padding: 20px 24px; border-top: 1px solid rgba(255,255,255,0.08);">
        <a href="logout.php" style="
            display: block;
            padding: 12px 20px;
            background: rgba(183,110,121,0.15);
            color: #b76e79;
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            font-family: 'Jost', sans-serif;
            text-align: center;
            border: 1px solid rgba(183,110,121,0.3);
            transition: all 0.3s ease;">
            🚪 &nbsp; Logout
        </a>
        <div style="
            text-align: center;
            margin-top: 16px;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.2);
            font-family: 'Jost', sans-serif;">
            © 2026 Taja Beauty
        </div>
    </div>
</div>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>