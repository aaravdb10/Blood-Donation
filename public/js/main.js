// Import other JS files
import { Auth } from './auth.js';
import { BloodDonation } from './blood.js';

// Import required libraries
import axios from 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js';
import Alpine from 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js';
import dayjs from 'https://cdn.jsdelivr.net/npm/dayjs@1.11.10/dayjs.min.js';
import Chart from 'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// API configuration
const API_BASE_URL = '/api';

// Auth functions
window.auth = {
    async login(email, password) {
        try {
            const response = await axios.post(`${API_BASE_URL}/auth/login`, {
                email,
                password
            });
            if (response.data.success) {
                window.location.href = '/dashboard.html';
            }
        } catch (error) {
            console.error('Login failed:', error);
            alert('Login failed. Please check your credentials.');
        }
    },

    async register(email, password, role) {
        try {
            const response = await axios.post(`${API_BASE_URL}/auth/register`, {
                email,
                password,
                role
            });
            if (response.data.success) {
                window.location.href = '/login.html';
            }
        } catch (error) {
            console.error('Registration failed:', error);
            alert('Registration failed. Please try again.');
        }
    },

    logout() {
        localStorage.removeItem('token');
        window.location.href = '/login.html';
    }
};

// Blood donation functions
window.bloodDonation = {
    async getDonations() {
        try {
            const response = await axios.get(`${API_BASE_URL}/donations`);
            return response.data;
        } catch (error) {
            console.error('Failed to fetch donations:', error);
            return [];
        }
    },

    async createDonation(donationData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/donations`, donationData);
            return response.data;
        } catch (error) {
            console.error('Failed to create donation:', error);
            throw error;
        }
    },

    async getBloodInventory() {
        try {
            const response = await axios.get(`${API_BASE_URL}/blood-inventory`);
            return response.data;
        } catch (error) {
            console.error('Failed to fetch blood inventory:', error);
            return [];
        }
    }
};

// Hospital functions
window.hospital = {
    async getHospitals() {
        try {
            const response = await axios.get(`${API_BASE_URL}/hospitals`);
            return response.data;
        } catch (error) {
            console.error('Failed to fetch hospitals:', error);
            return [];
        }
    },

    async createBloodRequest(requestData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/blood-requests`, requestData);
            return response.data;
        } catch (error) {
            console.error('Failed to create blood request:', error);
            throw error;
        }
    },

    async createBloodDrive(driveData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/blood-drives`, driveData);
            return response.data;
        } catch (error) {
            console.error('Failed to create blood drive:', error);
            throw error;
        }
    }
};

// Chart initialization
window.initializeCharts = () => {
    // Blood type distribution chart
    const bloodTypeCtx = document.getElementById('bloodTypeChart');
    if (bloodTypeCtx) {
        new Chart(bloodTypeCtx, {
            type: 'pie',
            data: {
                labels: ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
                datasets: [{
                    data: [33, 6, 9, 2, 3, 1, 37, 9],
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FF6384',
                        '#36A2EB'
                    ]
                }]
            }
        });
    }

    // Donation history chart
    const donationHistoryCtx = document.getElementById('donationHistoryChart');
    if (donationHistoryCtx) {
        new Chart(donationHistoryCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Donations',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: '#EF4444',
                    tension: 0.1
                }]
            }
        });
    }
};

// Initialize charts when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.initializeCharts();
});

// Add service worker for offline support
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('ServiceWorker registration successful');
            })
            .catch(err => {
                console.log('ServiceWorker registration failed: ', err);
            });
    });
}

// Enhanced Mobile Menu Toggle
const mobileMenuButton = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const dropdowns = document.querySelectorAll('.dropdown-content');

if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        // Add slide animation
        if (!mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('animate-slide-down');
        } else {
            mobileMenu.classList.remove('animate-slide-down');
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
}

// Enhanced Dropdown Functionality
document.querySelectorAll('.dropdown-trigger').forEach(trigger => {
    const dropdown = trigger.nextElementSibling;
    
    trigger.addEventListener('click', (e) => {
        e.preventDefault();
        dropdown.classList.toggle('hidden');
        
        // Close other dropdowns
        dropdowns.forEach(d => {
            if (d !== dropdown) {
                d.classList.add('hidden');
            }
        });
    });
});

// Responsive Navigation
const checkResponsive = () => {
    const width = window.innerWidth;
    const nav = document.querySelector('nav');
    
    if (width < 768) { // Mobile view
        nav.classList.add('mobile-nav');
        if (!mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
        }
    } else { // Desktop view
        nav.classList.remove('mobile-nav');
        mobileMenu.classList.add('hidden');
    }
};

// Check responsive on load and resize
window.addEventListener('load', checkResponsive);
window.addEventListener('resize', checkResponsive);

// Smooth Scroll Enhancement
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            
            // Close mobile menu after clicking
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
            }
        }
    });
});

// Intersection Observer for Animations
const animateOnScroll = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in');
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.animate-on-scroll').forEach((element) => {
    animateOnScroll.observe(element);
});

// Form Validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return true;

    let isValid = true;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^\+?[\d\s-]{10,}$/;

    // Clear previous errors
    form.querySelectorAll('.form-error').forEach(error => error.remove());

    // Validate required fields
    form.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            showError(field, 'This field is required');
        }
    });

    // Validate email fields
    form.querySelectorAll('input[type="email"]').forEach(field => {
        if (field.value && !emailRegex.test(field.value)) {
            isValid = false;
            showError(field, 'Please enter a valid email address');
        }
    });

    // Validate phone fields
    form.querySelectorAll('input[type="tel"]').forEach(field => {
        if (field.value && !phoneRegex.test(field.value)) {
            isValid = false;
            showError(field, 'Please enter a valid phone number');
        }
    });

    return isValid;
}

function showError(field, message) {
    const error = document.createElement('div');
    error.className = 'form-error';
    error.textContent = message;
    field.parentNode.appendChild(error);
}

// Blood Type Compatibility Chart
const bloodCompatibility = {
    'A+': ['A+', 'A-', 'O+', 'O-'],
    'A-': ['A-', 'O-'],
    'B+': ['B+', 'B-', 'O+', 'O-'],
    'B-': ['B-', 'O-'],
    'AB+': ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
    'AB-': ['A-', 'B-', 'AB-', 'O-'],
    'O+': ['O+', 'O-'],
    'O-': ['O-']
};

function updateCompatibleTypes(bloodType) {
    const compatibleTypes = bloodCompatibility[bloodType] || [];
    const compatibilityList = document.getElementById('compatible-types');
    if (compatibilityList) {
        compatibilityList.innerHTML = compatibleTypes.map(type => 
            `<span class="blood-type">${type}</span>`
        ).join('');
    }
}

// Testimonial Carousel
let currentTestimonial = 0;
const testimonials = document.querySelectorAll('.testimonial-card');

function showTestimonial(index) {
    testimonials.forEach((testimonial, i) => {
        testimonial.style.display = i === index ? 'block' : 'none';
    });
}

function nextTestimonial() {
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    showTestimonial(currentTestimonial);
}

function previousTestimonial() {
    currentTestimonial = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
    showTestimonial(currentTestimonial);
}

// Initialize testimonial carousel if exists
if (testimonials.length > 0) {
    showTestimonial(0);
    setInterval(nextTestimonial, 5000); // Auto-advance every 5 seconds
}

// Statistics Counter Animation
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const currentValue = Math.floor(progress * (end - start) + start);
        element.textContent = currentValue.toLocaleString();
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Statistics Observer
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const statsNumber = entry.target;
            const targetValue = parseInt(statsNumber.dataset.target);
            animateValue(statsNumber, 0, targetValue, 2000);
            statsObserver.unobserve(statsNumber);

            // Add hover effect
            statsNumber.style.transition = 'transform 0.3s, color 0.3s';
            statsNumber.addEventListener('mouseenter', () => {
                statsNumber.style.transform = 'scale(1.1)';
                statsNumber.style.color = '#ef4444'; // Tailwind red-500
            });
            statsNumber.addEventListener('mouseleave', () => {
                statsNumber.style.transform = 'scale(1)';
                statsNumber.style.color = '';
            });
        }
    });
}, {
    threshold: 0.5
});

document.querySelectorAll('.stats-number').forEach(number => {
    statsObserver.observe(number);
});

// Scroll Reveal Animation
const scrollRevealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

document.querySelectorAll('.animate-on-scroll').forEach(element => {
    element.style.opacity = '0';
    element.style.transform = 'translateY(20px)';
    element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
    scrollRevealObserver.observe(element);
});

// Page Transition Animation
document.addEventListener('DOMContentLoaded', () => {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href && !href.startsWith('#') && !href.startsWith('tel:') && !href.startsWith('mailto:')) {
            e.preventDefault();
            document.body.style.opacity = '0';
            setTimeout(() => {
                window.location.href = href;
            }, 500);
        }
    });
});

// Timeline Connector Animation
const timelineObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.width = '100%';
        }
    });
}, {
    threshold: 0.5
});

document.querySelectorAll('.timeline-connector').forEach(connector => {
    connector.style.width = '0';
    connector.style.transition = 'width 1s ease-out';
    timelineObserver.observe(connector);
});

// Newsletter Form Submission
const newsletterForm = document.getElementById('newsletter-form');
if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const email = newsletterForm.querySelector('input[type="email"]').value;

        try {
            const response = await fetch('/api/newsletter/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email })
            });

            if (response.ok) {
                showNotification('Success! You have been subscribed to our newsletter.', 'success');
                newsletterForm.reset();
            } else {
                throw new Error('Subscription failed');
            }
        } catch (error) {
            showNotification('Sorry, something went wrong. Please try again later.', 'error');
        }
    });
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 p-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        'bg-blue-500'
    } text-white animate-slide-up`;
    
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.replace('animate-slide-up', 'animate-slide-down');
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Initialize all tooltips
const tooltips = document.querySelectorAll('[data-tooltip]');
tooltips.forEach(element => {
    element.addEventListener('mouseenter', e => {
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute bg-gray-900 text-white text-sm px-2 py-1 rounded -mt-8 -ml-2 opacity-0 transition-opacity duration-200';
        tooltip.textContent = element.dataset.tooltip;
        element.appendChild(tooltip);
        setTimeout(() => tooltip.classList.remove('opacity-0'), 50);
    });

    element.addEventListener('mouseleave', e => {
        const tooltip = element.querySelector('div');
        if (tooltip) {
            tooltip.classList.add('opacity-0');
            setTimeout(() => tooltip.remove(), 200);
        }
    });
}); 