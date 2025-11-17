@extends('layouts.main')
@section('content')
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
@endsection
