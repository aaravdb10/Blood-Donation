const nodemailer = require('nodemailer');
require('dotenv').config();

// Create reusable transporter object
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASSWORD
    }
});

const gmailService = {
    async initialize() {
        try {
            // Verify transporter configuration
            await transporter.verify();
            console.log('Gmail service is ready to send emails');
            return true;
        } catch (error) {
            console.error('Failed to initialize Gmail service:', error);
            throw new Error('Email service configuration failed: ' + error.message);
        }
    },

    async sendContactEmail({ name, email, message }) {
        try {
            const mailOptions = {
                from: process.env.EMAIL_USER,
                to: process.env.CONTACT_EMAIL,
                subject: `New Contact Form Submission from ${name}`,
                html: `
                    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                        <h2 style="color: #EF4444;">New Contact Form Submission</h2>
                        <p><strong>Name:</strong> ${name}</p>
                        <p><strong>Email:</strong> ${email}</p>
                        <p><strong>Message:</strong></p>
                        <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px;">
                            ${message}
                        </div>
                    </div>
                `
            };

            const info = await transporter.sendMail(mailOptions);
            console.log('Email sent:', info.messageId);
            return info;
        } catch (error) {
            console.error('Error sending email:', error);
            throw new Error('Failed to send email: ' + error.message);
        }
    }
};

module.exports = gmailService; 