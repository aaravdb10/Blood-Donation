<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = ""; // XAMPP default

// Connect to MySQL
$conn = mysqli_connect($host, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected to MySQL successfully!<br>";

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS blood_donation";
if (mysqli_query($conn, $sql)) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . mysqli_error($conn) . "<br>";
}

// Select the database
mysqli_select_db($conn, "blood_donation");

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    phone VARCHAR(15),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    role ENUM('admin', 'donor', 'recipient') NOT NULL DEFAULT 'donor',
    last_donation_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Users table created successfully<br>";
} else {
    echo "Error creating users table: " . mysqli_error($conn) . "<br>";
}

// Create donors table
$sql = "CREATE TABLE IF NOT EXISTS donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    last_donation_date DATE,
    is_eligible BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Donors table created successfully<br>";
} else {
    echo "Error creating donors table: " . mysqli_error($conn) . "<br>";
}

// Create hospitals table
$sql = "CREATE TABLE IF NOT EXISTS hospitals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    organization_type ENUM('hospital', 'blood_bank', 'clinic') NOT NULL,
    license_number VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    contact_person VARCHAR(100) NOT NULL,
    position VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Hospitals table created successfully<br>";
} else {
    echo "Error creating hospitals table: " . mysqli_error($conn) . "<br>";
}

// Create admins table
$sql = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Admins table created successfully<br>";
} else {
    echo "Error creating admins table: " . mysqli_error($conn) . "<br>";
}

// Create blood_requests table
$sql = "CREATE TABLE IF NOT EXISTS blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    units_needed INT NOT NULL,
    urgency ENUM('normal', 'urgent', 'emergency') NOT NULL,
    patient_name VARCHAR(100) NOT NULL,
    patient_age INT NOT NULL,
    medical_condition TEXT,
    required_by DATE NOT NULL,
    status ENUM('pending', 'fulfilled', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Blood requests table created successfully<br>";
} else {
    echo "Error creating blood requests table: " . mysqli_error($conn) . "<br>";
}

// Create blood_camps table
$sql = "CREATE TABLE IF NOT EXISTS blood_camps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    organizer_id INT NOT NULL,
    max_donors INT NOT NULL,
    registered_donors INT DEFAULT 0,
    status ENUM('upcoming', 'ongoing', 'completed', 'cancelled') DEFAULT 'upcoming',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES hospitals(id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Blood camps table created successfully<br>";
} else {
    echo "Error creating blood camps table: " . mysqli_error($conn) . "<br>";
}

// Create camp_registrations table
$sql = "CREATE TABLE IF NOT EXISTS camp_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    camp_id INT NOT NULL,
    donor_id INT NOT NULL,
    status ENUM('registered', 'checked_in', 'completed', 'cancelled') DEFAULT 'registered',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (camp_id) REFERENCES blood_camps(id),
    FOREIGN KEY (donor_id) REFERENCES donors(id),
    UNIQUE KEY unique_registration (camp_id, donor_id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Camp registrations table created successfully<br>";
} else {
    echo "Error creating camp registrations table: " . mysqli_error($conn) . "<br>";
}

// Create donations table
$sql = "CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT NOT NULL,
    camp_id INT,
    hospital_id INT NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    units INT NOT NULL DEFAULT 1,
    hemoglobin_level DECIMAL(4,2),
    blood_pressure VARCHAR(20),
    donation_date DATE NOT NULL,
    next_eligible_date DATE NOT NULL,
    status ENUM('completed', 'deferred', 'failed') NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id) REFERENCES donors(id),
    FOREIGN KEY (camp_id) REFERENCES blood_camps(id),
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Donations table created successfully<br>";
} else {
    echo "Error creating donations table: " . mysqli_error($conn) . "<br>";
}

// Create blood_inventory table
$sql = "CREATE TABLE IF NOT EXISTS blood_inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT NOT NULL,
    blood_group ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
    units_available INT NOT NULL DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (hospital_id) REFERENCES hospitals(id),
    UNIQUE KEY unique_blood_group (hospital_id, blood_group)
)";

if (mysqli_query($conn, $sql)) {
    echo "Blood inventory table created successfully<br>";
} else {
    echo "Error creating blood inventory table: " . mysqli_error($conn) . "<br>";
}

// Create notifications table
$sql = "CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('donor', 'hospital', 'admin') NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Notifications table created successfully<br>";
} else {
    echo "Error creating notifications table: " . mysqli_error($conn) . "<br>";
}

// Create a default admin account
$admin_email = 'admin@lifeflow.com';
$admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$sql = "INSERT IGNORE INTO admins (name, email, password) VALUES ('System Admin', ?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $admin_email, $admin_password);

if (mysqli_stmt_execute($stmt)) {
    echo "Default admin account created successfully<br>";
} else {
    echo "Error creating default admin account: " . mysqli_error($conn) . "<br>";
}

echo "<br>Database setup complete! You can now <a href='index.php'>go to the homepage</a> or <a href='login.php'>login</a> with:<br>";
echo "Username: admin<br>";
echo "Password: admin123<br>";

mysqli_close($conn);
?> 