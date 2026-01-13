/**
 * POD Profit Calculator JavaScript
 * Version: 1.0.0
 */

(function() {
    'use strict';

    // Initialize all calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.podpc-wrapper');

        calculators.forEach(function(calculator) {
            initCalculator(calculator);
        });
    });

    function initCalculator(wrapper) {
        // Get all DOM elements
        const sellingPriceInput = wrapper.querySelector('.podpc-selling-price');
        const shippingInput = wrapper.querySelector('.podpc-shipping');
        const itemsInput = wrapper.querySelector('.podpc-items');
        const marketingInput = wrapper.querySelector('.podpc-marketing');
        const productCostsInput = wrapper.querySelector('.podpc-product-costs');
        const otherFeesInput = wrapper.querySelector('.podpc-other-fees');

        const revenueValue = wrapper.querySelector('[id$="-revenue"]');
        const costsValue = wrapper.querySelector('[id$="-costs"]');
        const profitValue = wrapper.querySelector('[id$="-profit"]');
        const marginValue = wrapper.querySelector('[id$="-margin"]');

        const profitCard = wrapper.querySelector('.podpc-profit-card');
        const marginCard = wrapper.querySelector('.podpc-margin-card');

        // Get settings from data attributes
        const currency = wrapper.dataset.currency || '$';
        const primaryColor = wrapper.dataset.primaryColor || '#4F46E5';
        const profitColor = wrapper.dataset.profitColor || '#10B981';
        const lossColor = wrapper.dataset.lossColor || '#EF4444';

        // Apply custom colors
        applyCustomColors(wrapper, primaryColor, profitColor, lossColor);

        // Format currency input on blur
        const currencyInputs = [
            sellingPriceInput,
            shippingInput,
            marketingInput,
            productCostsInput,
            otherFeesInput
        ];

        currencyInputs.forEach(function(input) {
            input.addEventListener('blur', function() {
                formatCurrencyInput(this);
            });

            input.addEventListener('focus', function() {
                unformatCurrencyInput(this);
            });

            input.addEventListener('input', function() {
                calculate();
            });
        });

        // Real-time calculation on items input
        itemsInput.addEventListener('input', function() {
            // Prevent negative numbers
            if (parseInt(this.value) < 1) {
                this.value = 1;
            }
            calculate();
        });

        // Prevent negative numbers and invalid input
        itemsInput.addEventListener('keydown', function(e) {
            if (e.key === '-' || e.key === 'e' || e.key === 'E' || e.key === '+' || e.key === '.') {
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

        // Format number as currency (without symbol)
        function formatCurrency(value) {
            return value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Format number as currency with symbol
        function formatCurrencyWithSymbol(value) {
            const formatted = Math.abs(value).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            return (value < 0 ? '-' : '') + currency + formatted;
        }

        // Format percentage
        function formatPercentage(value) {
            return value.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + '%';
        }

        // Calculate all values
        function calculate() {
            // Get input values
            const sellingPrice = parseFloat(sellingPriceInput.value.replace(/[^0-9.]/g, '')) || 0;
            const shipping = parseFloat(shippingInput.value.replace(/[^0-9.]/g, '')) || 0;
            const items = parseInt(itemsInput.value) || 1;
            const marketing = parseFloat(marketingInput.value.replace(/[^0-9.]/g, '')) || 0;
            const productCosts = parseFloat(productCostsInput.value.replace(/[^0-9.]/g, '')) || 0;
            const otherFees = parseFloat(otherFeesInput.value.replace(/[^0-9.]/g, '')) || 0;

            // Calculate Revenue
            const revenue = sellingPrice * items;

            // Calculate Total Costs
            const costPerItem = shipping + marketing + productCosts + otherFees;
            const totalCosts = costPerItem * items;

            // Calculate Net Profit
            const netProfit = revenue - totalCosts;

            // Calculate Net Profit Margin (handle division by zero)
            let profitMargin = 0;
            if (revenue > 0) {
                profitMargin = (netProfit / revenue) * 100;
            }

            // Update Revenue display
            revenueValue.textContent = formatCurrencyWithSymbol(revenue);

            // Update Total Costs display
            costsValue.textContent = formatCurrencyWithSymbol(totalCosts);

            // Update Net Profit display
            profitValue.textContent = formatCurrencyWithSymbol(netProfit);

            // Update Profit Margin display
            marginValue.textContent = formatPercentage(profitMargin);

            // Handle negative profit styling
            if (netProfit < 0) {
                profitCard.classList.add('negative');
                marginCard.classList.add('negative');
            } else {
                profitCard.classList.remove('negative');
                marginCard.classList.remove('negative');
            }
        }

        // Apply custom colors
        function applyCustomColors(wrapper, primary, profit, loss) {
            const style = document.createElement('style');
            const wrapperId = wrapper.id;

            style.textContent = `
                #${wrapperId} .podpc-input-wrapper:focus-within,
                #${wrapperId} input.podpc-input[type="number"]:focus {
                    border-color: ${primary};
                    box-shadow: 0 0 0 3px ${hexToRgba(primary, 0.1)};
                }
                #${wrapperId} .podpc-margin-card {
                    border-left-color: ${primary};
                }
                #${wrapperId} .podpc-margin-card .podpc-result-value {
                    color: ${primary};
                }
                #${wrapperId} .podpc-profit-card {
                    border-left-color: ${profit};
                }
                #${wrapperId} .podpc-profit-card .podpc-result-value {
                    color: ${profit};
                }
                #${wrapperId} .podpc-profit-card.negative {
                    border-left-color: ${loss};
                    background: ${hexToRgba(loss, 0.05)};
                }
                #${wrapperId} .podpc-profit-card.negative .podpc-result-value,
                #${wrapperId} .podpc-margin-card.negative .podpc-result-value {
                    color: ${loss};
                }
            `;

            document.head.appendChild(style);
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
