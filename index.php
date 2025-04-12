<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'includes/header.php';
include_once 'includes/auth.php';
?>

<!-- Hero Section -->
<section class="hero-gradient text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Donate Blood, Save Lives</h1>
                <p class="text-xl mb-6">Your donation can save up to three lives. Join our community of donors and make a difference today.</p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="/register.php" class="bg-white text-red-600 font-semibold px-6 py-3 rounded-md hover:bg-gray-100 transition text-center">Become a Donor</a>
                    <a href="/request.php" class="border-2 border-white text-white font-semibold px-6 py-3 rounded-md hover:bg-red-700 transition text-center">Request Blood</a>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="/assets/images/hero-image.png" alt="Blood donation illustration" class="w-full">
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="stats-container">
            <div class="stat-card">
                <i class="fas fa-tint stat-icon"></i>
                <div class="stat-number">50,842</div>
                <div class="stat-label">Total Donations</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-heart stat-icon"></i>
                <div class="stat-number">152,526</div>
                <div class="stat-label">Lives Saved</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-hospital stat-icon"></i>
                <div class="stat-number">12k+</div>
                <div class="stat-label">Donation Centers</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">How It Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
            <!-- Register -->
            <div class="text-center">
                <div class="bg-red-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-user text-red-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Register</h3>
                <p class="text-sm text-gray-600">Create your donor profile with your blood type and contact information.</p>
            </div>
            <div class="hidden md:flex items-center justify-center">
                <i class="fas fa-arrow-right text-gray-400"></i>
            </div>
            <!-- Eligibility Check -->
            <div class="text-center">
                <div class="bg-red-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-clipboard-check text-red-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Eligibility Check</h3>
                <p class="text-sm text-gray-600">Complete a health questionnaire to ensure you're eligible to donate.</p>
            </div>
            <div class="hidden md:flex items-center justify-center">
                <i class="fas fa-arrow-right text-gray-400"></i>
            </div>
            <!-- Schedule -->
            <div class="text-center">
                <div class="bg-red-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-calendar text-red-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Schedule</h3>
                <p class="text-sm text-gray-600">Book an appointment at your preferred donation center and time.</p>
            </div>
            <div class="hidden md:flex items-center justify-center">
                <i class="fas fa-arrow-right text-gray-400"></i>
            </div>
            <!-- Donate -->
            <div class="text-center">
                <div class="bg-red-100 rounded-full p-4 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                    <i class="fas fa-heart text-red-600 text-2xl"></i>
                </div>
                <h3 class="font-semibold mb-2">Donate</h3>
                <p class="text-sm text-gray-600">Complete your donation and save lives in your community.</p>
            </div>
        </div>
    </div>
</section>

<!-- Eligibility Criteria Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Eligibility Criteria</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Age & Weight -->
            <div class="eligibility-card">
                <h3 class="eligibility-title">Age & Weight</h3>
                <ul class="eligibility-list">
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>Must be at least 18 years old</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>Weight at least 110 lbs (50 kg)</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>No upper age limit for regular donors</span>
                    </li>
                </ul>
            </div>
            <!-- Health Requirements -->
            <div class="eligibility-card">
                <h3 class="eligibility-title">Health Requirements</h3>
                <ul class="eligibility-list">
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>Generally good health</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>No fever or illness on donation day</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>Adequate hemoglobin levels</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>Normal blood pressure and pulse</span>
                    </li>
                </ul>
            </div>
            <!-- Waiting Periods -->
            <div class="eligibility-card">
                <h3 class="eligibility-title">Waiting Periods</h3>
                <ul class="eligibility-list">
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>56 days between whole blood donations</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>112 days after double red cell donation</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>7 days after plasma donation</span>
                    </li>
                    <li class="eligibility-item">
                        <i class="fas fa-check eligibility-icon"></i>
                        <span>Varies after certain medications or vaccinations</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-8">
            <a href="/eligibility.php" class="btn-primary">Check Your Eligibility</a>
        </div>
    </div>
</section>

<!-- Blood Usage Statistics Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Blood Usage Statistics</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Blood Usage Chart -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-6">Blood Usage by Medical Need</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700">Cancer Treatment</span>
                            <span class="text-gray-700">34%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" style="width: 34%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700">Trauma & Accidents</span>
                            <span class="text-gray-700">25%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700">Surgery</span>
                            <span class="text-gray-700">18%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" style="width: 18%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700">Blood Disorders</span>
                            <span class="text-gray-700">13%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" style="width: 13%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-1">
                            <span class="text-gray-700">Childbirth</span>
                            <span class="text-gray-700">10%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" style="width: 10%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Blood Facts -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold mb-6">Blood Facts</h3>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-circle text-red-600 text-xs mt-2 mr-3"></i>
                        <span class="text-gray-700">Every 2 seconds, someone in the U.S. needs blood.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-red-600 text-xs mt-2 mr-3"></i>
                        <span class="text-gray-700">A single car accident victim can require as many as 100 units of blood.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-red-600 text-xs mt-2 mr-3"></i>
                        <span class="text-gray-700">Less than 38% of the population is eligible to donate blood.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-red-600 text-xs mt-2 mr-3"></i>
                        <span class="text-gray-700">Blood cannot be manufactured – it can only come from generous donors.</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-circle text-red-600 text-xs mt-2 mr-3"></i>
                        <span class="text-gray-700">One donation can save up to three lives.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-red-50 py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Make a Difference?</h2>
        <p class="text-gray-700 mb-8">Join our community of donors today and help save lives.</p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="/register.php" class="btn-primary">Register Now</a>
            <a href="/login.php" class="btn-secondary">Login</a>
        </div>
    </div>
</section>

<!-- Blood Type Info Section -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Blood Types & Compatibility</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $bloodTypes = [
                'A+' => ['Can donate to: A+, AB+', 'Can receive from: A+, A-, O+, O-'],
                'A-' => ['Can donate to: A+, A-, AB+, AB-', 'Can receive from: A-, O-'],
                'B+' => ['Can donate to: B+, AB+', 'Can receive from: B+, B-, O+, O-'],
                'B-' => ['Can donate to: B+, B-, AB+, AB-', 'Can receive from: B-, O-'],
                'AB+' => ['Can donate to: AB+', 'Can receive from: All blood types'],
                'AB-' => ['Can donate to: AB+, AB-', 'Can receive from: A-, B-, AB-, O-'],
                'O+' => ['Can donate to: A+, B+, AB+, O+', 'Can receive from: O+, O-'],
                'O-' => ['Can donate to: All blood types', 'Can receive from: O-']
            ];
            
            foreach ($bloodTypes as $type => $info) {
                echo '<div class="bg-white p-6 rounded-lg shadow-md">';
                echo '<div class="text-center mb-4">';
                echo '<span class="inline-block bg-red-200 text-red-800 text-2xl font-bold px-4 py-2 rounded">' . $type . '</span>';
                echo '</div>';
                echo '<p class="mb-2 font-semibold">' . $info[0] . '</p>';
                echo '<p>' . $info[1] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</section>

<!-- Why Donate Section -->
<section class="py-12 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Why Donate Blood?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-red-600 text-4xl mb-4 text-center">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center">Save Lives</h3>
                <p class="text-gray-700">One donation can save up to 3 lives. Blood is needed every 2 seconds for emergencies and regular treatments.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-red-600 text-4xl mb-4 text-center">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center">Health Benefits</h3>
                <p class="text-gray-700">Regular blood donation can reduce the risk of heart disease and reveal potential health issues through free mini check-ups.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="text-red-600 text-4xl mb-4 text-center">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center">Community Support</h3>
                <p class="text-gray-700">Your donation helps patients fighting cancer, chronic diseases, and traumatic injuries in your local community.</p>
            </div>
        </div>
    </div>
</section>

<!-- Upcoming Camps Preview -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Upcoming Blood Camps</h2>
            <a href="camps.php" class="text-red-600 hover:underline font-semibold">View All <i class="fas fa-arrow-right ml-1"></i></a>
        </div>
        
        <?php
        
        $query = "SELECT * FROM blood_camps WHERE date >= CURDATE() ORDER BY date ASC LIMIT 3";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-6">';
            
            while ($camp = mysqli_fetch_assoc($result)) {
                $date = date("F j, Y", strtotime($camp['date']));
                
                echo '<div class="bg-white rounded-lg shadow-md overflow-hidden">';
                echo '<div class="p-6">';
                echo '<h3 class="font-bold text-xl mb-2">' . htmlspecialchars($camp['title']) . '</h3>';
                echo '<div class="mb-4 flex items-center text-sm text-gray-600">';
                echo '<i class="far fa-calendar mr-2"></i>' . $date;
                echo '</div>';
                echo '<div class="mb-4 flex items-start text-sm text-gray-600">';
                echo '<i class="fas fa-map-marker-alt mr-2 mt-1"></i>';
                echo '<span>' . htmlspecialchars($camp['location']) . '<br>' . htmlspecialchars($camp['city']) . ', ' . htmlspecialchars($camp['state']) . '</span>';
                echo '</div>';
                echo '<p class="text-gray-700 mb-4">' . htmlspecialchars($camp['description']) . '</p>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
        } else {
            echo '<div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded">';
            echo '<p class="text-center">No upcoming blood donation camps at the moment. Please check back later.</p>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<?php include_once 'includes/footer.php'; ?>