/**
 * ROI Calculator JavaScript
 * Version: 2.0.0
 */

(function() {
    'use strict';

    // Currency configurations
    const currencies = {
        'USD': { symbol: '$', position: 'before', name: 'US Dollar' },
        'EUR': { symbol: '€', position: 'after', name: 'Euro' },
        'GBP': { symbol: '£', position: 'before', name: 'British Pound' },
        'JPY': { symbol: '¥', position: 'before', name: 'Japanese Yen' },
        'CNY': { symbol: '¥', position: 'before', name: 'Chinese Yuan' },
        'CHF': { symbol: 'CHF', position: 'before', name: 'Swiss Franc' },
        'CAD': { symbol: 'C$', position: 'before', name: 'Canadian Dollar' },
        'AUD': { symbol: 'A$', position: 'before', name: 'Australian Dollar' },
        'NZD': { symbol: 'NZ$', position: 'before', name: 'New Zealand Dollar' },
        'INR': { symbol: '₹', position: 'before', name: 'Indian Rupee' },
        'SGD': { symbol: 'S$', position: 'before', name: 'Singapore Dollar' },
        'HKD': { symbol: 'HK$', position: 'before', name: 'Hong Kong Dollar' },
        'KRW': { symbol: '₩', position: 'before', name: 'South Korean Won' },
        'BRL': { symbol: 'R$', position: 'before', name: 'Brazilian Real' },
        'MXN': { symbol: '$', position: 'before', name: 'Mexican Peso' },
        'ZAR': { symbol: 'R', position: 'before', name: 'South African Rand' },
        'SEK': { symbol: 'kr', position: 'after', name: 'Swedish Krona' },
        'NOK': { symbol: 'kr', position: 'after', name: 'Norwegian Krone' },
        'DKK': { symbol: 'kr', position: 'after', name: 'Danish Krone' },
        'PLN': { symbol: 'zł', position: 'after', name: 'Polish Zloty' },
        'THB': { symbol: '฿', position: 'before', name: 'Thai Baht' },
        'IDR': { symbol: 'Rp', position: 'before', name: 'Indonesian Rupiah' },
        'MYR': { symbol: 'RM', position: 'before', name: 'Malaysian Ringgit' },
        'PHP': { symbol: '₱', position: 'before', name: 'Philippine Peso' },
        'AED': { symbol: 'د.إ', position: 'before', name: 'UAE Dirham' },
        'SAR': { symbol: '﷼', position: 'before', name: 'Saudi Riyal' },
        'TRY': { symbol: '₺', position: 'before', name: 'Turkish Lira' },
        'RUB': { symbol: '₽', position: 'before', name: 'Russian Ruble' },
        'CZK': { symbol: 'Kč', position: 'after', name: 'Czech Koruna' },
        'ILS': { symbol: '₪', position: 'before', name: 'Israeli Shekel' }
    };

    // Initialize all ROI calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.roic-calculator-wrapper');

        calculators.forEach(function(calculator) {
            initROICalculator(calculator);
        });
    });

    function initROICalculator(wrapper) {
        const monthlySalesInput = wrapper.querySelector('.roic-monthly-sales');
        const conversionRateInput = wrapper.querySelector('.roic-conversion-rate');
        const monthlySpendInput = wrapper.querySelector('.roic-monthly-spend');
        const improvementSelect = wrapper.querySelector('.roic-improvement');
        const calculateBtn = wrapper.querySelector('.roic-calculate-btn');
        const resultsDiv = wrapper.querySelector('.roic-results');
        const ctaDiv = wrapper.querySelector('.roic-cta');
        const currencySelect = wrapper.querySelector('.roic-currency-select');

        // Result elements
        const newConversionRateValue = wrapper.querySelector('.roic-new-conversion-rate');
        const conversionRateChange = wrapper.querySelector('.roic-conversion-rate-change');
        const newMonthlySalesValue = wrapper.querySelector('.roic-new-monthly-sales');
        const monthlySalesChange = wrapper.querySelector('.roic-monthly-sales-change');
        const roiValue = wrapper.querySelector('.roic-roi-value');
        const roiCard = wrapper.querySelector('.roic-roi-card');

        // Get settings from data attributes
        const showCta = wrapper.dataset.showCta === 'true';

        // Load saved currency preference or use default
        const savedCurrency = localStorage.getItem('roic_currency') || 'USD';
        if (currencySelect) {
            currencySelect.value = savedCurrency;
        }

        let currentCurrency = savedCurrency;

        // Update currency prefix/suffix in inputs
        function updateCurrencyDisplay() {
            const currency = currencies[currentCurrency];
            const prefixElements = wrapper.querySelectorAll('.roic-currency-prefix');
            const suffixElements = wrapper.querySelectorAll('.roic-currency-suffix');

            prefixElements.forEach(function(el) {
                const input = el.parentElement.querySelector('input');
                if (currency.position === 'before') {
                    el.textContent = currency.symbol;
                    el.style.display = '';
                    if (input && !input.id.includes('conversion-rate')) {
                        input.style.paddingLeft = '2.5rem';
                        input.style.paddingRight = '1rem';
                    }
                } else {
                    el.style.display = 'none';
                    if (input && !input.id.includes('conversion-rate')) {
                        input.style.paddingLeft = '1rem';
                    }
                }
            });

            suffixElements.forEach(function(el) {
                const input = el.parentElement.querySelector('input');
                if (currency.position === 'after') {
                    el.textContent = ' ' + currency.symbol;
                    el.style.display = '';
                    if (input && !input.id.includes('conversion-rate')) {
                        input.style.paddingRight = '2.5rem';
                        input.style.paddingLeft = '1rem';
                    }
                } else {
                    el.style.display = 'none';
                    if (input && !input.id.includes('conversion-rate')) {
                        input.style.paddingRight = '1rem';
                    }
                }
            });
        }

        // Initial currency display update
        updateCurrencyDisplay();

        // Format currency
        function formatCurrency(value) {
            // Handle NaN, Infinity, and undefined
            if (isNaN(value) || !isFinite(value) || value === undefined || value === null) {
                value = 0;
            }

            const currency = currencies[currentCurrency];
            const formatted = Math.abs(value).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            if (currency.position === 'before') {
                return currency.symbol + formatted;
            }
            return formatted + ' ' + currency.symbol;
        }

        // Format percentage
        function formatPercentage(value) {
            // Handle NaN, Infinity, and undefined
            if (isNaN(value) || !isFinite(value) || value === undefined || value === null) {
                value = 0;
            }
            return value.toFixed(2) + '%';
        }

        // Parse number from formatted string
        function parseFormattedNumber(str) {
            if (!str || str.trim() === '') return 0;
            const cleaned = str.replace(/[^\d.]/g, '');
            const parsed = parseFloat(cleaned);
            return isNaN(parsed) ? 0 : parsed;
        }

        // Clear error
        function clearError(input) {
            const field = input.closest('.roic-field');
            if (field) {
                const errorSpan = field.querySelector('.roic-error');
                if (errorSpan) {
                    errorSpan.textContent = '';
                }
            }
            input.classList.remove('roic-error-input');
        }

        // Show error
        function showError(input, message) {
            const field = input.closest('.roic-field');
            if (field) {
                const errorSpan = field.querySelector('.roic-error');
                if (errorSpan) {
                    errorSpan.textContent = message;
                }
            }
            input.classList.add('roic-error-input');
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;

            // Clear previous errors
            clearError(monthlySalesInput);
            clearError(conversionRateInput);
            clearError(monthlySpendInput);

            const monthlySales = parseFormattedNumber(monthlySalesInput.value);
            const conversionRate = parseFormattedNumber(conversionRateInput.value);
            const monthlySpend = parseFormattedNumber(monthlySpendInput.value);

            // Validate monthly sales
            if (!monthlySalesInput.value || monthlySales <= 0) {
                showError(monthlySalesInput, 'Please enter a valid monthly sales amount');
                isValid = false;
            }

            // Validate conversion rate
            if (!conversionRateInput.value) {
                showError(conversionRateInput, 'Please enter your current conversion rate');
                isValid = false;
            } else if (conversionRate < 0 || conversionRate > 100) {
                showError(conversionRateInput, 'Conversion rate must be between 0 and 100');
                isValid = false;
            }

            // Validate monthly spend
            if (!monthlySpendInput.value || monthlySpend < 0) {
                showError(monthlySpendInput, 'Please enter a valid monthly spend amount');
                isValid = false;
            }

            return isValid;
        }

        // Animate number counting
        function animateValue(element, start, end, duration, formatter) {
            const startTime = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);

                // Easing function (easeOutQuad)
                const easeProgress = progress * (2 - progress);

                const current = start + (end - start) * easeProgress;
                element.textContent = formatter(current);
                element.classList.add('counting');

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    element.classList.remove('counting');
                }
            }

            requestAnimationFrame(update);
        }

        // Calculate ROI
        function calculateROI() {
            if (!validateInputs()) {
                return;
            }

            // Show loading state
            calculateBtn.classList.add('loading');
            calculateBtn.disabled = true;

            // Simulate calculation delay for better UX
            setTimeout(function() {
                const monthlySales = parseFormattedNumber(monthlySalesInput.value);
                const currentConversionRate = parseFormattedNumber(conversionRateInput.value);
                const monthlySpend = parseFormattedNumber(monthlySpendInput.value);
                const improvementPercentage = parseFloat(improvementSelect.value);

                // Calculations
                const improvementMultiplier = 1 + (improvementPercentage / 100);
                const newConversionRate = currentConversionRate * improvementMultiplier;
                const conversionRateIncrease = newConversionRate - currentConversionRate;

                // Handle edge case: if current conversion rate is 0 or very small
                let revenueMultiplier, newMonthlySales, salesIncrease;

                if (currentConversionRate === 0 || currentConversionRate < 0.01) {
                    // If starting from 0, we can't calculate a meaningful multiplier
                    // Assume the improvement will directly affect sales proportionally
                    revenueMultiplier = improvementMultiplier;
                    newMonthlySales = monthlySales * improvementMultiplier;
                    salesIncrease = newMonthlySales - monthlySales;
                } else {
                    revenueMultiplier = newConversionRate / currentConversionRate;
                    newMonthlySales = monthlySales * revenueMultiplier;
                    salesIncrease = newMonthlySales - monthlySales;
                }

                const netGain = salesIncrease - monthlySpend;
                const roi = monthlySpend > 0 ? (netGain / monthlySpend) * 100 : 0;

                // Animate and display results
                animateValue(newConversionRateValue, currentConversionRate, newConversionRate, 800, formatPercentage);
                animateValue(newMonthlySalesValue, monthlySales, newMonthlySales, 800, formatCurrency);
                animateValue(roiValue, 0, roi, 1000, formatPercentage);

                // Update change indicators
                conversionRateChange.textContent = '+' + formatPercentage(conversionRateIncrease);
                conversionRateChange.className = 'roic-card-change positive';

                if (salesIncrease >= 0) {
                    monthlySalesChange.textContent = '+' + formatCurrency(salesIncrease);
                    monthlySalesChange.className = 'roic-card-change positive';
                } else {
                    monthlySalesChange.textContent = formatCurrency(salesIncrease);
                    monthlySalesChange.className = 'roic-card-change negative';
                }

                // Style ROI card based on value
                roiCard.classList.remove('roi-negative', 'roi-moderate', 'roi-good', 'roi-excellent');

                if (roi < 0) {
                    roiCard.classList.add('roi-negative');
                } else if (roi >= 0 && roi <= 50) {
                    roiCard.classList.add('roi-moderate');
                } else if (roi > 50 && roi <= 100) {
                    roiCard.classList.add('roi-good');
                } else {
                    roiCard.classList.add('roi-excellent');
                }

                // Show results
                resultsDiv.style.display = 'block';

                // Show CTA if enabled
                if (showCta && ctaDiv) {
                    ctaDiv.style.display = 'block';
                }

                // Remove loading state
                calculateBtn.classList.remove('loading');
                calculateBtn.disabled = false;

                // Scroll to results
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                // Announce to screen readers
                announceToScreenReader('ROI calculated: ' + formatPercentage(roi));

            }, 400);
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

        // Currency change handler
        function handleCurrencyChange() {
            currentCurrency = currencySelect.value;
            localStorage.setItem('roic_currency', currentCurrency);
            updateCurrencyDisplay();

            // If results are visible, recalculate to update currency symbols
            if (resultsDiv.style.display === 'block') {
                calculateROI();
            }
        }

        // Event listeners
        calculateBtn.addEventListener('click', calculateROI);

        if (currencySelect) {
            currencySelect.addEventListener('change', handleCurrencyChange);
        }

        // Clear errors on input
        monthlySalesInput.addEventListener('input', function() {
            clearError(this);
        });

        conversionRateInput.addEventListener('input', function() {
            clearError(this);
        });

        monthlySpendInput.addEventListener('input', function() {
            clearError(this);
        });

        // Enter key support
        [monthlySalesInput, conversionRateInput, monthlySpendInput].forEach(function(input) {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    calculateROI();
                }
            });
        });

        // Format currency on blur
        monthlySalesInput.addEventListener('blur', function() {
            const value = parseFormattedNumber(this.value);
            if (value > 0) {
                this.value = value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });

        monthlySpendInput.addEventListener('blur', function() {
            const value = parseFormattedNumber(this.value);
            if (value >= 0) {
                this.value = value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });

        // Remove formatting on focus
        monthlySalesInput.addEventListener('focus', function() {
            const value = parseFormattedNumber(this.value);
            if (value > 0) {
                this.value = value.toString();
            }
        });

        monthlySpendInput.addEventListener('focus', function() {
            const value = parseFormattedNumber(this.value);
            if (value >= 0) {
                this.value = value.toString();
            }
        });

        // Format percentage on blur
        conversionRateInput.addEventListener('blur', function() {
            const value = parseFormattedNumber(this.value);
            if (value >= 0) {
                this.value = value.toFixed(2);
            }
        });
    }
})();
