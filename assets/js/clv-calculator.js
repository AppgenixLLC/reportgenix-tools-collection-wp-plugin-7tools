/**
 * CLV Calculator JavaScript
 * Version: 2.0.0
 */

(function() {
    'use strict';

    // Currency configurations (30 currencies)
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

    // CLV:CAC Ratio Thresholds
    const ratioThresholds = {
        critical: 1,
        poor: 2,
        average: 3,
        good: 5
    };

    // Initialize all CLV calculators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const calculators = document.querySelectorAll('.clv-calculator-wrapper');

        calculators.forEach(function(calculator) {
            initCLVCalculator(calculator);
        });
    });

    function initCLVCalculator(wrapper) {
        // Get all inputs
        const purchaseValueInput = wrapper.querySelector('#clv-purchase-value');
        const frequencyInput = wrapper.querySelector('#clv-frequency');
        const lifespanInput = wrapper.querySelector('#clv-lifespan');
        const marginInput = wrapper.querySelector('#clv-margin');
        const cacInput = wrapper.querySelector('#clv-cac');
        const currencySelect = wrapper.querySelector('#clv-currency');
        const calculateBtn = wrapper.querySelector('.clv-calculate-btn');
        const resetBtn = wrapper.querySelector('.clv-reset-btn');
        const copyBtn = wrapper.querySelector('.clv-copy-btn');
        const resultsDiv = wrapper.querySelector('.clv-results');

        // Get result elements
        const mainResultValue = wrapper.querySelector('.clv-result-value');
        const profitResultValue = wrapper.querySelector('.clv-profit-value');
        const profitSection = wrapper.querySelector('#clv-profit-section');
        const ratioSection = wrapper.querySelector('#clv-ratio-section');
        const ratioValue = wrapper.querySelector('.clv-ratio-value');
        const ratioBarFill = wrapper.querySelector('.clv-ratio-bar-fill');
        const statusBadge = wrapper.querySelector('.clv-status-badge');
        const statusText = wrapper.querySelector('.clv-status-text');
        const annualValueEl = wrapper.querySelector('#clv-annual-value');
        const totalOrdersEl = wrapper.querySelector('#clv-total-orders');
        const netValueEl = wrapper.querySelector('#clv-net-value');
        const netValueCard = wrapper.querySelector('#clv-net-value-card');
        const paybackEl = wrapper.querySelector('#clv-payback');
        const paybackCard = wrapper.querySelector('#clv-payback-card');

        // Breakdown elements
        const breakdownApv = wrapper.querySelector('#clv-breakdown-apv');
        const breakdownFreq = wrapper.querySelector('#clv-breakdown-freq');
        const breakdownAnnual = wrapper.querySelector('#clv-breakdown-annual');
        const breakdownLifespan = wrapper.querySelector('#clv-breakdown-lifespan');
        const breakdownTotal = wrapper.querySelector('#clv-breakdown-total');

        // Simulator elements
        const simApv = wrapper.querySelector('#clv-sim-apv');
        const simFreq = wrapper.querySelector('#clv-sim-freq');
        const simLife = wrapper.querySelector('#clv-sim-life');

        // Get settings from data attributes
        const defaultCurrency = wrapper.dataset.defaultCurrency || 'USD';
        const showProfitMargin = wrapper.dataset.showProfitMargin === 'true';
        const showCacField = wrapper.dataset.showCacField === 'true';

        // Load saved currency or use default
        const savedCurrency = localStorage.getItem('clv_currency') || defaultCurrency;
        if (currencySelect) {
            currencySelect.value = savedCurrency;
        }

        let currentCurrency = savedCurrency;

        // Update currency display
        function updateCurrencyDisplay() {
            const currency = currencies[currentCurrency];
            const prefixElements = wrapper.querySelectorAll('.clv-currency-prefix');
            const suffixElements = wrapper.querySelectorAll('.clv-currency-suffix');

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
                        input.style.paddingRight = '3rem';
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

        // Initial currency display
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

        // Parse number from formatted string
        function parseFormattedNumber(str) {
            if (!str || str.trim() === '') return 0;
            const cleaned = str.replace(/[^\d.]/g, '');
            const parsed = parseFloat(cleaned);
            return isNaN(parsed) ? 0 : parsed;
        }

        // Clear error
        function clearError(input) {
            const field = input.closest('.clv-field');
            if (field) {
                const errorSpan = field.querySelector('.clv-error');
                if (errorSpan) {
                    errorSpan.textContent = '';
                }
            }
            input.classList.remove('clv-error-input');
        }

        // Show error
        function showError(input, message) {
            const field = input.closest('.clv-field');
            if (field) {
                const errorSpan = field.querySelector('.clv-error');
                if (errorSpan) {
                    errorSpan.textContent = message;
                }
            }
            input.classList.add('clv-error-input');
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;

            // Clear previous errors
            clearError(purchaseValueInput);
            clearError(frequencyInput);
            clearError(lifespanInput);
            if (marginInput) clearError(marginInput);
            if (cacInput) clearError(cacInput);

            const purchaseValue = parseFormattedNumber(purchaseValueInput.value);
            const frequency = parseFormattedNumber(frequencyInput.value);
            const lifespan = parseFormattedNumber(lifespanInput.value);
            const margin = marginInput ? parseFormattedNumber(marginInput.value) : 0;
            const cac = cacInput ? parseFormattedNumber(cacInput.value) : 0;

            // Validate purchase value
            if (!purchaseValueInput.value || purchaseValue <= 0) {
                showError(purchaseValueInput, 'Please enter a valid purchase value');
                isValid = false;
            }

            // Validate frequency
            if (!frequencyInput.value || frequency <= 0) {
                showError(frequencyInput, 'Please enter a valid purchase frequency');
                isValid = false;
            }

            // Validate lifespan
            if (!lifespanInput.value || lifespan <= 0) {
                showError(lifespanInput, 'Please enter a valid customer lifespan');
                isValid = false;
            }

            // Validate optional profit margin
            if (marginInput && marginInput.value && (margin < 0 || margin > 100)) {
                showError(marginInput, 'Profit margin must be between 0 and 100');
                isValid = false;
            }

            // Validate optional CAC
            if (cacInput && cacInput.value && cac < 0) {
                showError(cacInput, 'CAC cannot be negative');
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

        // Get CLV:CAC ratio performance
        function getRatioPerformance(ratio) {
            if (ratio < ratioThresholds.critical) {
                return {
                    level: 'critical',
                    badge: 'Critical',
                    text: 'You\'re losing money on each customer',
                    barWidth: Math.min((ratio / ratioThresholds.critical) * 16.67, 16.67)
                };
            } else if (ratio < ratioThresholds.poor) {
                return {
                    level: 'poor',
                    badge: 'Poor',
                    text: 'Barely profitable',
                    barWidth: 16.67 + ((ratio - ratioThresholds.critical) / (ratioThresholds.poor - ratioThresholds.critical)) * 16.67
                };
            } else if (ratio < ratioThresholds.average) {
                return {
                    level: 'average',
                    badge: 'Average',
                    text: 'Industry standard minimum',
                    barWidth: 33.34 + ((ratio - ratioThresholds.poor) / (ratioThresholds.average - ratioThresholds.poor)) * 33.33
                };
            } else if (ratio < ratioThresholds.good) {
                return {
                    level: 'good',
                    badge: 'Good',
                    text: 'Healthy customer economics',
                    barWidth: 66.67 + ((ratio - ratioThresholds.average) / (ratioThresholds.good - ratioThresholds.average)) * 16.67
                };
            } else {
                return {
                    level: 'excellent',
                    badge: 'Excellent',
                    text: 'Strong unit economics',
                    barWidth: Math.min(83.34 + ((ratio - ratioThresholds.good) / ratioThresholds.good) * 16.66, 100)
                };
            }
        }

        // Calculate CLV
        function calculateCLV() {
            if (!validateInputs()) {
                return;
            }

            // Show loading state
            calculateBtn.classList.add('loading');
            calculateBtn.disabled = true;

            // Simulate calculation delay for better UX
            setTimeout(function() {
                const purchaseValue = parseFormattedNumber(purchaseValueInput.value);
                const frequency = parseFormattedNumber(frequencyInput.value);
                const lifespan = parseFormattedNumber(lifespanInput.value);
                const margin = marginInput ? parseFormattedNumber(marginInput.value) : 0;
                const cac = cacInput ? parseFormattedNumber(cacInput.value) : 0;

                // Calculate CLV
                const annualValue = purchaseValue * frequency;
                const clv = annualValue * lifespan;
                const totalOrders = frequency * lifespan;

                // Animate main CLV result
                animateValue(mainResultValue, 0, clv, 1000, formatCurrency);

                // Show profit-based CLV if margin provided
                if (showProfitMargin && profitSection && margin > 0) {
                    const profitBasedCLV = clv * (margin / 100);
                    animateValue(profitResultValue, 0, profitBasedCLV, 1000, formatCurrency);
                    profitSection.style.display = 'block';
                } else if (profitSection) {
                    profitSection.style.display = 'none';
                }

                // Show CLV:CAC ratio if CAC provided
                if (showCacField && ratioSection && cac > 0) {
                    const ratio = clv / cac;
                    const performance = getRatioPerformance(ratio);

                    // Update ratio display
                    ratioValue.textContent = ratio.toFixed(1) + ':1';

                    // Update progress bar
                    if (ratioBarFill) {
                        ratioBarFill.style.width = performance.barWidth + '%';
                    }

                    // Update status badge
                    if (statusBadge) {
                        statusBadge.className = 'clv-status-badge ' + performance.level;
                        statusBadge.textContent = performance.badge;
                    }

                    // Update status text
                    if (statusText) {
                        statusText.textContent = performance.text;
                    }

                    ratioSection.style.display = 'block';

                    // Show net value and payback
                    const netValue = clv - cac;
                    const paybackMonths = (cac / annualValue) * 12;

                    if (netValueCard && netValueEl) {
                        animateValue(netValueEl, 0, netValue, 800, formatCurrency);
                        netValueCard.style.display = 'block';
                    }

                    if (paybackCard && paybackEl) {
                        const paybackText = paybackMonths > 24
                            ? (paybackMonths / 12).toFixed(1) + ' years'
                            : paybackMonths.toFixed(1) + ' months';

                        setTimeout(function() {
                            paybackEl.textContent = paybackText;
                        }, 400);

                        paybackCard.style.display = 'block';
                    }
                } else if (ratioSection) {
                    ratioSection.style.display = 'none';
                    if (netValueCard) netValueCard.style.display = 'none';
                    if (paybackCard) paybackCard.style.display = 'none';
                }

                // Update metrics
                if (annualValueEl) {
                    animateValue(annualValueEl, 0, annualValue, 800, formatCurrency);
                }

                if (totalOrdersEl) {
                    animateValue(totalOrdersEl, 0, totalOrders, 800, function(val) {
                        return Math.round(val).toString();
                    });
                }

                // Update breakdown
                if (breakdownApv) breakdownApv.textContent = formatCurrency(purchaseValue);
                if (breakdownFreq) breakdownFreq.textContent = frequency.toFixed(1) + ' /year';
                if (breakdownAnnual) breakdownAnnual.textContent = formatCurrency(annualValue);
                if (breakdownLifespan) breakdownLifespan.textContent = lifespan.toFixed(1) + ' years';
                if (breakdownTotal) breakdownTotal.textContent = formatCurrency(clv);

                // Update What-If Simulator
                if (simApv) {
                    const newApv = purchaseValue * 1.1;
                    const newCLV = newApv * frequency * lifespan;
                    const increase = newCLV - clv;
                    simApv.textContent = '+' + formatCurrency(increase);
                }

                if (simFreq) {
                    const newFreq = frequency + 1;
                    const newCLV = purchaseValue * newFreq * lifespan;
                    const increase = newCLV - clv;
                    simFreq.textContent = '+' + formatCurrency(increase);
                }

                if (simLife) {
                    const newLife = lifespan + 1;
                    const newCLV = purchaseValue * frequency * newLife;
                    const increase = newCLV - clv;
                    simLife.textContent = '+' + formatCurrency(increase);
                }

                // Show results
                resultsDiv.style.display = 'block';

                // Remove loading state
                calculateBtn.classList.remove('loading');
                calculateBtn.disabled = false;

                // Scroll to results
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

                // Announce to screen readers
                announceToScreenReader('CLV calculated: ' + formatCurrency(clv));

            }, 400);
        }

        // Reset calculator
        function resetCalculator() {
            // Clear all inputs
            purchaseValueInput.value = '';
            frequencyInput.value = '';
            lifespanInput.value = '';
            if (marginInput) marginInput.value = '';
            if (cacInput) cacInput.value = '';

            // Clear errors
            clearError(purchaseValueInput);
            clearError(frequencyInput);
            clearError(lifespanInput);
            if (marginInput) clearError(marginInput);
            if (cacInput) clearError(cacInput);

            // Hide results
            resultsDiv.style.display = 'none';

            // Scroll to top
            wrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Copy results to clipboard
        function copyResults() {
            const clv = mainResultValue.textContent;
            const annual = annualValueEl ? annualValueEl.textContent : '';
            const orders = totalOrdersEl ? totalOrdersEl.textContent : '';

            let text = `Customer Lifetime Value: ${clv}\n`;

            if (annual) {
                text += `Annual Customer Value: ${annual}\n`;
            }

            if (orders) {
                text += `Lifetime Orders: ${orders}\n`;
            }

            if (showProfitMargin && profitSection && profitSection.style.display !== 'none') {
                const profit = profitResultValue.textContent;
                text += `Profit-Based CLV: ${profit}\n`;
            }

            if (showCacField && ratioSection && ratioSection.style.display !== 'none') {
                const ratio = ratioValue.textContent;
                text += `CLV:CAC Ratio: ${ratio}\n`;

                if (netValueEl && netValueCard && netValueCard.style.display !== 'none') {
                    text += `Net Value Per Customer: ${netValueEl.textContent}\n`;
                }

                if (paybackEl && paybackCard && paybackCard.style.display !== 'none') {
                    text += `CAC Payback Period: ${paybackEl.textContent}\n`;
                }
            }

            // Copy to clipboard
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    // Show copied feedback
                    copyBtn.classList.add('copied');
                    const originalText = copyBtn.textContent;
                    copyBtn.textContent = '✓ Copied!';

                    setTimeout(function() {
                        copyBtn.classList.remove('copied');
                        copyBtn.textContent = originalText;
                    }, 2000);
                }).catch(function(err) {
                    console.error('Failed to copy:', err);
                });
            } else {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.select();

                try {
                    document.execCommand('copy');
                    copyBtn.classList.add('copied');
                    const originalText = copyBtn.textContent;
                    copyBtn.textContent = '✓ Copied!';

                    setTimeout(function() {
                        copyBtn.classList.remove('copied');
                        copyBtn.textContent = originalText;
                    }, 2000);
                } catch (err) {
                    console.error('Failed to copy:', err);
                }

                document.body.removeChild(textarea);
            }
        }

        // Currency change handler
        function handleCurrencyChange() {
            currentCurrency = currencySelect.value;
            localStorage.setItem('clv_currency', currentCurrency);
            updateCurrencyDisplay();

            // If results are visible, recalculate to update currency symbols
            if (resultsDiv.style.display === 'block') {
                calculateCLV();
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
        calculateBtn.addEventListener('click', calculateCLV);
        resetBtn.addEventListener('click', resetCalculator);
        copyBtn.addEventListener('click', copyResults);

        if (currencySelect) {
            currencySelect.addEventListener('change', handleCurrencyChange);
        }

        // Clear errors on input
        purchaseValueInput.addEventListener('input', function() {
            clearError(this);
        });

        frequencyInput.addEventListener('input', function() {
            clearError(this);
        });

        lifespanInput.addEventListener('input', function() {
            clearError(this);
        });

        if (marginInput) {
            marginInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        if (cacInput) {
            cacInput.addEventListener('input', function() {
                clearError(this);
            });
        }

        // Enter key support
        [purchaseValueInput, frequencyInput, lifespanInput, marginInput, cacInput].forEach(function(input) {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        calculateCLV();
                    }
                });
            }
        });

        // Format currency on blur
        purchaseValueInput.addEventListener('blur', function() {
            const value = parseFormattedNumber(this.value);
            if (value > 0) {
                this.value = value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        });

        if (cacInput) {
            cacInput.addEventListener('blur', function() {
                const value = parseFormattedNumber(this.value);
                if (value > 0) {
                    this.value = value.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            });
        }

        // Remove formatting on focus
        purchaseValueInput.addEventListener('focus', function() {
            const value = parseFormattedNumber(this.value);
            if (value > 0) {
                this.value = value.toString();
            }
        });

        if (cacInput) {
            cacInput.addEventListener('focus', function() {
                const value = parseFormattedNumber(this.value);
                if (value >= 0) {
                    this.value = value.toString();
                }
            });
        }

        // Format frequency and lifespan on blur
        frequencyInput.addEventListener('blur', function() {
            const value = parseFormattedNumber(this.value);
            if (value >= 0) {
                this.value = value.toFixed(1);
            }
        });

        lifespanInput.addEventListener('blur', function() {
            const value = parseFormattedNumber(this.value);
            if (value >= 0) {
                this.value = value.toFixed(1);
            }
        });

        if (marginInput) {
            marginInput.addEventListener('blur', function() {
                const value = parseFormattedNumber(this.value);
                if (value >= 0) {
                    this.value = value.toFixed(1);
                }
            });
        }
    }
})();
