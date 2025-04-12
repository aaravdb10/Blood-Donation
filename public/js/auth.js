// Authentication Functions
class Auth {
    static async login(email, password) {
        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ email, password })
            });

            if (response.ok) {
                const data = await response.json();
                localStorage.setItem('token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));
                return { success: true, data };
            } else {
                const error = await response.json();
                return { success: false, error };
            }
        } catch (error) {
            return { success: false, error: 'Network error occurred' };
        }
    }

    static async register(userData) {
        try {
            const response = await fetch('/api/auth/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(userData)
            });

            if (response.ok) {
                const data = await response.json();
                return { success: true, data };
            } else {
                const error = await response.json();
                return { success: false, error };
            }
        } catch (error) {
            return { success: false, error: 'Network error occurred' };
        }
    }

    static async logout() {
        try {
            const response = await fetch('/api/auth/logout', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });

            if (response.ok) {
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                return { success: true };
            } else {
                const error = await response.json();
                return { success: false, error };
            }
        } catch (error) {
            return { success: false, error: 'Network error occurred' };
        }
    }

    static isAuthenticated() {
        return !!localStorage.getItem('token');
    }

    static getUser() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }
}

// Form Validation
class FormValidator {
    static validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    static validatePassword(password) {
        return password.length >= 8;
    }

    static validatePhone(phone) {
        const re = /^\+?[\d\s-]{10,}$/;
        return re.test(phone);
    }

    static validateBloodType(bloodType) {
        const validTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
        return validTypes.includes(bloodType);
    }
}

// Event Listeners for Login Form
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const email = loginForm.querySelector('input[type="email"]').value;
            const password = loginForm.querySelector('input[type="password"]').value;

            if (!FormValidator.validateEmail(email)) {
                showError('Please enter a valid email address');
                return;
            }

            const result = await Auth.login(email, password);
            if (result.success) {
                window.location.href = '/dashboard';
            } else {
                showError(result.error.message || 'Login failed');
            }
        });
    }

    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                name: registerForm.querySelector('input[name="name"]').value,
                email: registerForm.querySelector('input[type="email"]').value,
                password: registerForm.querySelector('input[type="password"]').value,
                phone: registerForm.querySelector('input[type="tel"]').value,
                bloodType: registerForm.querySelector('select[name="blood_type"]').value,
                address: registerForm.querySelector('textarea[name="address"]').value
            };

            // Validate form data
            if (!FormValidator.validateEmail(formData.email)) {
                showError('Please enter a valid email address');
                return;
            }

            if (!FormValidator.validatePassword(formData.password)) {
                showError('Password must be at least 8 characters long');
                return;
            }

            if (!FormValidator.validatePhone(formData.phone)) {
                showError('Please enter a valid phone number');
                return;
            }

            if (!FormValidator.validateBloodType(formData.bloodType)) {
                showError('Please select a valid blood type');
                return;
            }

            const result = await Auth.register(formData);
            if (result.success) {
                window.location.href = '/dashboard';
            } else {
                showError(result.error.message || 'Registration failed');
            }
        });
    }
});

// Helper function to show errors
function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4';
    errorDiv.innerHTML = `
        <span class="block sm:inline">${message}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    `;
    
    const form = document.querySelector('form');
    form.insertBefore(errorDiv, form.firstChild);
    
    // Remove error after 5 seconds
    setTimeout(() => {
        errorDiv.remove();
    }, 5000);
} 