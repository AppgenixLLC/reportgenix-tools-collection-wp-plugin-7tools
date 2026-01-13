/**
 * Gross Profit Calculator JavaScript
 * Version: 2.0.0
 */

(function() {
    'use strict';

    // Initialize all calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.gpc-wrapper');

        calculators.forEach(function(calculator) {
            initCalculator(calculator);
        });
    });

    function initCalculator(wrapper) {
        // Get all DOM elements
        const salesPriceInput = wrapper.querySelector('.gpc-sales-price');
        const cogsInput = wrapper.querySelector('.gpc-cogs');
        const itemsSlider = wrapper.querySelector('.gpc-slider');
        const itemsNumber = wrapper.querySelector('.gpc-number-input');
        const profitValue = wrapper.querySelector('[id$="-profit-value"]');
        const marginValue = wrapper.querySelector('[id$="-margin-value"]');
        const indicatorFill = wrapper.querySelector('[id$="-indicator-fill"]');
        const indicatorLabel = wrapper.querySelector('[id$="-indicator-label"]');
        const profitCard = wrapper.querySelector('.gpc-profit-card');

        // Get settings from data attributes
        const currency = wrapper.dataset.currency || '$';
        const maxItems = parseInt(wrapper.dataset.maxItems) || 1000;
        const primaryColor = wrapper.dataset.primaryColor || '#4F46E5';
        const profitColor = wrapper.dataset.profitColor || '#10B981';

        // Apply custom colors
        applyCustomColors(wrapper, primaryColor, profitColor);

        // Format currency input on blur
        salesPriceInput.addEventListener('blur', function() {
            formatCurrencyInput(this);
        });

        cogsInput.addEventListener('blur', function() {
            formatCurrencyInput(this);
        });

        // Remove formatting on focus
        salesPriceInput.addEventListener('focus', function() {
            unformatCurrencyInput(this);
        });

        cogsInput.addEventListener('focus', function() {
            unformatCurrencyInput(this);
        });

        // Real-time calculation on input
        salesPriceInput.addEventListener('input', function() {
            calculate();
        });

        cogsInput.addEventListener('input', function() {
            calculate();
        });

        // Sync slider and number input
        itemsSlider.addEventListener('input', function() {
            itemsNumber.value = this.value;
            calculate();
        });

        itemsNumber.addEventListener('input', function() {
            let value = parseInt(this.value) || 1;

            // Enforce min/max
            if (value < 1) value = 1;
            if (value > maxItems) value = maxItems;

            this.value = value;
            itemsSlider.value = value;
            calculate();
        });

        // Prevent negative numbers in number input
        itemsNumber.addEventListener('keydown', function(e) {
            if (e.key === '-' || e.key === 'e' || e.key === 'E' || e.key === '+') {
                e.preventDefault();
            }
        });

        // Format currency input
        function formatCurrencyInput(input) {
            const value = parseFloat(input.value.replace(/[^0-9.]/g, '')) || 0;
            input.value = formatCurrency(value);
        }

        // Remove formatting from currency input
        function unformatCurrencyInput(input) {
            const value = parseFloat(input.value.replace(/[^0-9.]/g, '')) || 0;
            input.value = value.toFixed(2);
        }

        // Format number as currency
        function formatCurrency(value) {
            return value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Format percentage
        function formatPercentage(value) {
            return value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + '%';
        }

        // Calculate gross profit and margin
        function calculate() {
            // Get input values
            const salesPrice = parseFloat(salesPriceInput.value.replace(/[^0-9.]/g, '')) || 0;
            const cogs = parseFloat(cogsInput.value.replace(/[^0-9.]/g, '')) || 0;
            const items = parseInt(itemsSlider.value) || 0;

            // Calculate gross profit
            const profitPerUnit = salesPrice - cogs;
            const grossProfit = profitPerUnit * items;

            // Calculate gross profit margin
            let marginPercentage = 0;
            if (salesPrice > 0) {
                marginPercentage = (profitPerUnit / salesPrice) * 100;
            }

            // Update profit display
            const profitFormatted = currency + formatCurrency(Math.abs(grossProfit));
            profitValue.textContent = (grossProfit < 0 ? '-' : '') + profitFormatted;

            // Add/remove negative class
            if (grossProfit < 0) {
                profitCard.classList.add('negative');
            } else {
                profitCard.classList.remove('negative');
            }

            // Update margin display
            marginValue.textContent = formatPercentage(Math.abs(marginPercentage));

            // Update margin indicator
            updateMarginIndicator(marginPercentage);
        }

        // Update margin indicator bar and label
        function updateMarginIndicator(margin) {
            let labelText = '';
            let labelClass = '';
            let fillWidth = 0;

            if (margin <= 0) {
                labelText = 'Loss - Review your pricing';
                labelClass = 'low';
                fillWidth = 0;
            } else if (margin < 20) {
                labelText = 'Low Margin - Consider cost optimization';
                labelClass = 'low';
                fillWidth = (margin / 20) * 25; // 0-25% of bar
            } else if (margin < 30) {
                labelText = 'Fair Margin - Room for improvement';
                labelClass = 'fair';
                fillWidth = 25 + ((margin - 20) / 10) * 25; // 25-50% of bar
            } else if (margin < 50) {
                labelText = 'Good Margin - Strong profitability';
                labelClass = 'good';
                fillWidth = 50 + ((margin - 30) / 20) * 25; // 50-75% of bar
            } else {
                labelText = 'Excellent Margin - Outstanding!';
                labelClass = 'excellent';
                fillWidth = 75 + Math.min((margin - 50) / 50 * 25, 25); // 75-100% of bar
            }

            // Cap at 100%
            fillWidth = Math.min(fillWidth, 100);

            // Update indicator
            indicatorFill.style.width = fillWidth + '%';
            indicatorLabel.textContent = labelText;

            // Remove all label classes
            indicatorLabel.classList.remove('excellent', 'good', 'fair', 'low');

            // Add appropriate class
            if (labelClass) {
                indicatorLabel.classList.add(labelClass);
            }
        }

        // Apply custom colors
        function applyCustomColors(wrapper, primary, profit) {
            // Apply primary color to slider
            const style = document.createElement('style');
            const wrapperId = wrapper.id;

            style.textContent = `
                #${wrapperId} .gpc-slider::-webkit-slider-thumb {
                    background: ${primary};
                }
                #${wrapperId} .gpc-slider::-moz-range-thumb {
                    background: ${primary};
                }
                #${wrapperId} .gpc-slider::-webkit-slider-thumb:hover {
                    background: ${adjustColor(primary, -20)};
                }
                #${wrapperId} .gpc-slider::-moz-range-thumb:hover {
                    background: ${adjustColor(primary, -20)};
                }
                #${wrapperId} .gpc-input-wrapper:focus-within {
                    border-color: ${primary};
                    box-shadow: 0 0 0 3px ${hexToRgba(primary, 0.1)};
                }
                #${wrapperId} .gpc-number-input:focus {
                    border-color: ${primary};
                    box-shadow: 0 0 0 3px ${hexToRgba(primary, 0.1)};
                }
                #${wrapperId} .gpc-margin-card {
                    border-left-color: ${primary};
                }
                #${wrapperId} .gpc-margin-card .gpc-result-value {
                    color: ${primary};
                }
                #${wrapperId} .gpc-profit-card {
                    border-left-color: ${profit};
                }
                #${wrapperId} .gpc-profit-card .gpc-result-value {
                    color: ${profit};
                }
            `;

            document.head.appendChild(style);
        }

        // Adjust color brightness
        function adjustColor(color, amount) {
            const num = parseInt(color.replace('#', ''), 16);
            const r = Math.max(0, Math.min(255, (num >> 16) + amount));
            const g = Math.max(0, Math.min(255, ((num >> 8) & 0x00FF) + amount));
            const b = Math.max(0, Math.min(255, (num & 0x0000FF) + amount));
            return '#' + ((r << 16) | (g << 8) | b).toString(16).padStart(6, '0');
        }

        // Convert hex to rgba
        function hexToRgba(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }

        // Initial calculation
        calculate();
    }

})();
