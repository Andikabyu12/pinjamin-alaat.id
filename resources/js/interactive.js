// Enhanced Interactive Effects for Playful UI

document.addEventListener('DOMContentLoaded', function() {
    // 1. Smooth scroll behavior for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // 2. Add animation to elements on scroll (Intersection Observer)
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all cards and sections
    document.querySelectorAll('.enhanced-card, .glass-card, section').forEach(el => {
        observer.observe(el);
    });

    // 3. Add parallax effect to decorative elements
    const parallaxElements = document.querySelectorAll('.parallax');
    window.addEventListener('scroll', () => {
        parallaxElements.forEach(el => {
            const scrollPosition = window.pageYOffset;
            const elementOffset = el.offsetTop;
            const distance = scrollPosition - elementOffset;
            el.style.transform = `translateY(${distance * 0.5}px)`;
        });
    });

    // 4. Interactive button feedback
    document.querySelectorAll('button, .btn-primary, .btn-secondary').forEach(button => {
        button.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            // Remove previous ripple
            const oldRipple = this.querySelector('.ripple');
            if (oldRipple) oldRipple.remove();

            this.appendChild(ripple);

            // Remove ripple after animation
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // 5. Form field animations
    document.querySelectorAll('input, textarea, select').forEach(field => {
        field.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        field.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });

        // Add filled state
        if (field.value) {
            field.parentElement.classList.add('filled');
        }

        field.addEventListener('input', function() {
            if (this.value) {
                this.parentElement.classList.add('filled');
            } else {
                this.parentElement.classList.remove('filled');
            }
        });
    });

    // 6. Counter animation for stats
    const counters = document.querySelectorAll('.counter');
    const counterObserverOptions = {
        threshold: 0.5
    };
    
    let counterStarted = false;
    const counterObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting && !counterStarted) {
                counterStarted = true;
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 50;
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 30);
            }
        });
    }, counterObserverOptions);

    counters.forEach(counter => counterObserver.observe(counter));

    // 7. Add hover tilt effect to cards
    document.querySelectorAll('.tilt-card').forEach(card => {
        card.addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            const rotateX = (y - centerY) * 0.1;
            const rotateY = (centerX - x) * 0.1;

            this.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.02)`;
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'rotateX(0) rotateY(0) scale(1)';
        });
    });

    // 8. Animated scroll progress bar
    const progressBar = document.querySelector('.scroll-progress-bar');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
            const scrolled = (window.scrollY / scrollHeight) * 100;
            progressBar.style.width = scrolled + '%';
        });
    }

    // 9. Toast notifications
    window.showToast = function(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => toast.remove(), 3000);
    };

    // 10. Decorate cards and section elements dynamically
    function applyDynamicDecorations() {
        const cards = document.querySelectorAll('.enhanced-card, .glass-panel, .hover-lift, .panel-card');
        cards.forEach((card, index) => {
            if (card.dataset.decorated === 'true') return;
            if (window.getComputedStyle(card).position === 'static') {
                card.style.position = 'relative';
            }
            card.dataset.decorated = 'true';

            const badge = document.createElement('div');
            badge.className = 'decorative-card-badge';
            badge.style.top = `${10 + (index % 3) * 8}%`;
            badge.style.right = `${8 + (index % 2) * 10}%`;
            badge.innerHTML = '<span></span><span></span>';
            card.appendChild(badge);

            const flare = document.createElement('div');
            flare.className = 'decorative-card-flare';
            flare.style.width = `${20 + (index % 4) * 8}px`;
            flare.style.height = flare.style.width;
            flare.style.top = `${14 + (index * 11) % 62}%`;
            flare.style.left = `${12 + (index * 18) % 60}%`;
            card.appendChild(flare);
        });

        const headings = document.querySelectorAll('h1, h2, .text-5xl, .text-3xl');
        headings.forEach(heading => {
            if (heading.classList.contains('decorated-heading')) return;
            heading.classList.add('decorated-heading');
        });
    }

    applyDynamicDecorations();

    // 11. Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K for search (if search available)
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('[data-search-input]');
            if (searchInput) searchInput.focus();
        }
    });

    // 11. Floating ambient orbs for page decoration
    const layoutDecor = document.createElement('div');
    layoutDecor.className = 'layout-decor';
    document.body.appendChild(layoutDecor);

    const orbConfigs = [
        {size: 180, top: '8%', left: '10%', color: 'rgba(56, 189, 248, 0.18)', delay: 0, duration: 16},
        {size: 130, top: '22%', left: '78%', color: 'rgba(236, 72, 153, 0.16)', delay: 3, duration: 14},
        {size: 220, top: '68%', left: '12%', color: 'rgba(16, 185, 129, 0.14)', delay: 1.5, duration: 18},
        {size: 100, top: '66%', left: '70%', color: 'rgba(129, 140, 248, 0.12)', delay: 2, duration: 12},
    ];

    orbConfigs.forEach(config => {
        const orb = document.createElement('div');
        orb.className = 'decorative-orb';
        orb.style.width = orb.style.height = `${config.size}px`;
        orb.style.top = config.top;
        orb.style.left = config.left;
        orb.style.background = `radial-gradient(circle, ${config.color} 0%, transparent 62%)`;
        orb.style.animationDuration = `${config.duration}s`;
        orb.style.animationDelay = `${config.delay}s`;
        layoutDecor.appendChild(orb);
    });

    // 12. Header glow on scroll
    const pageHeader = document.querySelector('header');
    if (pageHeader) {
        window.addEventListener('scroll', () => {
            pageHeader.classList.toggle('scrolled', window.scrollY > 24);
        });
    }

    // 13. Cursor trail particles
    const cursorTrail = document.createElement('div');
    cursorTrail.className = 'cursor-trail';
    document.body.appendChild(cursorTrail);

    let lastParticleTime = 0;
    document.addEventListener('mousemove', (event) => {
        const now = performance.now();
        if (now - lastParticleTime < 40) return;
        lastParticleTime = now;

        const particle = document.createElement('div');
        particle.className = 'cursor-particle';
        particle.style.left = `${event.clientX}px`;
        particle.style.top = `${event.clientY}px`;
        cursorTrail.appendChild(particle);

        setTimeout(() => particle.remove(), 700);
    });

    // 14. Dynamic hover highlight for layout cards
    document.querySelectorAll('.enhanced-card, .glass-panel, .hover-lift').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('card-highlight');
        });
        card.addEventListener('mouseleave', function() {
            this.classList.remove('card-highlight');
        });
    });

    // 15. Add audio-style pulsing for important stats
    const statBoxes = document.querySelectorAll('.enhanced-card .text-5xl, .glass-panel .text-3xl');
    statBoxes.forEach(box => {
        box.classList.add('pulse-stat');
    });
});

// Add scroll animation classes
const style = document.createElement('style');
style.textContent = `
    .scroll-progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #38bdf8, #818cf8);
        width: 0%;
        z-index: 999;
        transition: width 0.1s ease;
    }

    .animate-in {
        animation: fadeInUp 0.6s ease both;
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.6);
        transform: scale(0);
        animation: ripple 0.6s ease-out;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    input:focus-visible,
    select:focus-visible,
    textarea:focus-visible {
        outline: 2px solid #38bdf8;
        outline-offset: 2px;
    }

    .toast {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        animation: slideInRight 0.3s ease;
        z-index: 1000;
        font-weight: 500;
    }

    .toast-info {
        background: #38bdf8;
        color: white;
    }

    .toast-success {
        background: #10b981;
        color: white;
    }

    .toast-warning {
        background: #f59e0b;
        color: white;
    }

    .toast-error {
        background: #ef4444;
        color: white;
    }

    .layout-decor {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: -2;
        overflow: hidden;
    }

    .decorative-orb {
        position: absolute;
        border-radius: 999px;
        filter: blur(8px);
        opacity: 0.85;
        animation: floatAmbient ease-in-out infinite alternate;
    }

    @keyframes floatAmbient {
        from {
            transform: translateY(0) scale(1);
        }
        to {
            transform: translateY(-28px) scale(1.05);
        }
    }

    .cursor-trail {
        position: fixed;
        inset: 0;
        pointer-events: none;
        z-index: 999;
    }

    .cursor-particle {
        position: fixed;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(56, 189, 248, 0.9);
        mix-blend-mode: screen;
        transform: translate(-50%, -50%) scale(1);
        animation: particleFade 0.7s ease-out forwards;
        pointer-events: none;
    }

    @keyframes particleFade {
        to {
            transform: translate(-50%, -50%) scale(2);
            opacity: 0;
        }
    }

    .card-highlight {
        box-shadow: 0 40px 120px rgba(56, 189, 248, 0.18);
        border-color: rgba(56, 189, 248, 0.3);
    }

    .decorative-card-badge {
        position: absolute;
        width: 56px;
        height: 56px;
        border-radius: 999px;
        border: 1px solid rgba(56, 189, 248, 0.45);
        background: linear-gradient(140deg, rgba(56, 189, 248, 0.18), transparent 70%);
        box-shadow: 0 0 30px rgba(56, 189, 248, 0.14);
        pointer-events: none;
        overflow: hidden;
        opacity: 0.95;
    }

    .decorative-card-badge span {
        position: absolute;
        display: block;
        border-radius: 999px;
        inset: 12px;
        border: 1px solid rgba(255, 255, 255, 0.18);
    }

    .decorative-card-badge span:last-child {
        inset: 18px;
        opacity: 0.65;
    }

    .decorative-card-flare {
        position: absolute;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.32), transparent 55%);
        box-shadow: 0 0 22px rgba(236, 72, 153, 0.18);
        pointer-events: none;
        animation: floatAmbient 10s ease-in-out infinite alternate;
    }

    .decorated-heading {
        position: relative;
    }

    .decorated-heading::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.75rem;
        width: 4.5rem;
        height: 0.7rem;
        background: radial-gradient(circle at left, rgba(56, 189, 248, 0.4), transparent 70%);
        opacity: 0.85;
        transform: rotate(-4deg);
        pointer-events: none;
    }

    .pulse-stat {
        animation: pulseGlow 3s ease-in-out infinite;
    }

    header.scrolled {
        backdrop-filter: blur(20px);
        background: rgba(15, 23, 42, 0.75);
        box-shadow: 0 16px 40px rgba(15, 23, 42, 0.22);
        border-bottom: 1px solid rgba(56, 189, 248, 0.14);
    }
`;
document.head.appendChild(style);
