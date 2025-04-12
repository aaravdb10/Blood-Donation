// Blood Donation and Camp Management
class BloodDonation {
    static async requestBlood(requestData) {
        try {
            const response = await fetch('/api/blood/request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify(requestData)
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

    static async getBloodCamps() {
        try {
            const response = await fetch('/api/blood/camps', {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
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

    static async scheduleDonation(donationData) {
        try {
            const response = await fetch('/api/blood/schedule', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify(donationData)
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
}

// Event Listeners for Blood Request Form
document.addEventListener('DOMContentLoaded', () => {
    const requestForm = document.getElementById('request-form');
    if (requestForm) {
        requestForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                patientName: requestForm.querySelector('input[name="patient_name"]').value,
                bloodType: requestForm.querySelector('select[name="blood_type"]').value,
                units: requestForm.querySelector('input[name="units"]').value,
                hospital: requestForm.querySelector('input[name="hospital"]').value,
                urgency: requestForm.querySelector('select[name="urgency"]').value,
                contactPerson: requestForm.querySelector('input[name="contact_person"]').value,
                contactPhone: requestForm.querySelector('input[name="contact_phone"]').value
            };

            const result = await BloodDonation.requestBlood(formData);
            if (result.success) {
                showSuccess('Blood request submitted successfully');
                requestForm.reset();
            } else {
                showError(result.error.message || 'Failed to submit blood request');
            }
        });
    }

    // Load and display blood camps
    const campsContainer = document.getElementById('blood-camps');
    if (campsContainer) {
        BloodDonation.getBloodCamps().then(result => {
            if (result.success) {
                displayBloodCamps(result.data.camps);
            } else {
                showError('Failed to load blood camps');
            }
        });
    }
});

// Helper function to display blood camps
function displayBloodCamps(camps) {
    const campsContainer = document.getElementById('blood-camps');
    if (!campsContainer) return;

    campsContainer.innerHTML = camps.map(camp => `
        <div class="card border-l-4 border-primary animate-on-scroll">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-semibold mb-2">${camp.name}</h3>
                    <p class="text-gray-600 mb-4">
                        <i class="far fa-calendar mr-2"></i>${new Date(camp.date).toLocaleDateString()}<br>
                        <i class="far fa-clock mr-2"></i>${camp.startTime} - ${camp.endTime}<br>
                        <i class="fas fa-map-marker-alt mr-2"></i>${camp.location}<br>
                        ${camp.address}
                    </p>
                    <span class="text-gray-500">${camp.availableSlots} spots available</span>
                </div>
                <button onclick="scheduleDonation(${camp.id})" class="btn-primary">Schedule Appointment</button>
            </div>
        </div>
    `).join('');
}

// Helper function to show success messages
function showSuccess(message) {
    const successDiv = document.createElement('div');
    successDiv.className = 'bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4';
    successDiv.innerHTML = `
        <span class="block sm:inline">${message}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    `;
    
    const form = document.querySelector('form');
    form.insertBefore(successDiv, form.firstChild);
    
    // Remove success message after 5 seconds
    setTimeout(() => {
        successDiv.remove();
    }, 5000);
}

// Global function to schedule donation
window.scheduleDonation = async function(campId) {
    if (!Auth.isAuthenticated()) {
        showError('Please login to schedule a donation');
        return;
    }

    const result = await BloodDonation.scheduleDonation({ campId });
    if (result.success) {
        showSuccess('Donation scheduled successfully');
    } else {
        showError(result.error.message || 'Failed to schedule donation');
    }
}; 