/**
 * Barcode Generator JavaScript
 * Version: 1.0.0
 */

(function() {
    'use strict';

    // Wait for JsBarcode library to load
    function waitForJsBarcode(callback) {
        if (typeof JsBarcode !== 'undefined') {
            callback();
        } else {
            setTimeout(function() {
                waitForJsBarcode(callback);
            }, 100);
        }
    }

    // Initialize all barcode generators on the page
    document.addEventListener('DOMContentLoaded', function() {
        waitForJsBarcode(function() {
            const generators = document.querySelectorAll('.barcode-gen-wrapper');

            generators.forEach(function(generator) {
                initGenerator(generator);
            });
        });
    });

    function initGenerator(wrapper) {
        // Get DOM elements
        const dataInput = wrapper.querySelector('.barcode-gen-data-input');
        const typeSelect = wrapper.querySelector('.barcode-gen-type-select');
        const canvas = wrapper.querySelector('.barcode-gen-canvas');
        const placeholder = wrapper.querySelector('.barcode-gen-placeholder');
        const errorMessage = wrapper.querySelector('.barcode-gen-error');
        const downloadBtn = wrapper.querySelector('.barcode-gen-download');

        let currentBarcodeData = '';

        // Barcode type validation rules
        const validationRules = {
            'CODE128': {
                pattern: /^[\x00-\x7F]+$/,
                message: 'CODE128 accepts any ASCII characters',
                length: null
            },
            'CODE39': {
                pattern: /^[0-9A-Z\-. $/+%]+$/,
                message: 'CODE39 accepts: 0-9, A-Z, and - . $ / + % space',
                length: null
            },
            'EAN13': {
                pattern: /^\d{13}$/,
                message: 'EAN13 requires exactly 13 digits',
                length: 13
            },
            'EAN8': {
                pattern: /^\d{8}$/,
                message: 'EAN8 requires exactly 8 digits',
                length: 8
            },
            'UPC': {
                pattern: /^\d{12}$/,
                message: 'UPC (UPC-A) requires exactly 12 digits',
                length: 12
            }
        };

        // Validate barcode data based on type
        function validateBarcodeData(data, type) {
            if (!data || data.trim() === '') {
                return {
                    valid: false,
                    message: 'Please enter barcode data'
                };
            }

            const rules = validationRules[type];
            if (!rules) {
                return {
                    valid: false,
                    message: 'Invalid barcode type'
                };
            }

            if (!rules.pattern.test(data)) {
                return {
                    valid: false,
                    message: rules.message
                };
            }

            return { valid: true };
        }

        // Show error message
        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.classList.add('active');
        }

        // Hide error message
        function hideError() {
            errorMessage.classList.remove('active');
        }

        // Generate barcode
        function generateBarcode() {
            const data = dataInput.value.trim();
            const type = typeSelect.value;

            // Hide previous error
            hideError();

            // If empty, show placeholder
            if (!data) {
                canvas.style.display = 'none';
                placeholder.style.display = 'block';
                downloadBtn.disabled = true;
                currentBarcodeData = '';
                return;
            }

            // Validate input
            const validation = validateBarcodeData(data, type);
            if (!validation.valid) {
                canvas.style.display = 'none';
                placeholder.style.display = 'block';
                downloadBtn.disabled = true;
                showError(validation.message);
                currentBarcodeData = '';
                return;
            }

            // Try to generate barcode
            try {
                canvas.style.display = 'block';
                placeholder.style.display = 'none';

                // Configure JsBarcode options based on type
                const options = {
                    format: type,
                    width: 2,
                    height: 80,
                    displayValue: true,
                    fontSize: 14,
                    margin: 10,
                    background: '#ffffff',
                    lineColor: '#000000'
                };

                // Special handling for different barcode types
                if (type === 'EAN13' || type === 'EAN8') {
                    options.flat = true;
                } else if (type === 'UPC') {
                    options.format = 'UPC';
                }

                JsBarcode(canvas, data, options);

                downloadBtn.disabled = false;
                currentBarcodeData = data;
            } catch (error) {
                canvas.style.display = 'none';
                placeholder.style.display = 'block';
                downloadBtn.disabled = true;
                showError('Failed to generate barcode: ' + error.message);
                currentBarcodeData = '';
            }
        }

        // Download barcode as PNG
        function downloadBarcode() {
            if (!currentBarcodeData) {
                return;
            }

            try {
                // Convert canvas to blob
                canvas.toBlob(function(blob) {
                    // Create download link
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');

                    // Sanitize filename
                    const sanitizedData = currentBarcodeData
                        .replace(/[^a-z0-9]/gi, '-')
                        .toLowerCase()
                        .substring(0, 50);

                    link.download = 'barcode-' + sanitizedData + '.png';
                    link.href = url;

                    // Trigger download
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Cleanup
                    URL.revokeObjectURL(url);
                }, 'image/png');
            } catch (error) {
                showError('Failed to download barcode: ' + error.message);
            }
        }

        // Event listeners
        dataInput.addEventListener('input', function() {
            generateBarcode();
        });

        typeSelect.addEventListener('change', function() {
            generateBarcode();
        });

        downloadBtn.addEventListener('click', function() {
            downloadBarcode();
        });

        // Initial state
        canvas.style.display = 'none';
        placeholder.style.display = 'block';
        downloadBtn.disabled = true;
    }

})();
