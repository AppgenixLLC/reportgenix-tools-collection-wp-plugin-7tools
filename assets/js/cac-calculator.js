/**
 * CAC Calculator JavaScript
 * Customer Acquisition Cost Calculator
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

    // Performance thresholds
    const thresholds = {
        cacValue: {
            veryLow: 10,
            low: 30,
            average: 50,
            moderate: 100,
            high: 200
        },
        cacAovPercent: {
            excellent: 20,
            good: 30,
            average: 50
        },
        cacLtvRatio: {
            excellent: 5,
            good: 3,
            average: 2
        }
    };

    // Initialize all CAC calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.cac-calculator-wrapper');

        calculators.forEach(function(calculator) {
            initCACCalculator(calculator);
        });
    });

    function initCACCalculator(wrapper) {
        // Input elements
        const currencySelect = wrapper.querySelector('.cac-currency-select');
        const expensesInput = wrapper.querySelector('.cac-expenses');
        const customersInput = wrapper.querySelector('.cac-customers');
        const aovInput = wrapper.querySelector('.cac-aov');
        const clvInput = wrapper.querySelector('.cac-clv');
        const calculateBtn = wrapper.querySelector('.cac-calculate-btn');
        const resetBtn = wrapper.querySelector('.cac-reset-btn');
        const copyBtn = wrapper.querySelector('.cac-copy-btn');

        // Result elements
        const resultsDiv = wrapper.querySelector('.cac-results');
        const resultValue = wrapper.querySelector('.cac-result-value');
        const performanceBadge = wrapper.querySelector('.cac-badge');

        // Metric cards
        const aovMetric = wrapper.querySelector('#cac-aov-metric');
        const ltvMetric = wrapper.querySelector('#cac-ltv-metric');
        const paybackMetric = wrapper.querySelector('#cac-payback-metric');

        // Summary elements
        const summarySpend = wrapper.querySelector('.cac-summary-spend');
        const summaryCustomers = wrapper.querySelector('.cac-summary-customers');
        const summaryCac = wrapper.querySelector('.cac-summary-cac');

        // Get settings from data attributes
        const showAov = wrapper.dataset.showAov === 'true';
        const showClv = wrapper.dataset.showClv === 'true';

        // Load saved currency preference
        const savedCurrency = localStorage.getItem('cac_currency') || 'USD';
        if (currencySelect) {
            currencySelect.value = savedCurrency;
        }

        let currentCurrency = savedCurrency;

        // Update currency prefix/suffix in inputs
        function updateCurrencyDisplay() {
            const currency = currencies[currentCurrency];
            const prefixElements = wrapper.querySelectorAll('.cac-currency-prefix');
            const suffixElements = wrapper.querySelectorAll('.cac-currency-suffix');

            prefixElements.forEach(function(el) {
                const input = el.parentElement.querySelector('input');
                if (currency.position === 'before') {
                    el.textContent = currency.symbol;
                    el.style.display = '';
                    if (input) {
                        input.style.paddingLeft = '2.5rem';
                        input.style.paddingRight = '1rem';
                    }
                } else {
                    el.style.display = 'none';
                    if (input) {
                        input.style.paddingLeft = '1rem';
                    }
                }
            });

            suffixElements.forEach(function(el) {
                const input = el.parentElement.querySelector('input');
                if (currency.position === 'after') {
                    el.textContent = ' ' + currency.symbol;
                    el.style.display = '';
                    if (input) {
                        input.style.paddingRight = '2.5rem';
                        input.style.paddingLeft = '1rem';
                    }
                } else {
                    el.style.display = 'none';
                    if (input) {
                        input.style.paddingRight = '1rem';
                    }
                }
            });
        }

        // Initial currency display update
        updateCurrencyDisplay();

        // Format currency
        function formatCurrency(value) {
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
            if (isNaN(value) || !isFinite(value) || value === undefined || value === null) {
                value = 0;
            }
            return value.toFixed(1) + '%';
        }

        // Format number
        function formatNumber(value, decimals = 1) {
            if (isNaN(value) || !isFinite(value) || value === undefined || value === null) {
                value = 0;
            }
            return value.toFixed(decimals);
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
            const field = input.closest('.cac-field');
            if (field) {
                const errorSpan = field.querySelector('.cac-error');
                if (errorSpan) {
                    errorSpan.textContent = '';
                }
            }
            input.classList.remove('cac-error-input');
        }

        // Show error
        function showError(input, message) {
            const field = input.closest('.cac-field');
            if (field) {
                const errorSpan = field.querySelector('.cac-error');
                if (errorSpan) {
                    errorSpan.textContent = message;
                }
            }
            input.classList.add('cac-error-input');
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;

            // Clear previous errors
            clearError(expensesInput);
            clearError(customersInput);

            const expenses = parseFormattedNumber(expensesInput.value);
            const customers = parseFormattedNumber(customersInput.value);

            // Validate expenses
            if (!expensesInput.value || expenses < 0) {
                showError(expensesInput, 'Please enter a valid marketing expense amount');
                isValid = false;
            }

            // Validate customers
            if (!customersInput.value || customers < 1) {
                showError(customersInput, 'Please enter at least 1 customer');
                isValid = false;
            }

            return isValid;
        }

        // Get CAC performance level
        function getCACPerformance(cac) {
            if (cac < thresholds.cacValue.veryLow) {
                return {
                    level: 'Very Low CAC',
                    class: 'cac-badge-very-low',
                    message: 'May be underinvesting in acquisition'
                };
            } else if (cac < thresholds.cacValue.low) {
                return {
                    level: 'Low CAC',
                    class: 'cac-badge-low',
                    message: 'Efficient acquisition'
                };
            } else if (cac < thresholds.cacValue.average) {
                return {
                    level: 'Average CAC',
                    class: 'cac-badge-average',
                    message: 'Typical for most industries'
                };
            } else if (cac < thresholds.cacValue.moderate) {
                return {
                    level: 'Moderate CAC',
                    class: 'cac-badge-moderate',
                    message: 'Consider optimization'
                };
            } else if (cac < thresholds.cacValue.high) {
                return {
                    level: 'High CAC',
                    class: 'cac-badge-high',
                    message: 'Ensure LTV justifies cost'
                };
            } else {
                return {
                    level: 'Very High CAC',
                    class: 'cac-badge-very-high',
                    message: 'Review acquisition strategy'
                };
            }
        }

        // Get AOV performance level
        function getAOVPerformance(cacPercent) {
            if (cacPercent < thresholds.cacAovPercent.excellent) {
                return { status: 'Excellent', class: 'excellent', barWidth: 25 };
            } else if (cacPercent < thresholds.cacAovPercent.good) {
                return { status: 'Good', class: 'good', barWidth: 50 };
            } else if (cacPercent < thresholds.cacAovPercent.average) {
                return { status: 'Average', class: 'average', barWidth: 75 };
            } else {
                return { status: 'High - Review pricing', class: 'poor', barWidth: 100 };
            }
        }

        // Get LTV performance level
        function getLTVPerformance(ratio) {
            if (ratio >= thresholds.cacLtvRatio.excellent) {
                return { status: 'Excellent', class: 'excellent', barWidth: 100 };
            } else if (ratio >= thresholds.cacLtvRatio.good) {
                return { status: 'Good', class: 'good', barWidth: 75 };
            } else if (ratio >= thresholds.cacLtvRatio.average) {
                return { status: 'Average', class: 'average', barWidth: 50 };
            } else {
                return { status: 'Poor - Overspending on acquisition', class: 'poor', barWidth: 25 };
            }
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

        // Calculate CAC
        function calculateCAC() {
            if (!validateInputs()) {
                return;
            }

            // Show loading state
            calculateBtn.classList.add('loading');
            calculateBtn.disabled = true;

            // Simulate calculation delay for better UX
            setTimeout(function() {
                const expenses = parseFormattedNumber(expensesInput.value);
                const customers = parseFormattedNumber(customersInput.value);
                const aov = aovInput ? parseFormattedNumber(aovInput.value) : 0;
                const clv = clvInput ? parseFormattedNumber(clvInput.value) : 0;

                // Calculate CAC
                const cac = expenses / customers;

                // Get performance
                const performance = getCACPerformance(cac);

                // Animate main CAC value
                animateValue(resultValue, 0, cac, 1000, formatCurrency);

                // Update performance badge
                performanceBadge.textContent = performance.level;
                performanceBadge.className = 'cac-badge ' + performance.class;

                // Update summary
                summarySpend.textContent = formatCurrency(expenses);
                summaryCustomers.textContent = Math.round(customers);
                animateValue(summaryCac, 0, cac, 800, formatCurrency);

                // Calculate and show optional metrics
                if (showAov && aov > 0 && aovMetric) {
                    const cacPercent = (cac / aov) * 100;
                    const aovPerf = getAOVPerformance(cacPercent);

                    aovMetric.style.display = 'block';
                    const aovValueEl = aovMetric.querySelector('.cac-metric-value');
                    const aovBarFill = aovMetric.querySelector('.cac-metric-bar-fill');
                    const aovStatus = aovMetric.querySelector('.cac-metric-status');

                    animateValue(aovValueEl, 0, cacPercent, 800, formatPercentage);
                    aovBarFill.style.width = aovPerf.barWidth + '%';
                    aovBarFill.className = 'cac-metric-bar-fill ' + aovPerf.class;
                    aovStatus.textContent = aovPerf.status;
                    aovStatus.className = 'cac-metric-status ' + aovPerf.class;
                } else if (aovMetric) {
                    aovMetric.style.display = 'none';
                }

                if (showClv && clv > 0 && ltvMetric) {
                    const ratio = clv / cac;
                    const ltvPerf = getLTVPerformance(ratio);

                    ltvMetric.style.display = 'block';
                    const ltvValueEl = ltvMetric.querySelector('.cac-metric-value');
                    const ltvBarFill = ltvMetric.querySelector('.cac-metric-bar-fill');
                    const ltvStatus = ltvMetric.querySelector('.cac-metric-status');

                    animateValue(ltvValueEl, 0, ratio, 800, function(val) {
                        return '1:' + formatNumber(val, 1);
                    });
                    ltvBarFill.style.width = ltvPerf.barWidth + '%';
                    ltvBarFill.className = 'cac-metric-bar-fill ' + ltvPerf.class;
                    ltvStatus.textContent = ltvPerf.status;
                    ltvStatus.className = 'cac-metric-status ' + ltvPerf.class;
                } else if (ltvMetric) {
                    ltvMetric.style.display = 'none';
                }

                if (showAov && aov > 0 && paybackMetric) {
                    const ordersToPayback = cac / aov;

                    paybackMetric.style.display = 'block';
                    const paybackValueEl = paybackMetric.querySelector('.cac-metric-value');
                    animateValue(paybackValueEl, 0, ordersToPayback, 800, function(val) {
                        return formatNumber(val, 1) + ' orders';
                    });
                } else if (paybackMetric) {
                    paybackMetric.style.display = 'none';
                }

                // Show results
                resultsDiv.style.display = 'block';

                // Remove loading state
                calculateBtn.classList.remove('loading');
                calculateBtn.disabled = false;

                // Scroll to results
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                // Announce to screen readers
                announceToScreenReader('CAC calculated: ' + formatCurrency(cac) + ' - ' + performance.level);

            }, 400);
        }

        // Reset calculator
        function resetCalculator() {
            // Clear inputs
            expensesInput.value = '';
            customersInput.value = '';
            if (aovInput) aovInput.value = '';
            if (clvInput) clvInput.value = '';

            // Clear errors
            clearError(expensesInput);
            clearError(customersInput);

            // Hide results
            resultsDiv.style.display = 'none';

            // Focus on first input
            expensesInput.focus();
        }

        // Copy results to clipboard
        function copyResults() {
            const cac = resultValue.textContent;
            const performance = performanceBadge.textContent;
            const spend = summarySpend.textContent;
            const customers = summaryCustomers.textContent;

            let text = `CAC Calculator Results\n\n` +
                      `Customer Acquisition Cost: ${cac}\n` +
                      `Performance: ${performance}\n` +
                      `Total Marketing Spend: ${spend}\n` +
                      `New Customers Acquired: ${customers}\n`;

            // Add optional metrics if visible
            if (aovMetric && aovMetric.style.display !== 'none') {
                const aovValue = aovMetric.querySelector('.cac-metric-value').textContent;
                text += `CAC as % of AOV: ${aovValue}\n`;
            }

            if (ltvMetric && ltvMetric.style.display !== 'none') {
                const ltvValue = ltvMetric.querySelector('.cac-metric-value').textContent;
                text += `CAC:LTV Ratio: ${ltvValue}\n`;
            }

            if (paybackMetric && paybackMetric.style.display !== 'none') {
                const paybackValue = paybackMetric.querySelector('.cac-metric-value').textContent;
                text += `Orders to Recover CAC: ${paybackValue}\n`;
            }

            navigator.clipboard.writeText(text).then(function() {
                copyBtn.textContent = '✓ Copied!';
                copyBtn.classList.add('copied');

                setTimeout(function() {
                    copyBtn.textContent = '📋 Copy Results';
                    copyBtn.classList.remove('copied');
                }, 2000);
            }).catch(function(err) {
                console.error('Failed to copy: ', err);
            });
        }

        // Currency change handler
        function handleCurrencyChange() {
            currentCurrency = currencySelect.value;
            localStorage.setItem('cac_currency', currentCurrency);
            updateCurrencyDisplay();

            // If results are visible, recalculate to update currency symbols
            if (resultsDiv.style.display === 'block') {
                calculateCAC();
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
        if (calculateBtn) {
            calculateBtn.addEventListener('click', calculateCAC);
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', resetCalculator);
        }

        if (copyBtn) {
            copyBtn.addEventListener('click', copyResults);
        }

        if (currencySelect) {
            currencySelect.addEventListener('change', handleCurrencyChange);
        }

        // Clear errors on input
        if (expensesInput) {
            expensesInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        if (customersInput) {
            customersInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        // Enter key support
        [expensesInput, customersInput, aovInput, clvInput].forEach(function(input) {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        calculateCAC();
                    }
                });
            }
        });

        // Format currency on blur
        [expensesInput, aovInput, clvInput].forEach(function(input) {
            if (input) {
                input.addEventListener('blur', function() {
                    const value = parseFormattedNumber(this.value);
                    if (value > 0) {
                        this.value = value.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                });

                input.addEventListener('focus', function() {
                    const value = parseFormattedNumber(this.value);
                    if (value > 0) {
                        this.value = value.toString();
                    }
                });
            }
        });

        // Format customers on blur (whole number)
        if (customersInput) {
            customersInput.addEventListener('blur', function() {
                const value = parseFormattedNumber(this.value);
                if (value > 0) {
                    this.value = Math.round(value).toString();
                }
            });
        }
    }
})();
