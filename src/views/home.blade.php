<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVB - Modern MVC Framework</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #9b59b6;
            --accent: #e74c3c;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --gray: #95a5a6;
            --success: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header & Navigation */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .logo span {
            color: var(--secondary);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            display: inline-block;
            padding: 10px 25px;
            background-color: var(--primary);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Hero Section */
        .hero {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            text-align: center;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .hero .btn {
            background-color: white;
            color: var(--primary);
        }

        .hero .btn:hover {
            background-color: var(--light);
        }

        .hero .btn-outline {
            background-color: transparent;
            border: 2px solid white;
            color: white;
        }

        .hero .btn-outline:hover {
            background-color: white;
            color: var(--primary);
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .feature-card {
            background-color: var(--light);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
        }

        /* Code Example */
        .code-example {
            padding: 100px 0;
            background-color: var(--dark);
            color: white;
        }

        .code-container {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
        }

        .code-content {
            flex: 1;
            min-width: 300px;
        }

        .code-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .code-content p {
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .code-block {
            flex: 1;
            min-width: 300px;
            background-color: #1e272e;
            border-radius: 10px;
            overflow: hidden;
        }

        .code-header {
            background-color: #2d3436;
            padding: 15px 20px;
            display: flex;
            align-items: center;
        }

        .code-dots {
            display: flex;
            gap: 8px;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dot.red {
            background-color: #ff5f56;
        }

        .dot.yellow {
            background-color: #ffbd2e;
        }

        .dot.green {
            background-color: #27ca3f;
        }

        .code-body {
            padding: 25px;
            font-family: 'Courier New', monospace;
            line-height: 1.8;
        }

        .code-comment {
            color: #5c6370;
        }

        .code-keyword {
            color: #c678dd;
        }

        .code-function {
            color: #61afef;
        }

        .code-string {
            color: #98c379;
        }

        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta p {
            max-width: 700px;
            margin: 0 auto 40px;
            font-size: 1.2rem;
        }

        /* Footer */
        footer {
            background-color: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 15px 0;
            }

            .nav-links {
                margin-top: 20px;
            }

            .nav-links li {
                margin: 0 10px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .hero-buttons .btn {
                width: 100%;
                max-width: 300px;
                margin-bottom: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">MV<span>B</span></div>
                <ul class="nav-links">
                    <li><a href="#features">Features</a></li>
                    <li><a href="#docs">Documentation</a></li>
                    <li><a href="#examples">Examples</a></li>
                    <li><a href="#community">Community</a></li>
                </ul>
                <a href="#" class="btn">Get Started</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>The Modern MVC Framework</h1>
            <p>MVB is an elegant, expressive framework for building modern web applications. With a familiar
                Laravel-like syntax, it makes development a pleasure while being incredibly powerful.</p>
            <div class="hero-buttons">
                <a href="#" class="btn">Get Started</a>
                <a href="#" class="btn btn-outline">View on GitHub</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Powerful Features</h2>
                <p>MVB comes with everything you need to build modern, robust web applications.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3>Blazing Fast</h3>
                    <p>Optimized for performance with a lightweight core and efficient routing system.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3>Eloquent ORM</h3>
                    <p>Beautiful, simple ActiveRecord implementation for working with your database.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h3>Simple Authentication</h3>
                    <p>Built-in authentication system that's secure and easy to implement.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-code"></i>
                    </div>
                    <h3>Expressive Syntax</h3>
                    <p>Clean, readable code that makes development enjoyable and maintainable.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Powerful Tools</h3>
                    <p>Command-line tools, task scheduling, and more to streamline your workflow.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Security First</h3>
                    <p>Built-in protection against common vulnerabilities like SQL injection and XSS.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Example -->
    <section class="code-example" id="examples">
        <div class="container">
            <div class="code-container">
                <div class="code-content">
                    <h2>Elegant Syntax</h2>
                    <p>MVB's expressive, beautiful syntax allows you to write clean, readable code that's a pleasure to
                        work with. Enjoy features like routing, middleware, and Eloquent ORM with an intuitive API.</p>
                    <a href="#" class="btn">Explore Documentation</a>
                </div>
                <div class="code-block">
                    <div class="code-header">
                        <div class="code-dots">
                            <div class="dot red"></div>
                            <div class="dot yellow"></div>
                            <div class="dot green"></div>
                        </div>
                    </div>
                    <div class="code-body">
                        <p><span class="code-comment">// Define a simple route</span></p>
                        <p><span class="code-keyword">Route</span>.<span class="code-function">resource</span>(<span
                                class="code-string">'/posts'</span>, <span
                                class="code-function">PostController::class</span>);
                        </p>
                        <br>
                        <p><span class="code-comment">// Eloquent model example</span></p>
                        <p><span class="code-keyword">class</span> Post <span class="code-keyword">extends</span> Model
                            {</p>

                        <p>}</p>
                        <p><span class="code-comment">// Simple controller example</span></p>
                        <p><span class="code-keyword">class</span> <span class="code-function">HomeController</span></p>
                        <p>{</p>
                        <p>&nbsp;&nbsp;<span class="code-keyword">public function</span> <span
                                class="code-function">index</span>()</p>
                        <p>&nbsp;&nbsp;{</p>
                        <p>&nbsp;&nbsp;&nbsp;&nbsp;<span class="code-keyword">return</span> <span
                                class="code-variable">$this</span>-><span class="code-function">view</span>(<span
                                class="code-string">'home'</span>);</p>
                        <p>&nbsp;&nbsp;}</p>
                        <p>}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Get Started?</h2>
            <p>Join thousands of developers building amazing applications with MVB. Installation is quick and easy.</p>
            <a href="#" class="btn">Install MVB</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>MVB</h3>
                    <p>The modern MVC framework for web artisans.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-github"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-discord"></i></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul class="footer-links">
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Tutorials</a></li>
                        <li><a href="#">API Reference</a></li>
                        <li><a href="#">Release Notes</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Community</h3>
                    <ul class="footer-links">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Forums</a></li>
                        <li><a href="#">Discord</a></li>
                        <li><a href="#">Twitter</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Legal</h3>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">License</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 2R technolgy team. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple script for smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>
