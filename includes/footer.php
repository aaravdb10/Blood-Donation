    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 pt-12 pb-8 mt-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Logo and Description -->
                <div class="col-span-1">
                    <div class="flex items-center space-x-2 mb-4">
                        <i class="fas fa-tint text-red-600 text-2xl"></i>
                        <span class="text-xl font-bold">LifeFlow</span>
                    </div>
                    <p class="text-gray-600 mb-4">
                        Connecting donors with those in need, one donation at a time.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-red-600 transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-600 transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-600 transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/about.php" class="text-gray-600 hover:text-red-600">About Us</a></li>
                        <li><a href="/how-it-works.php" class="text-gray-600 hover:text-red-600">How It Works</a></li>
                        <li><a href="/why-donate.php" class="text-gray-600 hover:text-red-600">Why Donate</a></li>
                        <li><a href="/testimonials.php" class="text-gray-600 hover:text-red-600">Testimonials</a></li>
                        <li><a href="/faq.php" class="text-gray-600 hover:text-red-600">FAQ</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="/blog.php" class="text-gray-600 hover:text-red-600">Blog</a></li>
                        <li><a href="/educational-resources.php" class="text-gray-600 hover:text-red-600">Educational Resources</a></li>
                        <li><a href="/eligibility.php" class="text-gray-600 hover:text-red-600">Eligibility Criteria</a></li>
                        <li><a href="/donation-centers.php" class="text-gray-600 hover:text-red-600">Donation Centers</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-span-1">
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt text-red-600 mt-1 mr-2"></i>
                            <span class="text-gray-600">+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-envelope text-red-600 mt-1 mr-2"></i>
                            <span class="text-gray-600">contact@lifeflow.com</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt text-red-600 mt-1 mr-2"></i>
                            <span class="text-gray-600">
                                123 Main Street, Suite 100<br>
                                New York, NY 10001
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="border-t border-gray-200 pt-8 pb-4">
                <div class="max-w-2xl mx-auto text-center">
                    <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                    <p class="text-gray-600 mb-4">
                        Subscribe to our newsletter for updates on blood drives, donor stories, and educational resources.
                    </p>
                    <form class="flex max-w-md mx-auto">
                        <input type="email" placeholder="Enter your email" class="form-input flex-grow" required>
                        <button type="submit" class="btn-primary ml-2 whitespace-nowrap">Subscribe</button>
                    </form>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-200 mt-8 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-600 text-sm">
                        © <?php echo date('Y'); ?> LifeFlow. All rights reserved.
                    </p>
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="/privacy-policy.php" class="text-gray-600 hover:text-red-600 text-sm">Privacy Policy</a>
                        <a href="/terms-of-service.php" class="text-gray-600 hover:text-red-600 text-sm">Terms of Service</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu JavaScript -->
    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>