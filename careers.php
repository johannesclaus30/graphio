<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Careers - Graphio</title>
    <link rel="icon" type="image/jpg" sizes="30x30" href="logos/graphio.jpg">
    <link rel="stylesheet" href="careers.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <div class="min-h-screen">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index" class="logo-link">
                            <img class="graphio-logo" src="logos/graphio_logo_blue.png" />
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="nav-desktop">
                        <a href="designs" class="nav-link">Designs</a>
                        <a href="careers" class="nav-link active">Careers</a>
                        <a href="artists" class="nav-link">Artists</a>
                        <a href="about.html" class="nav-link">About</a>
                    </nav>

                    <!-- Right side buttons -->
                    <div class="header-buttons">
                        <a href="login" class="btn btn-outline btn-sm">Sign In</a>
                        <button class="btn btn-sm btn-gradient designer-btn">
                             <a href="signup" class="logo-link-white">Create a <i class="text-italic-gold"> graphio  </i> account</a>
                            </button>
                        
                        <!-- Mobile menu button -->
                        <button class="btn btn-ghost btn-sm mobile-menu">
                            <i data-lucide="menu" class="icon-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="hero-section" id="up">
                <div class="container">
                    <div class="hero-content">
                        <h1 class="hero-title">Find Your Dream Design Career</h1>
                        <p class="hero-description">
                            Discover exciting opportunities with companies looking for talented graphic designers and creative professionals
                        </p>
                        
                        <!-- Search Bar -->
                        <div class="search-container">
                            <div class="search-input-container">
                                <i data-lucide="search" class="search-icon"></i>
                                <input 
                                    type="text" 
                                    id="searchInput"
                                    placeholder="Search jobs by title, company, or location..." 
                                    class="search-input"
                                >
                            </div>
                        </div>
                        
                        <!-- Quick Stats -->
                        <div class="hero-stats">
                            <div class="stat-item">
                                <span class="stat-number">150+</span>
                                <span class="stat-label">Active Jobs</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">50+</span>
                                <span class="stat-label">Companies</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">95%</span>
                                <span class="stat-label">Success Rate</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Filters Section -->
            <section class="filters-section">
                <div class="container">
                    <div class="filters-content">
                        <div class="filters-left">
                            <div class="filter-group">
                                <label class="filter-label">Job Type</label>
                                <div class="filter-buttons" id="jobTypeButtons">
                                    <button class="btn btn-filter active" data-filter="all">All</button>
                                    <button class="btn btn-filter" data-filter="full-time">Full-time</button>
                                    <button class="btn btn-filter" data-filter="part-time">Part-time</button>
                                    <button class="btn btn-filter" data-filter="contract">Contract</button>
                                    <button class="btn btn-filter" data-filter="freelance">Freelance</button>
                                </div>
                            </div>
                            
                            <div class="filter-group">
                                <label class="filter-label">Location</label>
                                <div class="filter-buttons" id="locationButtons">
                                    <button class="btn btn-filter active" data-filter="all">All</button>
                                    <button class="btn btn-filter" data-filter="remote">Remote</button>
                                    <button class="btn btn-filter" data-filter="on-site">On-site</button>
                                    <button class="btn btn-filter" data-filter="hybrid">Hybrid</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="filters-right">
                            <div class="sort-container">
                                <label class="sort-label">Sort by</label>
                                <select id="sortSelect" class="sort-select">
                                    <option value="newest">Newest First</option>
                                    <option value="oldest">Oldest First</option>
                                    <option value="salary-high">Salary: High to Low</option>
                                    <option value="salary-low">Salary: Low to High</option>
                                    <option value="company">Company Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="results-count" id="resultsCount">
                        Showing 15 of 150 jobs
                    </div>
                </div>
            </section>

            <!-- Jobs Section -->
            <section class="jobs-section">
                <div class="container">
                    <div class="jobs-grid" id="jobsGrid">
                        <!-- Job cards will be inserted here by JavaScript -->
                    </div>
                    
                    <!-- Load More Button -->
                    <div class="load-more-container">
                        <button class="btn btn-outline load-more-btn" id="loadMoreBtn">
                            Load More Jobs
                            <i data-lucide="chevron-down" class="icon-sm"></i>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="cta-section">
                <div class="container">
                    <div class="cta-content">
                        <div class="cta-text">
                            <h2 class="cta-title">Ready to Start Your Design Career?</h2>
                            <p class="cta-description">
                                Join thousands of successful designers who found their dream jobs through Graphio
                            </p>
                        </div>
                        <div class="cta-actions">
                            <a href="signup.html" class="btn btn-primary">
                                Create Your Profile
                                <i data-lucide="arrow-right" class="icon-sm"></i>
                            </a>
                            <button class="btn btn-outline btn-white">
                                <i data-lucide="upload" class="icon-sm"></i>
                                Upload Resume
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Companies -->
            <section class="companies-section">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Trusted by Leading Companies</h2>
                        <p class="section-description">
                            Top organizations choose Graphio to find exceptional design talent
                        </p>
                    </div>
                    
                    <div class="companies-grid">
                        <div class="company-card">
                            <div class="company-logo">TC</div>
                            <div class="company-info">
                                <h3 class="company-name">TechCorp Solutions</h3>
                                <p class="company-type">Technology</p>
                                <div class="company-stats">
                                    <span class="stat">12 open positions</span>
                                    <span class="stat">500+ employees</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="company-card">
                            <div class="company-logo">CS</div>
                            <div class="company-info">
                                <h3 class="company-name">Creative Studios Inc</h3>
                                <p class="company-type">Design Agency</p>
                                <div class="company-stats">
                                    <span class="stat">8 open positions</span>
                                    <span class="stat">50+ employees</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="company-card">
                            <div class="company-logo">SX</div>
                            <div class="company-info">
                                <h3 class="company-name">StartupXYZ</h3>
                                <p class="company-type">Startup</p>
                                <div class="company-stats">
                                    <span class="stat">6 open positions</span>
                                    <span class="stat">25+ employees</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="company-card">
                            <div class="company-logo">GC</div>
                            <div class="company-info">
                                <h3 class="company-name">GrowthCo</h3>
                                <p class="company-type">Marketing</p>
                                <div class="company-stats">
                                    <span class="stat">4 open positions</span>
                                    <span class="stat">200+ employees</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <div class="footer-logo"><a href="#up" class="logo-link-white">
                            <img class="graphio-logo-footer" src="logos/graphio_logo_white.png"/></a></div>
                        <p class="footer-description">
                            The leading marketplace for creative professionals. Connect, create, and grow your design career.
                        </p>
                        <div class="footer-social">
                            <a href="#" class="social-link">
                                <i data-lucide="twitter" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="facebook" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="instagram" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="linkedin" class="icon-sm"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-subtitle">For Job Seekers</h4>
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Browse Jobs</a></li>
                            <li><a href="#" class="footer-link">Career Resources</a></li>
                            <li><a href="#" class="footer-link">Success Stories</a></li>
                            <li><a href="#" class="footer-link">Resume Tips</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-subtitle">For Employers</h4>
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Post a Job</a></li>
                            <li><a href="#" class="footer-link">Find Talent</a></li>
                            <li><a href="#" class="footer-link">Pricing</a></li>
                            <li><a href="#" class="footer-link">Hiring Guide</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-subtitle">Company</h4>
                        <ul class="footer-links">
                            <li><a href="about.html" class="footer-link">About Us</a></li>
                            <li><a href="#" class="footer-link">Careers</a></li>
                            <li><a href="#" class="footer-link">Press</a></li>
                            <li><a href="index#contact" class="footer-link">Contact</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <div class="footer-copyright">
                        © 2025 Graphio Studio. All rights reserved.
                    </div>
                    <div class="footer-legal">
                        <a href="#" class="legal-link">Privacy Policy</a>
                        <a href="#" class="legal-link">Terms of Service</a>
                        <a href="#" class="legal-link">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Job data
        const allJobs = [
            {
                id: 1,
                title: "Senior Graphic Designer",
                company: "TechCorp Solutions",
                location: "San Francisco, CA",
                type: "full-time",
                workLocation: "hybrid",
                salary: "$75,000 - $95,000",
                salaryMin: 75000,
                salaryMax: 95000,
                description: "Lead creative projects and mentor junior designers in a fast-paced tech environment. Work on cutting-edge products and collaborate with cross-functional teams.",
                requirements: ["5+ years experience", "Adobe Creative Suite", "Team leadership", "Brand development"],
                tags: ["Branding", "UI/UX", "Adobe Creative Suite", "Leadership"],
                posted: "2 days ago",
                featured: true,
                company_logo: "TC"
            },
            {
                id: 2,
                title: "Brand Identity Designer",
                company: "Creative Studios Inc",
                location: "Remote",
                type: "contract",
                workLocation: "remote",
                salary: "$60 - $80/hour",
                salaryMin: 60,
                salaryMax: 80,
                description: "Develop comprehensive brand identities for diverse clients across various industries. Create logos, brand guidelines, and marketing materials.",
                requirements: ["3+ years experience", "Brand strategy", "Logo design", "Client communication"],
                tags: ["Logo Design", "Brand Strategy", "Typography", "Consulting"],
                posted: "1 week ago",
                featured: false,
                company_logo: "CS"
            },
            {
                id: 3,
                title: "UI/UX Designer",
                company: "StartupXYZ",
                location: "New York, NY",
                type: "full-time",
                workLocation: "on-site",
                salary: "$70,000 - $90,000",
                salaryMin: 70000,
                salaryMax: 90000,
                description: "Design intuitive user interfaces and enhance user experiences for our mobile and web applications. Conduct user research and create prototypes.",
                requirements: ["2+ years experience", "Figma/Sketch", "User research", "Prototyping"],
                tags: ["Figma", "Prototyping", "User Research", "Mobile Design"],
                posted: "3 days ago",
                featured: true,
                company_logo: "SX"
            },
            {
                id: 4,
                title: "Marketing Designer",
                company: "GrowthCo",
                location: "Austin, TX",
                type: "part-time",
                workLocation: "hybrid",
                salary: "$45,000 - $55,000",
                salaryMin: 45000,
                salaryMax: 55000,
                description: "Create compelling marketing materials and social media graphics to drive brand awareness. Work with marketing team on campaigns.",
                requirements: ["2+ years experience", "Social media design", "Adobe Illustrator", "Marketing knowledge"],
                tags: ["Social Media", "Print Design", "Adobe Illustrator", "Marketing"],
                posted: "5 days ago",
                featured: false,
                company_logo: "GC"
            },
            {
                id: 5,
                title: "Creative Director",
                company: "Design Agency Pro",
                location: "Los Angeles, CA",
                type: "full-time",
                workLocation: "on-site",
                salary: "$100,000 - $130,000",
                salaryMin: 100000,
                salaryMax: 130000,
                description: "Lead creative teams and oversee multiple client projects from concept to completion. Develop creative strategies and maintain quality standards.",
                requirements: ["7+ years experience", "Team management", "Client relations", "Strategic thinking"],
                tags: ["Leadership", "Strategy", "Client Management", "Creative Direction"],
                posted: "1 day ago",
                featured: true,
                company_logo: "DA"
            },
            {
                id: 6,
                title: "Freelance Illustrator",
                company: "Multiple Clients",
                location: "Remote",
                type: "freelance",
                workLocation: "remote",
                salary: "$40 - $75/hour",
                salaryMin: 40,
                salaryMax: 75,
                description: "Create custom illustrations for books, websites, and marketing campaigns. Work with various clients on diverse projects.",
                requirements: ["Portfolio required", "Digital illustration", "Adobe Photoshop", "Communication skills"],
                tags: ["Digital Art", "Character Design", "Adobe Photoshop", "Illustration"],
                posted: "4 days ago",
                featured: false,
                company_logo: "MC"
            },
            {
                id: 7,
                title: "Web Designer",
                company: "Digital Solutions Ltd",
                location: "Seattle, WA",
                type: "full-time",
                workLocation: "hybrid",
                salary: "$65,000 - $85,000",
                salaryMin: 65000,
                salaryMax: 85000,
                description: "Design modern, responsive websites that engage users and drive conversions. Collaborate with developers and marketing teams.",
                requirements: ["3+ years experience", "HTML/CSS knowledge", "Responsive design", "WordPress"],
                tags: ["Web Design", "Responsive", "WordPress", "HTML/CSS"],
                posted: "6 days ago",
                featured: false,
                company_logo: "DS"
            },
            {
                id: 8,
                title: "Motion Graphics Designer",
                company: "MediaTech Studios",
                location: "Miami, FL",
                type: "contract",
                workLocation: "on-site",
                salary: "$55 - $75/hour",
                salaryMin: 55,
                salaryMax: 75,
                description: "Create engaging motion graphics and animations for video content, advertisements, and digital campaigns.",
                requirements: ["After Effects expert", "3D animation", "Video editing", "Creative storytelling"],
                tags: ["After Effects", "Animation", "Video", "3D Graphics"],
                posted: "3 days ago",
                featured: true,
                company_logo: "MT"
            }
        ];

        // State
        let currentJobType = 'all';
        let currentLocation = 'all';
        let currentSort = 'newest';
        let currentSearch = '';
        let displayedJobs = 6;
        let savedJobs = [];

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            setupEventListeners();
            renderJobs();
        });

        function setupEventListeners() {
            // Search input
            document.getElementById('searchInput').addEventListener('input', function(e) {
                currentSearch = e.target.value;
                displayedJobs = 6;
                renderJobs();
            });

            // Filter buttons
            document.querySelectorAll('#jobTypeButtons .btn-filter').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('#jobTypeButtons .btn-filter').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentJobType = this.dataset.filter;
                    displayedJobs = 6;
                    renderJobs();
                });
            });

            document.querySelectorAll('#locationButtons .btn-filter').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('#locationButtons .btn-filter').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    currentLocation = this.dataset.filter;
                    displayedJobs = 6;
                    renderJobs();
                });
            });

            // Sort select
            document.getElementById('sortSelect').addEventListener('change', function(e) {
                currentSort = e.target.value;
                renderJobs();
            });

            // Load more button
            document.getElementById('loadMoreBtn').addEventListener('click', function() {
                displayedJobs += 6;
                renderJobs();
            });
        }

        function getFilteredJobs() {
            return allJobs
                .filter(job => {
                    const matchesSearch = job.title.toLowerCase().includes(currentSearch.toLowerCase()) ||
                                        job.company.toLowerCase().includes(currentSearch.toLowerCase()) ||
                                        job.location.toLowerCase().includes(currentSearch.toLowerCase()) ||
                                        job.tags.some(tag => tag.toLowerCase().includes(currentSearch.toLowerCase()));
                    
                    const matchesJobType = currentJobType === 'all' || job.type === currentJobType;
                    const matchesLocation = currentLocation === 'all' || job.workLocation === currentLocation;
                    
                    return matchesSearch && matchesJobType && matchesLocation;
                })
                .sort((a, b) => {
                    switch (currentSort) {
                        case 'newest':
                            return new Date(b.posted) - new Date(a.posted);
                        case 'oldest':
                            return new Date(a.posted) - new Date(b.posted);
                        case 'salary-high':
                            return b.salaryMax - a.salaryMax;
                        case 'salary-low':
                            return a.salaryMin - b.salaryMin;
                        case 'company':
                            return a.company.localeCompare(b.company);
                        default:
                            return 0;
                    }
                });
        }

        function toggleSaveJob(jobId) {
            const index = savedJobs.indexOf(jobId);
            if (index > -1) {
                savedJobs.splice(index, 1);
            } else {
                savedJobs.push(jobId);
            }
            renderJobs();
        }

        function createJobCard(job) {
            const isSaved = savedJobs.includes(job.id);
            
            return `
                <div class="job-card ${job.featured ? 'featured' : ''}" onclick="viewJob(${job.id})">
                    ${job.featured ? '<div class="featured-badge">Featured</div>' : ''}
                    
                    <div class="job-header">
                        <div class="company-logo">${job.company_logo}</div>
                        <button class="save-btn ${isSaved ? 'saved' : ''}" onclick="event.stopPropagation(); toggleSaveJob(${job.id})">
                            <i data-lucide="bookmark" class="icon-sm ${isSaved ? 'bookmark-filled' : ''}"></i>
                        </button>
                    </div>
                    
                    <div class="job-content">
                        <h3 class="job-title">${job.title}</h3>
                        <div class="job-company">${job.company}</div>
                        
                        <div class="job-meta">
                            <div class="meta-item">
                                <i data-lucide="map-pin" class="icon-xs"></i>
                                ${job.location}
                            </div>
                            <div class="meta-item">
                                <i data-lucide="clock" class="icon-xs"></i>
                                ${job.type.charAt(0).toUpperCase() + job.type.slice(1).replace('-', '-')}
                            </div>
                            <div class="meta-item">
                                <i data-lucide="dollar-sign" class="icon-xs"></i>
                                ${job.salary}
                            </div>
                        </div>
                        
                        <p class="job-description">${job.description}</p>
                        
                        <div class="job-tags">
                            ${job.tags.slice(0, 3).map(tag => `<span class="job-tag">${tag}</span>`).join('')}
                            ${job.tags.length > 3 ? `<span class="job-tag">+${job.tags.length - 3}</span>` : ''}
                        </div>
                        
                        <div class="job-footer">
                            <span class="job-posted">${job.posted}</span>
                            <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); applyJob(${job.id})">
                                Apply Now
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderJobs() {
            const filteredJobs = getFilteredJobs();
            const jobsToShow = filteredJobs.slice(0, displayedJobs);
            
            // Update results count
            const resultsCount = document.getElementById('resultsCount');
            resultsCount.textContent = `Showing ${jobsToShow.length} of ${filteredJobs.length} jobs`;
            
            // Render jobs
            const jobsGrid = document.getElementById('jobsGrid');
            jobsGrid.innerHTML = jobsToShow.map(createJobCard).join('');
            
            // Update load more button
            const loadMoreBtn = document.getElementById('loadMoreBtn');
            if (jobsToShow.length >= filteredJobs.length) {
                loadMoreBtn.style.display = 'none';
            } else {
                loadMoreBtn.style.display = 'flex';
            }
            
            // Reinitialize icons
            lucide.createIcons();
        }

        function viewJob(jobId) {
            console.log('Viewing job:', jobId);
            // Here you would navigate to the job detail page
            alert(`Viewing job ${jobId}`);
        }

        function applyJob(jobId) {
            console.log('Applying to job:', jobId);
            // Here you would handle the job application
            alert(`Applying to job ${jobId}`);
        }
    </script>
</body>
</html>