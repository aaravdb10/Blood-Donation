<?php 
session_start();
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeFlow - Blood Donation Management System</title>
    <meta name="description" content="Connect blood donors with those in need. Register as a donor or request blood through our platform.">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
<<<<<<< HEAD
    
    <!-- Custom Styles -->
    <link rel="stylesheet" href="/includes/styles.css">
    
    <!-- Font Awesome -->
=======
    <link rel="stylesheet" href="assets/styles.css">
>>>>>>> d568b944ac84451f268c25872e79ef0a9230ac2f
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="min-h-screen flex flex-col">
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Navigation -->
    <header class="bg-white shadow-sm">
        <nav class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2">
                    <i class="fas fa-tint text-red-600 text-2xl"></i>
                    <span class="text-xl font-bold">LifeFlow</span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <div class="space-x-6">
                        <a href="/about.php" class="nav-link">About</a>
                        <div class="relative inline-block group">
                            <button class="nav-link">Donation</button>
                            <div class="hidden group-hover:block absolute z-10 w-48 bg-white rounded-md shadow-lg py-1 mt-1">
                                <a href="/camps.php" class="block px-4 py-2 hover:bg-gray-100">Blood Camps</a>
                                <a href="/eligibility.php" class="block px-4 py-2 hover:bg-gray-100">Eligibility</a>
                                <a href="/process.php" class="block px-4 py-2 hover:bg-gray-100">Donation Process</a>
                            </div>
                        </div>
                        <a href="/why-donate.php" class="nav-link">Why Donate</a>
                        <a href="/education.php" class="nav-link">Education</a>
                        <a href="/faq.php" class="nav-link">FAQ</a>
                        <a href="/contact.php" class="nav-link">Contact</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/dashboard" class="btn-secondary">Dashboard</a>
                            <a href="/logout.php" class="nav-link">Logout</a>
                        <?php else: ?>
                            <a href="/login.php" class="nav-link">Login</a>
                            <a href="/register.php" class="btn-primary">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
<<<<<<< HEAD

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600 hover:text-gray-900" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <div class="mobile-menu hidden" id="mobile-menu">
                <div class="mobile-menu-content">
                    <div class="p-4 space-y-4">
                        <a href="/about.php" class="block nav-link">About</a>
                        <a href="/camps.php" class="block nav-link">Blood Camps</a>
                        <a href="/eligibility.php" class="block nav-link">Eligibility</a>
                        <a href="/process.php" class="block nav-link">Donation Process</a>
                        <a href="/why-donate.php" class="block nav-link">Why Donate</a>
                        <a href="/education.php" class="block nav-link">Education</a>
                        <a href="/faq.php" class="block nav-link">FAQ</a>
                        <a href="/contact.php" class="block nav-link">Contact</a>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/dashboard" class="block btn-secondary text-center">Dashboard</a>
                            <a href="/logout.php" class="block nav-link text-center">Logout</a>
                        <?php else: ?>
                            <a href="/login.php" class="block nav-link text-center">Login</a>
                            <a href="/register.php" class="block btn-primary text-center">Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main id="main-content" class="flex-grow">
=======
                <div class="hidden md:flex space-x-6">
                    <a href="/index.php" class="hover:text-red-200 transition">Home</a>
                    <a href="/search.php" class="hover:text-red-200 transition">Donor Search</a>
                    <a href="/camps.php" class="hover:text-red-200 transition">Blood Camps</a>
                    <a href="/request.php" class="hover:text-red-200 transition">Request Blood</a>
                    <?php if(isset($_SESSION['donor_id'])): ?>
                        <a href="/dashboard/donor.php" class="hover:text-red-200 transition">My Dashboard</a>
                        <a href="/logout.php" class="hover:text-red-200 transition">Logout</a>
                    <?php else: ?>
                        <a href="/login.php" class="hover:text-red-200 transition">Login</a>
                        <a href="/register.php" class="hover:text-red-200 transition">Register</a>
                    <?php endif; ?>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden pt-4 pb-2">
                <a href="/index.php" class="block py-2 hover:text-red-200 transition">Home</a>
                <a href="/search.php" class="block py-2 hover:text-red-200 transition">Donor Search</a>
                <a href="/camps.php" class="block py-2 hover:text-red-200 transition">Blood Camps</a>
                <a href="/request.php" class="block py-2 hover:text-red-200 transition">Request Blood</a>
                <?php if(isset($_SESSION['donor_id'])): ?>
                    <a href="/dashboard/donor.php" class="block py-2 hover:text-red-200 transition">My Dashboard</a>
                    <a href="/logout.php" class="block py-2 hover:text-red-200 transition">Logout</a>
                <?php else: ?>
                    <a href="/login.php" class="block py-2 hover:text-red-200 transition">Login</a>
                    <a href="/register.php" class="block py-2 hover:text-red-200 transition">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 py-6">
>>>>>>> d568b944ac84451f268c25872e79ef0a9230ac2f
