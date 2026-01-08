/**
 * ROAS Calculator JavaScript
 * Return on Ad Spend Calculator for Shopify
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

    // Initialize all ROAS calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.roas-calculator-wrapper');

        calculators.forEach(function(calculator) {
            initROASCalculator(calculator);
        });
    });

    function initROASCalculator(wrapper) {
        // Input elements
        const currencySelect = wrapper.querySelector('.roas-currency-select');
        const adCostInput = wrapper.querySelector('.roas-ad-cost');
        const revenueInput = wrapper.querySelector('.roas-revenue');
        const expensesInput = wrapper.querySelector('.roas-expenses');
        const calculateBtn = wrapper.querySelector('.roas-calculate-btn');
        const resetBtn = wrapper.querySelector('.roas-reset-btn');
        const copyBtn = wrapper.querySelector('.roas-copy-btn');

        // Result elements
        const resultsDiv = wrapper.querySelector('.roas-results');
        const ctaDiv = wrapper.querySelector('.roas-cta');
        const mainValueElement = wrapper.querySelector('.roas-main-value');
        const performanceBadge = wrapper.querySelector('.roas-performance-badge');
        const gaugeNeedle = wrapper.querySelector('.roas-gauge-needle');
        const gaugeFill = wrapper.querySelector('.roas-gauge-fill');

        // Secondary metrics
        const netRevenueValue = wrapper.querySelector('.roas-net-revenue');
        const costPerDollarValue = wrapper.querySelector('.roas-cost-per-dollar');
        const profitMarginValue = wrapper.querySelector('.roas-profit-margin');

        // Breakdown table
        const breakdownTableBody = wrapper.querySelector('.roas-breakdown-table tbody');

        // Get settings from data attributes
        const showCta = wrapper.dataset.showCta === 'true';

        // Load saved currency preference
        const savedCurrency = localStorage.getItem('roas_currency') || 'USD';
        if (currencySelect) {
            currencySelect.value = savedCurrency;
        }

        let currentCurrency = savedCurrency;

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
            return value.toFixed(2) + '%';
        }

        // Format ROAS value (no currency, just number)
        function formatROAS(value) {
            if (isNaN(value) || !isFinite(value) || value === undefined || value === null) {
                value = 0;
            }
            return value.toFixed(2);
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
            const field = input.closest('.roas-field');
            if (field) {
                const errorSpan = field.querySelector('.roas-error');
                if (errorSpan) {
                    errorSpan.textContent = '';
                }
            }
            input.classList.remove('roas-error-input');
        }

        // Show error
        function showError(input, message) {
            const field = input.closest('.roas-field');
            if (field) {
                const errorSpan = field.querySelector('.roas-error');
                if (errorSpan) {
                    errorSpan.textContent = message;
                }
            }
            input.classList.add('roas-error-input');
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;

            // Clear previous errors
            clearError(adCostInput);
            clearError(revenueInput);
            clearError(expensesInput);

            const adCost = parseFormattedNumber(adCostInput.value);
            const revenue = parseFormattedNumber(revenueInput.value);
            const expenses = parseFormattedNumber(expensesInput.value);

            // Validate advertising cost
            if (!adCostInput.value || adCost <= 0) {
                showError(adCostInput, 'Please enter a valid advertising cost');
                isValid = false;
            }

            // Validate revenue
            if (!revenueInput.value || revenue <= 0) {
                showError(revenueInput, 'Please enter a valid revenue amount');
                isValid = false;
            }

            // Validate expenses (optional, but must be >= 0 if provided)
            if (expenses < 0) {
                showError(expensesInput, 'Additional expenses cannot be negative');
                isValid = false;
            }

            return isValid;
        }

        // Get performance level based on ROAS
        function getPerformanceLevel(roas) {
            if (roas < 1.0) {
                return {
                    level: 'Poor',
                    class: 'roas-performance-poor',
                    color: '#EF4444'
                };
            } else if (roas >= 1.0 && roas < 1.5) {
                return {
                    level: 'Break-even',
                    class: 'roas-performance-breakeven',
                    color: '#F97316'
                };
            } else if (roas >= 1.5 && roas < 2.5) {
                return {
                    level: 'Average',
                    class: 'roas-performance-average',
                    color: '#FBBF24'
                };
            } else if (roas >= 2.5 && roas < 4.0) {
                return {
                    level: 'Good',
                    class: 'roas-performance-good',
                    color: '#84CC16'
                };
            } else if (roas >= 4.0 && roas < 6.0) {
                return {
                    level: 'Excellent',
                    class: 'roas-performance-excellent',
                    color: '#10B981'
                };
            } else {
                return {
                    level: 'Outstanding',
                    class: 'roas-performance-outstanding',
                    color: '#047857'
                };
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

        // Animate ROAS gauge
        function animateGauge(roas) {
            // Calculate needle rotation (-90deg to 90deg, representing 0 to max ROAS)
            // Max ROAS for gauge display: 10
            const maxROAS = 10;
            const clampedROAS = Math.min(roas, maxROAS);
            const percentage = clampedROAS / maxROAS;
            const rotation = -90 + (percentage * 180);

            // Animate needle
            if (gaugeNeedle) {
                gaugeNeedle.style.transform = `translateX(-50%) rotate(${rotation}deg)`;
            }

            // Animate fill
            if (gaugeFill) {
                const fillPercentage = percentage * 100;
                gaugeFill.style.clipPath = `polygon(0 100%, ${fillPercentage}% 100%, ${fillPercentage}% 0%, 0 0)`;
            }
        }

        // Update breakdown table
        function updateBreakdownTable(data) {
            if (!breakdownTableBody) return;

            const rows = [
                {
                    label: 'Revenue Generated',
                    value: formatCurrency(data.revenue),
                    description: 'Total revenue from ad campaign'
                },
                {
                    label: 'Advertising Cost',
                    value: formatCurrency(data.adCost),
                    description: 'Amount spent on ads'
                },
                {
                    label: 'Additional Expenses',
                    value: formatCurrency(data.expenses),
                    description: 'Other related costs'
                },
                {
                    label: 'Total Cost',
                    value: formatCurrency(data.totalCost),
                    description: 'Advertising Cost + Additional Expenses'
                },
                {
                    label: 'Net Revenue',
                    value: formatCurrency(data.netRevenue),
                    description: 'Revenue - Total Cost'
                },
                {
                    label: 'ROAS',
                    value: formatROAS(data.roas),
                    description: 'Revenue / Total Cost'
                },
                {
                    label: 'Cost Per Dollar Revenue',
                    value: formatCurrency(data.costPerDollar),
                    description: 'Total Cost / Revenue'
                },
                {
                    label: 'Profit Margin',
                    value: formatPercentage(data.profitMargin),
                    description: '(Net Revenue / Revenue) × 100'
                }
            ];

            breakdownTableBody.innerHTML = rows.map(row => `
                <tr>
                    <td><strong>${row.label}</strong></td>
                    <td class="roas-breakdown-value">${row.value}</td>
                    <td>${row.description}</td>
                </tr>
            `).join('');
        }

        // Calculate ROAS
        function calculateROAS() {
            if (!validateInputs()) {
                return;
            }

            // Show loading state
            calculateBtn.classList.add('loading');
            calculateBtn.disabled = true;

            // Simulate calculation delay for better UX
            setTimeout(function() {
                const adCost = parseFormattedNumber(adCostInput.value);
                const revenue = parseFormattedNumber(revenueInput.value);
                const expenses = parseFormattedNumber(expensesInput.value);

                // Calculations
                const totalCost = adCost + expenses;
                const netRevenue = revenue - totalCost;
                const roas = totalCost > 0 ? revenue / totalCost : 0;
                const costPerDollar = revenue > 0 ? totalCost / revenue : 0;
                const profitMargin = revenue > 0 ? (netRevenue / revenue) * 100 : 0;

                // Get performance level
                const performance = getPerformanceLevel(roas);

                // Animate main ROAS value
                animateValue(mainValueElement, 0, roas, 1000, formatROAS);

                // Animate secondary metrics
                animateValue(netRevenueValue, 0, netRevenue, 800, formatCurrency);
                animateValue(costPerDollarValue, 0, costPerDollar, 800, formatCurrency);
                animateValue(profitMarginValue, 0, profitMargin, 800, formatPercentage);

                // Update performance badge
                performanceBadge.textContent = performance.level;
                performanceBadge.className = 'roas-performance-badge ' + performance.class;

                // Animate gauge
                animateGauge(roas);

                // Apply color class to metric cards
                if (netRevenue >= 0) {
                    netRevenueValue.className = 'roas-metric-value roas-metric-positive';
                } else {
                    netRevenueValue.className = 'roas-metric-value roas-metric-negative';
                }

                if (profitMargin >= 0) {
                    profitMarginValue.className = 'roas-metric-value roas-metric-positive';
                } else {
                    profitMarginValue.className = 'roas-metric-value roas-metric-negative';
                }

                // Update breakdown table
                updateBreakdownTable({
                    revenue: revenue,
                    adCost: adCost,
                    expenses: expenses,
                    totalCost: totalCost,
                    netRevenue: netRevenue,
                    roas: roas,
                    costPerDollar: costPerDollar,
                    profitMargin: profitMargin
                });

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
                announceToScreenReader('ROAS calculated: ' + formatROAS(roas) + ' - ' + performance.level);

            }, 400);
        }

        // Reset calculator
        function resetCalculator() {
            // Clear inputs
            adCostInput.value = '';
            revenueInput.value = '';
            expensesInput.value = '';

            // Clear errors
            clearError(adCostInput);
            clearError(revenueInput);
            clearError(expensesInput);

            // Hide results
            resultsDiv.style.display = 'none';
            if (ctaDiv) {
                ctaDiv.style.display = 'none';
            }

            // Reset gauge
            if (gaugeNeedle) {
                gaugeNeedle.style.transform = 'translateX(-50%) rotate(-90deg)';
            }
            if (gaugeFill) {
                gaugeFill.style.clipPath = 'polygon(0 100%, 0% 100%, 0% 0%, 0 0)';
            }

            // Focus on first input
            adCostInput.focus();
        }

        // Copy results to clipboard
        function copyResults() {
            const roas = mainValueElement.textContent;
            const performance = performanceBadge.textContent;
            const netRevenue = netRevenueValue.textContent;
            const costPerDollar = costPerDollarValue.textContent;
            const profitMargin = profitMarginValue.textContent;

            const text = `ROAS Calculator Results\n\n` +
                        `ROAS: ${roas} (${performance})\n` +
                        `Net Revenue: ${netRevenue}\n` +
                        `Cost Per Dollar Revenue: ${costPerDollar}\n` +
                        `Profit Margin: ${profitMargin}`;

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
            localStorage.setItem('roas_currency', currentCurrency);

            // If results are visible, recalculate to update currency symbols
            if (resultsDiv.style.display === 'block') {
                calculateROAS();
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
            calculateBtn.addEventListener('click', calculateROAS);
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
        if (adCostInput) {
            adCostInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        if (revenueInput) {
            revenueInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        if (expensesInput) {
            expensesInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        // Enter key support
        [adCostInput, revenueInput, expensesInput].forEach(function(input) {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        calculateROAS();
                    }
                });
            }
        });

        // Format currency on blur
        if (adCostInput) {
            adCostInput.addEventListener('blur', function() {
                const value = parseFormattedNumber(this.value);
                if (value > 0) {
                    this.value = value.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            });

            adCostInput.addEventListener('focus', function() {
                const value = parseFormattedNumber(this.value);
                if (value > 0) {
                    this.value = value.toString();
                }
            });
        }

        if (revenueInput) {
            revenueInput.addEventListener('blur', function() {
                const value = parseFormattedNumber(this.value);
                if (value > 0) {
                    this.value = value.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            });

            revenueInput.addEventListener('focus', function() {
                const value = parseFormattedNumber(this.value);
                if (value > 0) {
                    this.value = value.toString();
                }
            });
        }

        if (expensesInput) {
            expensesInput.addEventListener('blur', function() {
                const value = parseFormattedNumber(this.value);
                if (value >= 0) {
                    this.value = value.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            });

            expensesInput.addEventListener('focus', function() {
                const value = parseFormattedNumber(this.value);
                if (value >= 0) {
                    this.value = value.toString();
                }
            });
        }
    }
})();
