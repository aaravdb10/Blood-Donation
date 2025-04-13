const nodemailer = require('nodemailer');
require('dotenv').config();

// Create a transporter using Gmail
const transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASSWORD
    }
});

// Verify transporter configuration
const verifyTransporter = async () => {
    try {
        await transporter.verify();
        console.log('Email server is ready to send messages');
        return true;
    } catch (error) {
        console.error('Email configuration error:', error);
        throw new Error('Email service configuration failed: ' + error.message);
    }
};

// Email service functions
const emailService = {
    verifyTransporter,
    
    // Send contact form email
    sendContactEmail: async (formData) => {
        const { name, email, message } = formData;
        
        const mailOptions = {
            from: `"LifeFlow Contact Form" <${process.env.EMAIL_USER}>`,
            to: process.env.CONTACT_EMAIL,
            replyTo: email,
            subject: 'New Contact Form Submission',
            html: `
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h2 style="color: #EF4444;">New Contact Form Submission</h2>
                    <div style="background-color: #f9fafb; padding: 20px; border-radius: 8px;">
                        <p><strong>Name:</strong> ${name}</p>
                        <p><strong>Email:</strong> ${email}</p>
                        <p><strong>Message:</strong></p>
                        <p style="white-space: pre-wrap;">${message}</p>
                    </div>
                    <p style="margin-top: 20px; color: #6b7280; font-size: 12px;">
                        This email was sent from the LifeFlow contact form.
                    </p>
                </div>
            `
        };

        try {
            const info = await transporter.sendMail(mailOptions);
            console.log('Email sent:', info.messageId);
            return { success: true, messageId: info.messageId };
        } catch (error) {
            console.error('Error sending email:', error);
            throw new Error(`Failed to send email: ${error.message}`);
        }
    },

    // Send verification email
    sendVerificationEmail: async (email, token) => {
        const verificationLink = `${process.env.CORS_ORIGIN}/verify?token=${token}`;
        
        const mailOptions = {
            from: `"LifeFlow" <${process.env.EMAIL_USER}>`,
            to: email,
            subject: 'Verify Your Email Address',
            html: `
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <h2 style="color: #EF4444;">Email Verification</h2>
                    <div style="background-color: #f9fafb; padding: 20px; border-radius: 8px;">
                        <p>Please click the button below to verify your email address:</p>
                        <a href="${verificationLink}" 
                           style="display: inline-block; background-color: #EF4444; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin: 20px 0;">
                            Verify Email
                        </a>
                        <p>If you did not request this verification, please ignore this email.</p>
                    </div>
                    <p style="margin-top: 20px; color: #6b7280; font-size: 12px;">
                        This email was sent from LifeFlow.
                    </p>
                </div>
            `
        };

        try {
            const info = await transporter.sendMail(mailOptions);
            return { success: true, messageId: info.messageId };
        } catch (error) {
            console.error('Error sending verification email:', error);
            throw new Error(`Failed to send verification email: ${error.message}`);
        }
    }
};

module.exports = emailService; 