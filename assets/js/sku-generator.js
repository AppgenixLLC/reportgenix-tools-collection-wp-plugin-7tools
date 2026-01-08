/**
 * SKU Generator JavaScript
 * Version: 2.0.0
 */

(function() {
    'use strict';

    // Initialize all SKU generators on the page
    document.addEventListener('DOMContentLoaded', function() {
        const generators = document.querySelectorAll('.skugen-wrapper');

        generators.forEach(function(generator) {
            initSKUGenerator(generator);
        });
    });

    function initSKUGenerator(wrapper) {
        // Get all inputs and elements
        const prefixInput = wrapper.querySelector('#skugen-prefix');
        const suffixInput = wrapper.querySelector('#skugen-suffix');
        const lengthSelect = wrapper.querySelector('#skugen-length');
        const countInput = wrapper.querySelector('#skugen-count');
        const typeSelect = wrapper.querySelector('#skugen-type');
        const separatorSelect = wrapper.querySelector('#skugen-separator');
        const startInput = wrapper.querySelector('#skugen-start');
        const startField = wrapper.querySelector('#skugen-start-field');
        const excludeConfusingCheckbox = wrapper.querySelector('#skugen-exclude-confusing');
        const previewElement = wrapper.querySelector('#skugen-preview');
        const generateBtn = wrapper.querySelector('.skugen-generate-btn');
        const resultsDiv = wrapper.querySelector('.skugen-results');
        const skuList = wrapper.querySelector('#skugen-sku-list');
        const statsCount = wrapper.querySelector('#skugen-stats-count');
        const copyAllBtn = wrapper.querySelector('.skugen-copy-all-btn');
        const downloadCsvBtn = wrapper.querySelector('.skugen-download-csv-btn');
        const downloadTxtBtn = wrapper.querySelector('.skugen-download-txt-btn');
        const clearBtn = wrapper.querySelector('.skugen-clear-btn');
        const toast = wrapper.querySelector('#skugen-toast');

        // Get settings from data attributes
        const maxSkus = parseInt(wrapper.dataset.maxSkus) || 1000;
        const showExport = wrapper.dataset.showExport === 'true';
        const showPreview = wrapper.dataset.showPreview === 'true';

        // Store generated SKUs
        let generatedSKUs = [];

        // Auto-uppercase prefix and suffix inputs
        if (prefixInput) {
            prefixInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                updatePreview();
            });
        }

        if (suffixInput) {
            suffixInput.addEventListener('input', function() {
                this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                updatePreview();
            });
        }

        // Show/hide starting number field based on type
        typeSelect.addEventListener('change', function() {
            if (this.value === 'sequential') {
                startField.style.display = 'block';
            } else {
                startField.style.display = 'none';
            }
            updatePreview();
        });

        // Update preview on any input change
        if (showPreview && previewElement) {
            [lengthSelect, separatorSelect, excludeConfusingCheckbox, startInput].forEach(function(el) {
                if (el) {
                    el.addEventListener('change', updatePreview);
                    if (el.tagName === 'INPUT') {
                        el.addEventListener('input', updatePreview);
                    }
                }
            });
        }

        // Initial preview update
        updatePreview();

        // Update preview function
        function updatePreview() {
            if (!showPreview || !previewElement) return;

            const prefix = prefixInput ? prefixInput.value : '';
            const suffix = suffixInput ? suffixInput.value : '';
            const length = parseInt(lengthSelect.value);
            const type = typeSelect.value;
            const separator = separatorSelect.value;
            const excludeConfusing = excludeConfusingCheckbox.checked;

            // Generate sample code
            let sampleCode = '';

            if (type === 'sequential') {
                const start = parseInt(startInput.value) || 1;
                sampleCode = String(start).padStart(length, '0');
            } else if (type === 'random_numbers') {
                const digits = excludeConfusing ? '23456789' : '0123456789';
                for (let i = 0; i < length; i++) {
                    sampleCode += digits[Math.floor(Math.random() * digits.length)];
                }
            } else if (type === 'letters') {
                const letters = excludeConfusing ? 'ABCDEFGHJKLMNPQRSTUVWXYZ' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                for (let i = 0; i < length; i++) {
                    sampleCode += letters[Math.floor(Math.random() * letters.length)];
                }
            } else if (type === 'alphanumeric') {
                const chars = excludeConfusing ? 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                for (let i = 0; i < length; i++) {
                    sampleCode += chars[Math.floor(Math.random() * chars.length)];
                }
            }

            // Assemble preview SKU
            const parts = [prefix, sampleCode, suffix].filter(p => p);
            previewElement.textContent = parts.join(separator).toUpperCase();
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;
            const count = parseInt(countInput.value);

            // Clear previous errors
            const errorSpan = countInput.parentElement.querySelector('.skugen-error');
            if (errorSpan) errorSpan.textContent = '';
            countInput.classList.remove('skugen-error-input');

            // Validate count
            if (!count || count < 1 || count > maxSkus) {
                if (errorSpan) {
                    errorSpan.textContent = `Please enter a number between 1 and ${maxSkus}`;
                }
                countInput.classList.add('skugen-error-input');
                isValid = false;
            }

            // Warn for large batches
            if (count > 500 && isValid) {
                const confirmed = confirm(`You're about to generate ${count} SKUs. This may take a moment. Continue?`);
                if (!confirmed) {
                    isValid = false;
                }
            }

            return isValid;
        }

        // Generate sequential numbers
        function generateSequential(length, count, startNum, excludeConfusing) {
            const skus = [];
            const maxPossible = Math.pow(10, length);

            if (count > maxPossible) {
                alert(`Cannot generate ${count} SKUs with length ${length}. Maximum possible: ${maxPossible}`);
                return [];
            }

            for (let i = 0; i < count; i++) {
                let num = String(startNum + i).padStart(length, '0');

                // Check for confusing characters if option is enabled
                if (excludeConfusing && (num.includes('0') || num.includes('1'))) {
                    // Skip this number and increment counter
                    count++;
                    continue;
                }

                skus.push(num);
            }

            return skus;
        }

        // Generate random numbers
        function generateRandomNumbers(length, count, excludeConfusing) {
            const digits = excludeConfusing ? '23456789' : '0123456789';
            const skus = new Set();
            const maxAttempts = count * 10; // Prevent infinite loop
            let attempts = 0;

            while (skus.size < count && attempts < maxAttempts) {
                let sku = '';
                for (let i = 0; i < length; i++) {
                    sku += digits[Math.floor(Math.random() * digits.length)];
                }
                skus.add(sku);
                attempts++;
            }

            if (skus.size < count) {
                alert(`Could only generate ${skus.size} unique SKUs. Try increasing the length or reducing the count.`);
            }

            return Array.from(skus);
        }

        // Generate random letters
        function generateLetters(length, count, excludeConfusing) {
            const letters = excludeConfusing ? 'ABCDEFGHJKLMNPQRSTUVWXYZ' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const skus = new Set();
            const maxAttempts = count * 10;
            let attempts = 0;

            while (skus.size < count && attempts < maxAttempts) {
                let sku = '';
                for (let i = 0; i < length; i++) {
                    sku += letters[Math.floor(Math.random() * letters.length)];
                }
                skus.add(sku);
                attempts++;
            }

            if (skus.size < count) {
                alert(`Could only generate ${skus.size} unique SKUs. Try increasing the length or reducing the count.`);
            }

            return Array.from(skus);
        }

        // Generate alphanumeric
        function generateAlphanumeric(length, count, excludeConfusing) {
            const chars = excludeConfusing ? 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            const skus = new Set();
            const maxAttempts = count * 10;
            let attempts = 0;

            while (skus.size < count && attempts < maxAttempts) {
                let sku = '';
                for (let i = 0; i < length; i++) {
                    sku += chars[Math.floor(Math.random() * chars.length)];
                }
                skus.add(sku);
                attempts++;
            }

            if (skus.size < count) {
                alert(`Could only generate ${skus.size} unique SKUs. Try increasing the length or reducing the count.`);
            }

            return Array.from(skus);
        }

        // Assemble final SKU
        function assembleSKU(prefix, code, suffix, separator) {
            const parts = [prefix, code, suffix].filter(p => p);
            return parts.join(separator).toUpperCase();
        }

        // Generate SKUs
        function generateSKUs() {
            if (!validateInputs()) {
                return;
            }

            // Show loading state
            generateBtn.classList.add('loading');
            generateBtn.disabled = true;

            // Small delay for better UX
            setTimeout(function() {
                const prefix = prefixInput ? prefixInput.value : '';
                const suffix = suffixInput ? suffixInput.value : '';
                const length = parseInt(lengthSelect.value);
                const count = parseInt(countInput.value);
                const type = typeSelect.value;
                const separator = separatorSelect.value;
                const startNum = parseInt(startInput.value) || 1;
                const excludeConfusing = excludeConfusingCheckbox.checked;

                // Generate codes based on type
                let codes = [];

                switch (type) {
                    case 'sequential':
                        codes = generateSequential(length, count, startNum, excludeConfusing);
                        break;
                    case 'random_numbers':
                        codes = generateRandomNumbers(length, count, excludeConfusing);
                        break;
                    case 'letters':
                        codes = generateLetters(length, count, excludeConfusing);
                        break;
                    case 'alphanumeric':
                        codes = generateAlphanumeric(length, count, excludeConfusing);
                        break;
                }

                // Assemble final SKUs
                generatedSKUs = codes.map(function(code) {
                    return assembleSKU(prefix, code, suffix, separator);
                });

                // Display SKUs
                displaySKUs();

                // Remove loading state
                generateBtn.classList.remove('loading');
                generateBtn.disabled = false;

                // Show results
                resultsDiv.style.display = 'block';

                // Scroll to results
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            }, 300);
        }

        // Display SKUs
        function displaySKUs() {
            // Clear existing list
            skuList.innerHTML = '';

            // Update stats
            statsCount.textContent = `${generatedSKUs.length} SKUs generated`;

            // Create SKU items
            generatedSKUs.forEach(function(sku, index) {
                const item = document.createElement('div');
                item.className = 'skugen-sku-item';

                const number = document.createElement('span');
                number.className = 'skugen-sku-number';
                number.textContent = (index + 1) + '.';

                const value = document.createElement('span');
                value.className = 'skugen-sku-value';
                value.textContent = sku;

                const copyBtn = document.createElement('button');
                copyBtn.className = 'skugen-copy-single';
                copyBtn.textContent = '📋';
                copyBtn.title = 'Copy';
                copyBtn.setAttribute('aria-label', 'Copy SKU');
                copyBtn.addEventListener('click', function() {
                    copySingleSKU(sku, copyBtn);
                });

                item.appendChild(number);
                item.appendChild(value);
                item.appendChild(copyBtn);

                skuList.appendChild(item);
            });
        }

        // Copy single SKU
        function copySingleSKU(sku, button) {
            copyToClipboard(sku).then(function() {
                const originalText = button.textContent;
                button.textContent = '✓';
                button.classList.add('copied');

                setTimeout(function() {
                    button.textContent = originalText;
                    button.classList.remove('copied');
                }, 1500);
            }).catch(function(err) {
                console.error('Failed to copy:', err);
            });
        }

        // Copy all SKUs
        function copyAllSKUs() {
            const text = generatedSKUs.join('\n');

            copyToClipboard(text).then(function() {
                showToast('All SKUs copied to clipboard!');

                copyAllBtn.classList.add('copied');
                setTimeout(function() {
                    copyAllBtn.classList.remove('copied');
                }, 2000);
            }).catch(function(err) {
                console.error('Failed to copy:', err);
                alert('Failed to copy to clipboard');
            });
        }

        // Copy to clipboard helper
        function copyToClipboard(text) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                return navigator.clipboard.writeText(text);
            } else {
                // Fallback for older browsers
                return new Promise(function(resolve, reject) {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.style.position = 'fixed';
                    textarea.style.opacity = '0';
                    document.body.appendChild(textarea);
                    textarea.select();

                    try {
                        const successful = document.execCommand('copy');
                        document.body.removeChild(textarea);

                        if (successful) {
                            resolve();
                        } else {
                            reject(new Error('Copy command failed'));
                        }
                    } catch (err) {
                        document.body.removeChild(textarea);
                        reject(err);
                    }
                });
            }
        }

        // Download as CSV
        function downloadCSV() {
            let csvContent = 'SKU\n';
            csvContent += generatedSKUs.join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);

            link.setAttribute('href', url);
            link.setAttribute('download', 'skus_' + Date.now() + '.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            showToast('CSV file downloaded!');
        }

        // Download as TXT
        function downloadTXT() {
            const txtContent = generatedSKUs.join('\n');

            const blob = new Blob([txtContent], { type: 'text/plain;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);

            link.setAttribute('href', url);
            link.setAttribute('download', 'skus_' + Date.now() + '.txt');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            showToast('TXT file downloaded!');
        }

        // Clear results
        function clearResults() {
            generatedSKUs = [];
            skuList.innerHTML = '';
            resultsDiv.style.display = 'none';
        }

        // Show toast notification
        function showToast(message) {
            if (!toast) return;

            const messageEl = toast.querySelector('.skugen-toast-message');
            if (messageEl) {
                messageEl.textContent = message;
            }

            toast.style.display = 'flex';

            setTimeout(function() {
                toast.style.display = 'none';
            }, 3000);
        }

        // Event listeners
        generateBtn.addEventListener('click', generateSKUs);
        copyAllBtn.addEventListener('click', copyAllSKUs);
        clearBtn.addEventListener('click', clearResults);

        if (showExport) {
            if (downloadCsvBtn) {
                downloadCsvBtn.addEventListener('click', downloadCSV);
            }
            if (downloadTxtBtn) {
                downloadTxtBtn.addEventListener('click', downloadTXT);
            }
        }

        // Clear errors on input
        countInput.addEventListener('input', function() {
            const errorSpan = this.parentElement.querySelector('.skugen-error');
            if (errorSpan) errorSpan.textContent = '';
            this.classList.remove('skugen-error-input');
        });

        // Enter key support
        [prefixInput, suffixInput, countInput, startInput].forEach(function(input) {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        generateSKUs();
                    }
                });
            }
        });
    }
})();
