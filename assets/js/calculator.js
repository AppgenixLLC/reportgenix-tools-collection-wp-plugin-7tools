/**
 * Conversion Rate Calculator JavaScript
 * Version: 1.0.0
 */

(function() {
    'use strict';

    // Initialize all calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.crc-calculator-wrapper');

        calculators.forEach(function(calculator) {
            initCalculator(calculator);
        });
    });

    function initCalculator(wrapper) {
        const visitorsInput = wrapper.querySelector('.crc-visitors');
        const ordersInput = wrapper.querySelector('.crc-orders');
        const calculateBtn = wrapper.querySelector('.crc-calculate-btn');
        const resetBtn = wrapper.querySelector('.crc-reset-btn');
        const resultDiv = wrapper.querySelector('.crc-result');
        const rateValueSpan = wrapper.querySelector('.crc-rate-value');
        const benchmarkDiv = wrapper.querySelector('.crc-benchmark');
        const copyBtn = wrapper.querySelector('.crc-copy-btn');
        const primaryColor = wrapper.dataset.primaryColor || '#4F46E5';
        const showBenchmark = wrapper.dataset.showBenchmark === 'true';

        // Apply custom primary color
        if (primaryColor !== '#4F46E5') {
            calculateBtn.style.background = primaryColor;
            calculateBtn.addEventListener('mouseenter', function() {
                this.style.background = adjustColor(primaryColor, -20);
            });
            calculateBtn.addEventListener('mouseleave', function() {
                this.style.background = primaryColor;
            });
        }

        // Format number with thousand separators
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Parse formatted number
        function parseFormattedNumber(str) {
            if (!str || str.trim() === '') return 0;
            // Remove all non-numeric characters except decimal point
            const cleaned = str.replace(/[^\d.]/g, '');
            const parsed = parseInt(cleaned, 10);
            return isNaN(parsed) ? 0 : parsed;
        }

        // Format input on blur
        function formatInputValue(input) {
            const rawValue = input.value.trim();
            if (rawValue === '') return; // Don't format empty input

            const value = parseFormattedNumber(rawValue);
            if (value >= 0) { // Allow 0 and positive numbers
                input.value = formatNumber(value);
            } else if (rawValue !== '') {
                // If we can't parse it but it's not empty, keep the original value
                // This prevents clearing the field on invalid input
                return;
            }
        }

        // Remove formatting on focus
        function unformatInputValue(input) {
            const rawValue = input.value.trim();
            if (rawValue === '') return; // Don't process empty input

            const value = parseFormattedNumber(rawValue);
            if (value >= 0) { // Allow 0 and positive numbers
                input.value = value.toString();
            }
        }

        visitorsInput.addEventListener('blur', function() {
            formatInputValue(this);
        });

        visitorsInput.addEventListener('focus', function() {
            unformatInputValue(this);
        });

        ordersInput.addEventListener('blur', function() {
            formatInputValue(this);
        });

        ordersInput.addEventListener('focus', function() {
            unformatInputValue(this);
        });

        // Adjust color brightness
        function adjustColor(color, amount) {
            const num = parseInt(color.replace('#', ''), 16);
            const r = Math.max(0, Math.min(255, (num >> 16) + amount));
            const g = Math.max(0, Math.min(255, ((num >> 8) & 0x00FF) + amount));
            const b = Math.max(0, Math.min(255, (num & 0x0000FF) + amount));
            return '#' + (0x1000000 + (r << 16) + (g << 8) + b).toString(16).slice(1);
        }

        // Clear error
        function clearError(input) {
            const errorSpan = document.getElementById(input.getAttribute('aria-describedby'));
            if (errorSpan) {
                errorSpan.textContent = '';
            }
            input.classList.remove('crc-error-input');
        }

        // Show error
        function showError(input, message) {
            const errorSpan = document.getElementById(input.getAttribute('aria-describedby'));
            if (errorSpan) {
                errorSpan.textContent = message;
            }
            input.classList.add('crc-error-input');
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;

            // Clear previous errors
            clearError(visitorsInput);
            clearError(ordersInput);

            const visitors = parseFormattedNumber(visitorsInput.value);
            const orders = parseFormattedNumber(ordersInput.value);

            // Validate visitors
            if (!visitorsInput.value || visitors <= 0) {
                showError(visitorsInput, 'Please enter a valid number of visitors');
                isValid = false;
            }

            // Validate orders
            if (!ordersInput.value || orders < 0) {
                showError(ordersInput, 'Please enter a valid number of orders');
                isValid = false;
            }

            // Check if orders exceed visitors
            if (isValid && orders > visitors) {
                showError(ordersInput, 'Orders cannot exceed total visitors');
                isValid = false;
            }

            return isValid;
        }

        // Calculate conversion rate
        function calculateConversionRate() {
            if (!validateInputs()) {
                return;
            }

            const visitors = parseFormattedNumber(visitorsInput.value);
            const orders = parseFormattedNumber(ordersInput.value);

            const conversionRate = (orders / visitors) * 100;
            const formattedRate = conversionRate.toFixed(2);

            // Display result
            rateValueSpan.textContent = formattedRate + '%';
            resultDiv.style.display = 'block';

            // Show benchmark if enabled
            if (showBenchmark && benchmarkDiv) {
                let benchmarkText = '';
                let benchmarkClass = '';

                if (conversionRate < 1) {
                    benchmarkText = '🔴 Needs Improvement - Your conversion rate is below industry average';
                    benchmarkClass = 'crc-needs-improvement';
                } else if (conversionRate >= 1 && conversionRate < 3) {
                    benchmarkText = '🟡 Average - You\'re on par with industry standards';
                    benchmarkClass = 'crc-average';
                } else if (conversionRate >= 3 && conversionRate <= 5) {
                    benchmarkText = '🟢 Good - You\'re performing above average!';
                    benchmarkClass = 'crc-good';
                } else {
                    benchmarkText = '🌟 Excellent - Outstanding conversion rate!';
                    benchmarkClass = 'crc-excellent';
                }

                benchmarkDiv.textContent = benchmarkText;
                benchmarkDiv.className = 'crc-benchmark ' + benchmarkClass;
            }

            // Scroll to result smoothly
            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            // Announce result to screen readers
            const announcement = 'Conversion rate calculated: ' + formattedRate + ' percent';
            announceToScreenReader(announcement);
        }

        // Reset calculator
        function resetCalculator() {
            visitorsInput.value = '';
            ordersInput.value = '';
            clearError(visitorsInput);
            clearError(ordersInput);
            resultDiv.style.display = 'none';
            visitorsInput.focus();

            // Reset copy button
            if (copyBtn) {
                const copyText = copyBtn.querySelector('.crc-copy-text');
                copyText.textContent = 'Copy';
                copyBtn.classList.remove('crc-copied');
            }
        }

        // Copy to clipboard
        function copyToClipboard() {
            const rateText = rateValueSpan.textContent;
            const copyText = copyBtn.querySelector('.crc-copy-text');

            // Modern clipboard API
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText('Conversion Rate: ' + rateText).then(function() {
                    copyText.textContent = 'Copied!';
                    copyBtn.classList.add('crc-copied');
                    announceToScreenReader('Result copied to clipboard');

                    setTimeout(function() {
                        copyText.textContent = 'Copy';
                        copyBtn.classList.remove('crc-copied');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Failed to copy:', err);
                    alert('Failed to copy to clipboard');
                });
            } else {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = 'Conversion Rate: ' + rateText;
                textArea.style.position = 'fixed';
                textArea.style.left = '-9999px';
                document.body.appendChild(textArea);
                textArea.select();

                try {
                    document.execCommand('copy');
                    copyText.textContent = 'Copied!';
                    copyBtn.classList.add('crc-copied');
                    announceToScreenReader('Result copied to clipboard');

                    setTimeout(function() {
                        copyText.textContent = 'Copy';
                        copyBtn.classList.remove('crc-copied');
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy:', err);
                    alert('Failed to copy to clipboard');
                }

                document.body.removeChild(textArea);
            }
        }

        // Announce to screen readers
        function announceToScreenReader(message) {
            const announcement = document.createElement('div');
            announcement.setAttribute('role', 'status');
            announcement.setAttribute('aria-live', 'polite');
            announcement.className = 'sr-only';
            announcement.style.position = 'absolute';
            announcement.style.left = '-10000px';
            announcement.style.width = '1px';
            announcement.style.height = '1px';
            announcement.style.overflow = 'hidden';
            announcement.textContent = message;
            document.body.appendChild(announcement);

            setTimeout(function() {
                document.body.removeChild(announcement);
            }, 1000);
        }

        // Event listeners
        calculateBtn.addEventListener('click', calculateConversionRate);
        resetBtn.addEventListener('click', resetCalculator);

        if (copyBtn) {
            copyBtn.addEventListener('click', copyToClipboard);
        }

        // Enter key support
        visitorsInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                calculateConversionRate();
            }
        });

        ordersInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                calculateConversionRate();
            }
        });

        // Clear errors on input
        visitorsInput.addEventListener('input', function() {
            clearError(this);
        });

        ordersInput.addEventListener('input', function() {
            clearError(this);
        });
    }
})();
