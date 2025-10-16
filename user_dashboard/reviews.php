<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Graphio</title>
    <link rel="stylesheet" href="reviews.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <div class="header-content">
                    <div class="header-left">
                        <a href="../index" class="logo">
                            <span class="logo-text">Graphio</span>
                        </a>
                    </div>
                    
                    <nav class="header-nav">
                        <a href="../designs" class="nav-link">Designs</a>
                        <a href="../careers" class="nav-link">Careers</a>
                        <a href="../artists" class="nav-link">Artists</a>
                        <a href="../about.html" class="nav-link">About</a>
                    </nav>
                    
                    <div class="header-right">
                        <div class="user-menu">
                            <div class="user-avatar">
                                <i data-lucide="user" class="avatar-icon"></i>
                            </div>
                            <div class="dropdown-menu">
                                <a href="../user/dashboard" class="dropdown-item">
                                    <i data-lucide="layout-dashboard" class="dropdown-icon"></i>
                                    Dashboard
                                </a>
                                <a href="../user/profile" class="dropdown-item">
                                    <i data-lucide="user" class="dropdown-icon"></i>
                                    Profile
                                </a>
                                <a href="../user_dashboard/account_settings" class="dropdown-item">
                                    <i data-lucide="settings" class="dropdown-icon"></i>
                                    Settings
                                </a>
                                <a href="../login" class="dropdown-item">
                                    <i data-lucide="log-out" class="dropdown-icon"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="page-header-content">
                        <div class="page-header-left">
                            <h1 class="page-title">Customer Reviews</h1>
                            <p class="page-subtitle">See what customers are saying about your designs</p>
                        </div>
                        <div class="page-actions">
                            <a href="../user/dashboard" class="btn btn-outline">
                                <i data-lucide="arrow-left" class="icon-sm"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Review Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon total-reviews">
                                <i data-lucide="star" class="icon-md"></i>
                            </div>
                            <div class="rating-display">
                                <span class="rating-number">4.8</span>
                                <div class="stars">
                                    <i data-lucide="star" class="star filled"></i>
                                    <i data-lucide="star" class="star filled"></i>
                                    <i data-lucide="star" class="star filled"></i>
                                    <i data-lucide="star" class="star filled"></i>
                                    <i data-lucide="star" class="star filled"></i>
                                </div>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">147</h3>
                            <p class="stat-label">Total Reviews</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon positive-reviews">
                                <i data-lucide="thumbs-up" class="icon-md"></i>
                            </div>
                            <div class="stat-trend positive">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                <span>+5.2%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">92%</h3>
                            <p class="stat-label">Positive Reviews</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon response-rate">
                                <i data-lucide="message-circle" class="icon-md"></i>
                            </div>
                            <div class="stat-trend positive">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                <span>+2.8%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">Good</h3>
                            <p class="stat-label">Rating</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-content">
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

    <!-- Reply Modal -->
    <div class="modal-overlay" id="replyModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Reply to Review</h3>
                <button class="modal-close" onclick="closeReplyModal()">
                    <i data-lucide="x" class="icon-sm"></i>
                </button>
            </div>
            <div class="modal-content">
                <div class="form-group">
                    <label for="replyText" class="form-label">Your Response</label>
                    <textarea 
                        id="replyText" 
                        class="form-textarea" 
                        placeholder="Write your response to this review..."
                        rows="4"
                    ></textarea>
                    <p class="field-help">Be professional and constructive in your response</p>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline" onclick="closeReplyModal()">Cancel</button>
                <button class="btn btn-gradient" onclick="submitReply()">
                    <i data-lucide="send" class="icon-sm"></i>
                    Send Reply
                </button>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            initializePage();
        });

        function initializePage() {
            // Filter button functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    filterReviews(this.dataset.rating);
                });
            });

            // Sort functionality
            const sortSelect = document.querySelector('.sort-select');
            sortSelect.addEventListener('change', function() {
                sortReviews(this.value);
            });

            // User menu dropdown
            const userMenu = document.querySelector('.user-menu');
            const userAvatar = document.querySelector('.user-avatar');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            userAvatar.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', function() {
                dropdownMenu.classList.remove('show');
            });
        }

        function filterReviews(rating) {
            console.log('Filtering reviews by rating:', rating);
            // In a real app, this would filter the reviews
        }

        function sortReviews(sortBy) {
            console.log('Sorting reviews by:', sortBy);
            // In a real app, this would sort the reviews
        }

        function replyToReview(reviewId) {
            document.getElementById('replyModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function editReply(reviewId) {
            // Pre-fill the modal with existing reply
            document.getElementById('replyText').value = "Thank you for the feedback! I've updated the package to include all font files. You should have received an email with the updated download link.";
            document.getElementById('replyModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeReplyModal() {
            document.getElementById('replyModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            document.getElementById('replyText').value = '';
        }

        function submitReply() {
            const replyText = document.getElementById('replyText').value;
            if (replyText.trim()) {
                alert('Reply submitted successfully!');
                closeReplyModal();
            } else {
                alert('Please enter a response before submitting.');
            }
        }

        // Close modal when clicking outside
        document.getElementById('replyModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeReplyModal();
            }
        });
    </script>
</body>
</html>