<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MVB Framework - Modern PHP Framework by 2r Technology</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary: #2c5aa0;
            --secondary: #1a365d;
            --accent: #4299e1;
            --light: #f7fafc;
            --dark: #2d3748;
            --success: #48bb78;
            --warning: #ed8936;
            --danger: #f56565;
            --gray: #718096;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
            z-index: 1000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
        }

        .navbar.scrolled {
            padding: 0.7rem 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 0.5rem;
            font-size: 1.8rem;
        }

        .logo span {
            color: var(--secondary);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            transition: var(--transition);
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: var(--transition);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--dark);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 0 1rem;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.1"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 800px;
            z-index: 1;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            font-weight: 800;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .tech-badge {
            display: inline-block;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            margin: 0 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            background-color: var(--accent);
            color: white;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-outline {
            background-color: transparent;
            border: 2px solid white;
            margin-left: 1rem;
        }

        .btn-outline:hover {
            background-color: white;
            color: var(--primary);
        }

        /* Features Section */
        .section {
            padding: 5rem 2rem;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .section-title p {
            color: var(--gray);
            max-width: 600px;
            margin: 0 auto;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background-color: rgba(44, 90, 160, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.8rem;
            color: var(--primary);
        }

        .feature-card h3 {
            margin-bottom: 1rem;
            color: var(--secondary);
        }

        /* Components Showcase */
        .components {
            background-color: #f8f9fa;
        }

        .component-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .component-card {
            background-color: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
        }

        .component-card h3 {
            margin-bottom: 1rem;
            color: var(--secondary);
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
        }

        .code-block {
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 1rem;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            margin: 1rem 0;
            overflow-x: auto;
        }

        .code-comment {
            color: #a0aec0;
        }

        .code-keyword {
            color: #63b3ed;
        }

        .code-string {
            color: #68d391;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: var(--primary);
        }

        .btn-secondary {
            background-color: var(--secondary);
        }

        .btn-success {
            background-color: var(--success);
        }

        .btn-warning {
            background-color: var(--warning);
        }

        .btn-danger {
            background-color: var(--danger);
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.2);
        }

        .alert {
            padding: 0.8rem 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: rgba(72, 187, 120, 0.1);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-warning {
            background-color: rgba(237, 137, 54, 0.1);
            color: #c05621;
            border-left: 4px solid var(--warning);
        }

        .alert-danger {
            background-color: rgba(245, 101, 101, 0.1);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* Comparison Section */
        .comparison {
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
        }

        .comparison .section-title h2,
        .comparison .section-title p {
            color: white;
        }

        .comparison-table {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-header {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            background-color: var(--secondary);
            color: white;
            font-weight: 600;
        }

        .table-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            border-bottom: 1px solid #eee;
        }

        .table-cell {
            padding: 1rem;
            display: flex;
            align-items: center;
        }

        .table-cell:not(:first-child) {
            justify-content: center;
        }

        .check {
            color: var(--success);
            font-size: 1.2rem;
        }

        .times {
            color: var(--danger);
            font-size: 1.2rem;
        }

        /* CTA Section */
        .cta {
            text-align: center;
            background-color: var(--secondary);
            color: white;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta p {
            max-width: 600px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }

        /* Footer */
        .footer {
            background-color: var(--dark);
            color: white;
            padding: 3rem 2rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            text-align: left;
        }

        .footer-column h3 {
            margin-bottom: 1.5rem;
            color: var(--accent);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: white;
        }

        .company-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .company-logo {
            font-size: 2rem;
            margin-right: 1rem;
            color: var(--accent);
        }

        .copyright {
            margin-top: 3rem;
            padding-top: 1.5rem;
            border-top: 1px solid #495057;
            text-align: center;
            color: #adb5bd;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .nav-links {
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                background-color: white;
                flex-direction: column;
                align-items: center;
                padding: 2rem 0;
                box-shadow: var(--shadow);
                transform: translateY(-100%);
                opacity: 0;
                transition: var(--transition);
                z-index: 999;
            }

            .nav-links.active {
                transform: translateY(0);
                opacity: 1;
            }

            .nav-links li {
                margin: 1rem 0;
            }

            .mobile-menu-btn {
                display: block;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }

            .btn-outline {
                margin-left: 0;
            }

            .table-header,
            .table-row {
                grid-template-columns: 1fr;
            }

            .table-cell:not(:first-child) {
                justify-content: flex-start;
            }

            .table-cell::before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 1rem;
                min-width: 100px;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <a href="#" class="logo">
            <i class="fas fa-cube"></i>
            MVB<span>Framework</span>
        </a>
        <button class="mobile-menu-btn">☰</button>
        <ul class="nav-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#components">Code Examples</a></li>
            <li><a href="#comparison">Why MVB?</a></li>
            <li><a href="#documentation">Documentation</a></li>
            <li><a href="#" class="btn btn-primary btn-small">Get Started</a></li>
        </ul>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>MVB PHP Framework</h1>
            <p>Modern, lightweight PHP framework by <strong>2r Technology</strong> for building robust web applications
                faster.</p>
            <div>
                <span class="tech-badge"><i class="fab fa-php"></i> PHP 8.0+</span>
                <span class="tech-badge"><i class="fas fa-database"></i> Eloquent ORM</span>
                <span class="tech-badge"><i class="fas fa-rocket"></i> MVC Architecture</span>
            </div>
            <div>
                <a href="#documentation" class="btn">Documentation</a>
                <a href="#components" class="btn btn-outline">View Examples</a>
            </div>
        </div>
    </section>



    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <div class="company-info">
                    <div class="company-logo">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div>
                        <h3>MVB Framework</h3>
                        <p>By 2r Technology</p>
                    </div>
                </div>
                <p>A modern PHP framework for building robust web applications faster with elegant syntax and powerful
                    features.</p>
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
                    <li><a href="#"><i class="fab fa-github"></i> GitHub</a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-discord"></i> Discord</a></li>
                    <li><a href="#"><i class="fab fa-stack-overflow"></i> Stack Overflow</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Company</h3>
                <ul class="footer-links">
                    <li><a href="#">About 2r Technology</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 MVB Framework by 2r Technology. All rights reserved.</p>
        </div>
    </footer>


</body>

</html>
