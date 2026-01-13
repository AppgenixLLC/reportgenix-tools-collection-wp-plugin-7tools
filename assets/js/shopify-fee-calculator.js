/**
 * Shopify Fee Calculator JavaScript
 * Version: 1.0.0
 */

(function() {
    'use strict';

    // Initialize all calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.shopify-calc-wrapper');

        calculators.forEach(function(calculator) {
            initCalculator(calculator);
        });
    });

    function initCalculator(wrapper) {
        // Get DOM elements
        const monthlyRadio = wrapper.querySelector('#monthly');
        const yearlyRadio = wrapper.querySelector('#yearly');

        const shopifyPaymentsCheckbox = wrapper.querySelector('#shopify-payments');
        const paypalCheckbox = wrapper.querySelector('#paypal');
        const otherGatewayCheckbox = wrapper.querySelector('#other-gateway');

        const otherGatewaySection = wrapper.querySelector('.shopify-calc-other-gateway');
        const gatewayPercentInput = wrapper.querySelector('#gateway-percent');
        const gatewayFixedInput = wrapper.querySelector('#gateway-fixed');

        const salesValueInput = wrapper.querySelector('#sales-value');
        const transactionsInput = wrapper.querySelector('#transactions');

        // Show/hide other gateway fields
        otherGatewayCheckbox.addEventListener('change', function() {
            if (this.checked) {
                otherGatewaySection.classList.remove('hidden');
            } else {
                otherGatewaySection.classList.add('hidden');
            }
            calculate();
        });

        // Real-time calculation on all inputs
        [monthlyRadio, yearlyRadio, shopifyPaymentsCheckbox, paypalCheckbox,
         otherGatewayCheckbox, gatewayPercentInput, gatewayFixedInput,
         salesValueInput, transactionsInput].forEach(function(element) {
            if (element) {
                element.addEventListener('change', calculate);
                element.addEventListener('input', calculate);
            }
        });

        // Format currency inputs
        [gatewayFixedInput, salesValueInput].forEach(function(input) {
            if (input) {
                input.addEventListener('blur', function() {
                    formatCurrencyInput(this);
                });

                input.addEventListener('focus', function() {
                    unformatCurrencyInput(this);
                });
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
            return '$' + Math.abs(value).toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // Main calculation function
        function calculate() {
            // Get input values
            const isYearly = yearlyRadio.checked;
            const multiplier = isYearly ? 12 : 1;

            const hasShopifyPayments = shopifyPaymentsCheckbox.checked;
            const hasPayPal = paypalCheckbox.checked;
            const hasOtherGateway = otherGatewayCheckbox.checked;

            const gatewayPercent = parseFloat(gatewayPercentInput.value) || 0;
            const gatewayFixed = parseFloat(gatewayFixedInput.value.replace(/[^0-9.]/g, '')) || 0;

            const salesValue = parseFloat(salesValueInput.value.replace(/[^0-9.]/g, '')) || 0;
            const transactions = parseInt(transactionsInput.value) || 0;

            // Get configuration from data attributes
            const basicPrice = parseFloat(wrapper.dataset.basicPrice) || 39;
            const shopifyPrice = parseFloat(wrapper.dataset.shopifyPrice) || 105;
            const advancedPrice = parseFloat(wrapper.dataset.advancedPrice) || 399;

            const basicSpPercent = parseFloat(wrapper.dataset.basicSpPercent) || 2.9;
            const shopifySpPercent = parseFloat(wrapper.dataset.shopifySpPercent) || 2.6;
            const advancedSpPercent = parseFloat(wrapper.dataset.advancedSpPercent) || 2.4;

            const basicSpFixed = parseFloat(wrapper.dataset.basicSpFixed) || 0.30;
            const shopifySpFixed = parseFloat(wrapper.dataset.shopifySpFixed) || 0.30;
            const advancedSpFixed = parseFloat(wrapper.dataset.advancedSpFixed) || 0.30;

            const basicTransactionFee = parseFloat(wrapper.dataset.basicTransactionFee) || 2.0;
            const shopifyTransactionFee = parseFloat(wrapper.dataset.shopifyTransactionFee) || 1.0;
            const advancedTransactionFee = parseFloat(wrapper.dataset.advancedTransactionFee) || 0.5;

            const paypalPercentRate = parseFloat(wrapper.dataset.paypalPercent) || 2.9;
            const paypalFixedRate = parseFloat(wrapper.dataset.paypalFixed) || 0.30;

            // Shopify plan configurations
            const plans = [
                {
                    name: 'Basic',
                    price: basicPrice,
                    shopifyPaymentPercent: basicSpPercent,
                    shopifyPaymentFixed: basicSpFixed,
                    transactionFee: basicTransactionFee
                },
                {
                    name: 'Shopify',
                    price: shopifyPrice,
                    shopifyPaymentPercent: shopifySpPercent,
                    shopifyPaymentFixed: shopifySpFixed,
                    transactionFee: shopifyTransactionFee
                },
                {
                    name: 'Advanced',
                    price: advancedPrice,
                    shopifyPaymentPercent: advancedSpPercent,
                    shopifyPaymentFixed: advancedSpFixed,
                    transactionFee: advancedTransactionFee
                }
            ];

            // Calculate fees for each plan
            let bestPlan = 0;
            let lowestFees = Infinity;

            plans.forEach(function(plan, index) {
                let totalFees = 0;
                const planCard = wrapper.querySelectorAll('.shopify-calc-plan')[index];
                const feeBreakdown = planCard.querySelector('.shopify-calc-fee-breakdown');

                // Clear previous breakdown
                feeBreakdown.innerHTML = '';

                // Shopify Payments Fees
                if (hasShopifyPayments) {
                    const spFees = (salesValue * plan.shopifyPaymentPercent / 100) +
                                   (transactions * plan.shopifyPaymentFixed);
                    totalFees += spFees * multiplier;

                    addFeeItem(feeBreakdown, 'Shopify Payments', spFees * multiplier);
                }

                // PayPal Fees
                if (hasPayPal) {
                    const paypalFees = (salesValue * paypalPercentRate / 100) +
                                      (transactions * paypalFixedRate);
                    const transactionFees = salesValue * plan.transactionFee / 100;
                    const totalPayPalFees = (paypalFees + transactionFees) * multiplier;

                    totalFees += totalPayPalFees;
                    addFeeItem(feeBreakdown, 'PayPal + Transaction Fee', totalPayPalFees);
                }

                // Other Gateway Fees
                if (hasOtherGateway) {
                    const otherFees = (salesValue * gatewayPercent / 100) +
                                     (transactions * gatewayFixed);
                    const transactionFees = salesValue * plan.transactionFee / 100;
                    const totalOtherFees = (otherFees + transactionFees) * multiplier;

                    totalFees += totalOtherFees;
                    addFeeItem(feeBreakdown, 'Other Gateway + Transaction Fee', totalOtherFees);
                }

                // Update total
                const totalValue = planCard.querySelector('.shopify-calc-total-value');
                totalValue.textContent = formatCurrencyWithSymbol(totalFees);

                // Track lowest fees
                if (totalFees > 0 && totalFees < lowestFees) {
                    lowestFees = totalFees;
                    bestPlan = index;
                }

                // Remove best value class
                planCard.classList.remove('best-value');
            });

            // Highlight best value plan
            if (lowestFees < Infinity) {
                const bestPlanCard = wrapper.querySelectorAll('.shopify-calc-plan')[bestPlan];
                bestPlanCard.classList.add('best-value');

                // Add/update best value badge
                let badge = bestPlanCard.querySelector('.shopify-calc-best-value-badge');
                if (!badge) {
                    badge = document.createElement('div');
                    badge.className = 'shopify-calc-best-value-badge';
                    badge.textContent = 'Best Value';
                    bestPlanCard.querySelector('.shopify-calc-plan-header').appendChild(badge);
                }
            }
        }

        // Helper function to add fee item
        function addFeeItem(container, label, value) {
            const item = document.createElement('div');
            item.className = 'shopify-calc-fee-item';

            const labelSpan = document.createElement('span');
            labelSpan.className = 'shopify-calc-fee-label';
            labelSpan.textContent = label;

            const valueSpan = document.createElement('span');
            valueSpan.className = 'shopify-calc-fee-value';
            valueSpan.textContent = formatCurrencyWithSymbol(value);

            item.appendChild(labelSpan);
            item.appendChild(valueSpan);
            container.appendChild(item);
        }

        // Initial calculation
        calculate();
    }

})();
