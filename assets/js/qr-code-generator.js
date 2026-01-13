/**
 * QR Code Generator JavaScript
 * Version: 1.0.0
 */

(function() {
    'use strict';

    // Wait for QRCode library to load
    function waitForQRCode(callback) {
        if (typeof QRCode !== 'undefined') {
            callback();
        } else {
            setTimeout(function() {
                waitForQRCode(callback);
            }, 100);
        }
    }

    // Initialize all QR code generators on the page
    document.addEventListener('DOMContentLoaded', function() {
        waitForQRCode(function() {
            const generators = document.querySelectorAll('.qr-gen-wrapper');

            generators.forEach(function(generator) {
                initGenerator(generator);
            });
        });
    });

    function initGenerator(wrapper) {
        // Get DOM elements
        const tabs = wrapper.querySelectorAll('.qr-gen-tab');
        const tabContents = wrapper.querySelectorAll('.qr-gen-tab-content');
        const qrContainer = wrapper.querySelector('.qr-gen-qr-container');
        const placeholder = wrapper.querySelector('.qr-gen-placeholder');
        const downloadBtn = wrapper.querySelector('.qr-gen-download');

        // Input elements for each tab
        const urlInput = wrapper.querySelector('.qr-gen-url-input');
        const urlError = wrapper.querySelector('.qr-gen-url-error');

        const phoneInput = wrapper.querySelector('.qr-gen-phone-input');
        const phoneError = wrapper.querySelector('.qr-gen-phone-error');

        const smsPhoneInput = wrapper.querySelector('.qr-gen-sms-phone-input');
        const smsMessageInput = wrapper.querySelector('.qr-gen-sms-message-input');
        const smsError = wrapper.querySelector('.qr-gen-sms-error');

        const textInput = wrapper.querySelector('.qr-gen-text-input');
        const textError = wrapper.querySelector('.qr-gen-text-error');

        let qrCode = null;
        let debounceTimer = null;
        let currentQRData = '';

        // Tab switching
        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                const targetType = this.dataset.type;

                // Update active tab
                tabs.forEach(function(t) {
                    t.classList.remove('active');
                });
                this.classList.add('active');

                // Update active content
                tabContents.forEach(function(content) {
                    content.classList.remove('active');
                });
                const targetContent = wrapper.querySelector('[data-content="' + targetType + '"]');
                if (targetContent) {
                    targetContent.classList.add('active');
                }

                // Clear QR code and regenerate
                clearQRCode();
                generateQRCode();
            });
        });

        // Input validation functions
        function validateURL(url) {
            if (!url || url.trim() === '') {
                return { valid: false, message: 'Please enter a URL' };
            }

            // Check if URL starts with http:// or https://
            if (!url.match(/^https?:\/\//i)) {
                return { valid: false, message: 'URL must start with http:// or https://' };
            }

            // Basic URL validation
            try {
                new URL(url);
                return { valid: true };
            } catch (e) {
                return { valid: false, message: 'Please enter a valid URL' };
            }
        }

        function validatePhone(phone) {
            if (!phone || phone.trim() === '') {
                return { valid: false, message: 'Please enter a phone number' };
            }

            // Remove spaces and check if it contains only digits, +, -, (, )
            const cleanPhone = phone.replace(/[\s\-()]/g, '');
            if (!cleanPhone.match(/^\+?[0-9]{10,15}$/)) {
                return { valid: false, message: 'Please enter a valid phone number (e.g., +1234567890)' };
            }

            return { valid: true };
        }

        function validateSMS(phone, message) {
            if (!phone || phone.trim() === '') {
                return { valid: false, message: 'Please enter a phone number' };
            }

            const phoneValidation = validatePhone(phone);
            if (!phoneValidation.valid) {
                return phoneValidation;
            }

            if (!message || message.trim() === '') {
                return { valid: false, message: 'Please enter a message' };
            }

            return { valid: true };
        }

        function validateText(text) {
            if (!text || text.trim() === '') {
                return { valid: false, message: 'Please enter some text' };
            }

            return { valid: true };
        }

        // Show/hide error messages
        function showError(errorElement, message) {
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.add('active');
            }
        }

        function hideError(errorElement) {
            if (errorElement) {
                errorElement.classList.remove('active');
            }
        }

        // Clear QR code
        function clearQRCode() {
            qrContainer.innerHTML = '';
            qrCode = null;
            currentQRData = '';
            placeholder.style.display = 'block';
            downloadBtn.disabled = true;
        }

        // Generate QR code based on active tab
        function generateQRCode() {
            // Get active tab
            const activeTab = wrapper.querySelector('.qr-gen-tab.active');
            if (!activeTab) return;

            const dataType = activeTab.dataset.type;
            let qrData = '';
            let validation = { valid: false };

            // Get data and validate based on type
            switch (dataType) {
                case 'url':
                    const url = urlInput.value.trim();
                    validation = validateURL(url);
                    hideError(urlError);

                    if (!url) {
                        clearQRCode();
                        return;
                    }

                    if (!validation.valid) {
                        clearQRCode();
                        showError(urlError, validation.message);
                        return;
                    }

                    qrData = url;
                    break;

                case 'phone':
                    const phone = phoneInput.value.trim();
                    validation = validatePhone(phone);
                    hideError(phoneError);

                    if (!phone) {
                        clearQRCode();
                        return;
                    }

                    if (!validation.valid) {
                        clearQRCode();
                        showError(phoneError, validation.message);
                        return;
                    }

                    qrData = 'tel:' + phone;
                    break;

                case 'sms':
                    const smsPhone = smsPhoneInput.value.trim();
                    const smsMessage = smsMessageInput.value.trim();
                    validation = validateSMS(smsPhone, smsMessage);
                    hideError(smsError);

                    if (!smsPhone && !smsMessage) {
                        clearQRCode();
                        return;
                    }

                    if (!validation.valid) {
                        clearQRCode();
                        showError(smsError, validation.message);
                        return;
                    }

                    qrData = 'SMSTO:' + smsPhone + ':' + smsMessage;
                    break;

                case 'text':
                    const text = textInput.value.trim();
                    validation = validateText(text);
                    hideError(textError);

                    if (!text) {
                        clearQRCode();
                        return;
                    }

                    if (!validation.valid) {
                        clearQRCode();
                        showError(textError, validation.message);
                        return;
                    }

                    qrData = text;
                    break;
            }

            // Generate QR code
            if (validation.valid && qrData) {
                try {
                    // Clear previous QR code
                    qrContainer.innerHTML = '';

                    // Create new QR code
                    qrCode = new QRCode(qrContainer, {
                        text: qrData,
                        width: 200,
                        height: 200,
                        colorDark: '#000000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });

                    currentQRData = qrData;
                    placeholder.style.display = 'none';
                    downloadBtn.disabled = false;
                } catch (error) {
                    clearQRCode();
                    const activeError = getActiveErrorElement();
                    if (activeError) {
                        showError(activeError, 'Failed to generate QR code: ' + error.message);
                    }
                }
            }
        }

        // Get active error element
        function getActiveErrorElement() {
            const activeTab = wrapper.querySelector('.qr-gen-tab.active');
            if (!activeTab) return null;

            const dataType = activeTab.dataset.type;
            switch (dataType) {
                case 'url': return urlError;
                case 'phone': return phoneError;
                case 'sms': return smsError;
                case 'text': return textError;
                default: return null;
            }
        }

        // Debounced QR generation
        function debouncedGenerate() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function() {
                generateQRCode();
            }, 300);
        }

        // Download QR code as PNG
        function downloadQRCode() {
            if (!qrCode || !currentQRData) {
                return;
            }

            try {
                // Get the canvas element (QRCode.js creates a canvas)
                const canvas = qrContainer.querySelector('canvas');
                if (!canvas) {
                    // Try to get image instead
                    const img = qrContainer.querySelector('img');
                    if (img) {
                        // Create a canvas from the image
                        const newCanvas = document.createElement('canvas');
                        newCanvas.width = 200;
                        newCanvas.height = 200;
                        const ctx = newCanvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        downloadFromCanvas(newCanvas);
                    }
                    return;
                }

                downloadFromCanvas(canvas);
            } catch (error) {
                const activeError = getActiveErrorElement();
                if (activeError) {
                    showError(activeError, 'Failed to download QR code: ' + error.message);
                }
            }
        }

        // Download from canvas
        function downloadFromCanvas(canvas) {
            canvas.toBlob(function(blob) {
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                const timestamp = new Date().getTime();
                link.download = 'qrcode-' + timestamp + '.png';
                link.href = url;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                URL.revokeObjectURL(url);
            }, 'image/png');
        }

        // Event listeners for all inputs
        if (urlInput) {
            urlInput.addEventListener('input', debouncedGenerate);
        }

        if (phoneInput) {
            phoneInput.addEventListener('input', debouncedGenerate);
        }

        if (smsPhoneInput) {
            smsPhoneInput.addEventListener('input', debouncedGenerate);
        }

        if (smsMessageInput) {
            smsMessageInput.addEventListener('input', debouncedGenerate);
        }

        if (textInput) {
            textInput.addEventListener('input', debouncedGenerate);
        }

        // Download button
        downloadBtn.addEventListener('click', downloadQRCode);

        // Initial state
        clearQRCode();
    }

})();
