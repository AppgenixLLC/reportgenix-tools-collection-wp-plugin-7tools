/**
 * UTM Builder JavaScript
 * Version: 2.0.0
 */

(function() {
    'use strict';

    // Initialize all UTM builders on the page
    document.addEventListener('DOMContentLoaded', function() {
        const builders = document.querySelectorAll('.utmb-wrapper');

        builders.forEach(function(builder) {
            initUTMBuilder(builder);
        });
    });

    function initUTMBuilder(wrapper) {
        // Get all inputs and elements
        const websiteUrlInput = wrapper.querySelector('#utmb-website-url');
        const sourceInput = wrapper.querySelector('#utmb-source');
        const mediumInput = wrapper.querySelector('#utmb-medium');
        const campaignInput = wrapper.querySelector('#utmb-campaign');
        const termInput = wrapper.querySelector('#utmb-term');
        const contentInput = wrapper.querySelector('#utmb-content');
        const idInput = wrapper.querySelector('#utmb-id');
        const previewElement = wrapper.querySelector('#utmb-preview-url');
        const generateBtn = wrapper.querySelector('.utmb-generate-btn');
        const resultsDiv = wrapper.querySelector('.utmb-results');
        const finalUrlElement = wrapper.querySelector('#utmb-final-url');
        const urlLengthElement = wrapper.querySelector('#utmb-url-length');
        const copyBtn = wrapper.querySelector('.utmb-copy-btn');
        const resetBtn = wrapper.querySelector('.utmb-reset-btn');
        const breakdownTbody = wrapper.querySelector('#utmb-breakdown-tbody');
        const qrCodeElement = wrapper.querySelector('#utmb-qr-code');
        const downloadQrBtn = wrapper.querySelector('.utmb-download-qr-btn');
        const toast = wrapper.querySelector('#utmb-toast');

        // Get settings from data attributes
        const showTerm = wrapper.dataset.showTerm === 'true';
        const showContent = wrapper.dataset.showContent === 'true';
        const showId = wrapper.dataset.showId === 'true';
        const showQr = wrapper.dataset.showQr === 'true';
        const showBreakdown = wrapper.dataset.showBreakdown === 'true';
        const rememberValues = wrapper.dataset.rememberValues === 'true';

        // Store final URL
        let finalUrl = '';

        // Load saved values from localStorage if enabled
        if (rememberValues) {
            loadSavedValues();
        }

        // Update preview on any input change
        const allInputs = [websiteUrlInput, sourceInput, mediumInput, campaignInput];
        if (termInput) allInputs.push(termInput);
        if (contentInput) allInputs.push(contentInput);
        if (idInput) allInputs.push(idInput);

        allInputs.forEach(function(input) {
            if (input) {
                input.addEventListener('input', function() {
                    updatePreview();
                    if (rememberValues) {
                        saveValues();
                    }
                });

                input.addEventListener('change', function() {
                    updatePreview();
                    if (rememberValues) {
                        saveValues();
                    }
                });
            }
        });

        // Initial preview update
        updatePreview();

        // Validate URL format
        function isValidUrl(string) {
            try {
                // Add protocol if missing
                let urlString = string.trim();
                if (!/^https?:\/\//i.test(urlString)) {
                    urlString = 'https://' + urlString;
                }

                const url = new URL(urlString);
                return url.protocol === 'http:' || url.protocol === 'https:';
            } catch (err) {
                return false;
            }
        }

        // Normalize URL (add protocol if missing)
        function normalizeUrl(string) {
            let urlString = string.trim();
            if (!/^https?:\/\//i.test(urlString)) {
                urlString = 'https://' + urlString;
            }
            return urlString;
        }

        // Format campaign name (lowercase, spaces to underscores)
        function formatCampaignName(value) {
            return value.trim().toLowerCase().replace(/\s+/g, '_');
        }

        // Build UTM URL
        function buildUTMUrl(baseUrl, params) {
            try {
                const normalizedUrl = normalizeUrl(baseUrl);
                const url = new URL(normalizedUrl);

                // Add UTM parameters
                if (params.source) {
                    url.searchParams.set('utm_source', params.source.toLowerCase().trim());
                }
                if (params.medium) {
                    url.searchParams.set('utm_medium', params.medium.toLowerCase().trim());
                }
                if (params.campaign) {
                    url.searchParams.set('utm_campaign', formatCampaignName(params.campaign));
                }
                if (params.term && showTerm) {
                    url.searchParams.set('utm_term', params.term.toLowerCase().trim());
                }
                if (params.content && showContent) {
                    url.searchParams.set('utm_content', params.content.toLowerCase().trim());
                }
                if (params.id && showId) {
                    url.searchParams.set('utm_id', params.id.trim());
                }

                return url.toString();
            } catch (err) {
                console.error('Error building UTM URL:', err);
                return '';
            }
        }

        // Update live preview
        function updatePreview() {
            const websiteUrl = websiteUrlInput.value.trim();
            const source = sourceInput.value.trim();
            const medium = mediumInput.value;
            const campaign = campaignInput.value.trim();
            const term = termInput ? termInput.value.trim() : '';
            const content = contentInput ? contentInput.value.trim() : '';
            const id = idInput ? idInput.value.trim() : '';

            // Clear errors
            clearErrors();

            // If no URL, show placeholder
            if (!websiteUrl) {
                previewElement.textContent = 'Enter a website URL to see preview...';
                previewElement.classList.add('empty');
                return;
            }

            // Validate URL
            if (!isValidUrl(websiteUrl)) {
                previewElement.textContent = 'Invalid URL format. Please enter a valid website URL.';
                previewElement.classList.add('empty');
                showError(websiteUrlInput, 'Please enter a valid URL (e.g., example.com or https://example.com)');
                return;
            }

            // If URL is valid but no UTM params, show base URL
            if (!source && !medium && !campaign) {
                const normalizedUrl = normalizeUrl(websiteUrl);
                previewElement.textContent = normalizedUrl;
                previewElement.classList.remove('empty');
                return;
            }

            // Build preview URL
            const params = {
                source: source,
                medium: medium,
                campaign: campaign,
                term: term,
                content: content,
                id: id
            };

            const previewUrl = buildUTMUrl(websiteUrl, params);

            if (previewUrl) {
                previewElement.textContent = previewUrl;
                previewElement.classList.remove('empty');
            } else {
                previewElement.textContent = 'Enter a website URL to see preview...';
                previewElement.classList.add('empty');
            }
        }

        // Validate inputs
        function validateInputs() {
            let isValid = true;

            // Clear previous errors
            clearErrors();

            // Validate website URL
            const websiteUrl = websiteUrlInput.value.trim();
            if (!websiteUrl) {
                showError(websiteUrlInput, 'Website URL is required');
                isValid = false;
            } else if (!isValidUrl(websiteUrl)) {
                showError(websiteUrlInput, 'Please enter a valid URL (e.g., example.com or https://example.com)');
                isValid = false;
            }

            // Validate campaign source
            const source = sourceInput.value.trim();
            if (!source) {
                showError(sourceInput, 'Campaign Source is required');
                isValid = false;
            }

            // Validate campaign medium
            const medium = mediumInput.value;
            if (!medium) {
                showError(mediumInput, 'Campaign Medium is required');
                isValid = false;
            }

            // Validate campaign name
            const campaign = campaignInput.value.trim();
            if (!campaign) {
                showError(campaignInput, 'Campaign Name is required');
                isValid = false;
            }

            return isValid;
        }

        // Show error message
        function showError(input, message) {
            const fieldGroup = input.closest('.utmb-field');
            if (!fieldGroup) return;

            const errorSpan = fieldGroup.querySelector('.utmb-error');
            if (errorSpan) {
                errorSpan.textContent = message;
            }

            input.classList.add('utmb-error-input');
        }

        // Clear all errors
        function clearErrors() {
            const errorSpans = wrapper.querySelectorAll('.utmb-error');
            errorSpans.forEach(function(span) {
                span.textContent = '';
            });

            const errorInputs = wrapper.querySelectorAll('.utmb-error-input');
            errorInputs.forEach(function(input) {
                input.classList.remove('utmb-error-input');
            });
        }

        // Generate UTM URL
        function generateURL() {
            if (!validateInputs()) {
                return;
            }

            // Show loading state
            generateBtn.classList.add('loading');
            generateBtn.disabled = true;

            // Small delay for better UX
            setTimeout(function() {
                const websiteUrl = websiteUrlInput.value.trim();
                const source = sourceInput.value.trim();
                const medium = mediumInput.value;
                const campaign = campaignInput.value.trim();
                const term = termInput ? termInput.value.trim() : '';
                const content = contentInput ? contentInput.value.trim() : '';
                const id = idInput ? idInput.value.trim() : '';

                const params = {
                    source: source,
                    medium: medium,
                    campaign: campaign,
                    term: term,
                    content: content,
                    id: id
                };

                // Build final URL
                finalUrl = buildUTMUrl(websiteUrl, params);

                if (!finalUrl) {
                    showToast('Error generating URL. Please check your inputs.', 'error');
                    generateBtn.classList.remove('loading');
                    generateBtn.disabled = false;
                    return;
                }

                // Display final URL
                finalUrlElement.textContent = finalUrl;

                // Display URL length
                urlLengthElement.textContent = finalUrl.length;

                // Add warning color if URL is too long
                if (finalUrl.length > 2048) {
                    urlLengthElement.style.color = '#EF4444';
                    urlLengthElement.title = 'Warning: URL exceeds recommended length of 2048 characters';
                } else {
                    urlLengthElement.style.color = '#10B981';
                    urlLengthElement.title = 'URL length is within recommended limits';
                }

                // Update breakdown table if enabled
                if (showBreakdown && breakdownTbody) {
                    updateBreakdownTable(params);
                }

                // Generate QR code if enabled
                if (showQr && qrCodeElement) {
                    generateQRCode(finalUrl);
                }

                // Remove loading state
                generateBtn.classList.remove('loading');
                generateBtn.disabled = false;

                // Show results
                resultsDiv.style.display = 'block';

                // Scroll to results
                resultsDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            }, 300);
        }

        // Update breakdown table
        function updateBreakdownTable(params) {
            const normalizedUrl = normalizeUrl(websiteUrlInput.value.trim());
            let baseUrl = '';

            try {
                const url = new URL(normalizedUrl);
                baseUrl = url.origin + url.pathname;
                if (url.search) {
                    // Show existing query parameters
                    const existingParams = new URLSearchParams(url.search);
                    existingParams.forEach(function(value, key) {
                        if (!key.startsWith('utm_')) {
                            baseUrl += (baseUrl.includes('?') ? '&' : '?') + key + '=' + value;
                        }
                    });
                }
            } catch (err) {
                baseUrl = normalizedUrl;
            }

            const rows = [];

            // Base URL
            rows.push(createBreakdownRow('Base URL', baseUrl));

            // UTM Parameters
            if (params.source) {
                rows.push(createBreakdownRow('utm_source', params.source.toLowerCase().trim(), 'Campaign Source - The referrer (e.g., facebook, google, newsletter)'));
            }
            if (params.medium) {
                rows.push(createBreakdownRow('utm_medium', params.medium.toLowerCase().trim(), 'Campaign Medium - The marketing medium (e.g., cpc, email, social)'));
            }
            if (params.campaign) {
                rows.push(createBreakdownRow('utm_campaign', formatCampaignName(params.campaign), 'Campaign Name - The specific campaign name'));
            }
            if (params.term && showTerm) {
                rows.push(createBreakdownRow('utm_term', params.term.toLowerCase().trim(), 'Campaign Term - Paid search keywords'));
            }
            if (params.content && showContent) {
                rows.push(createBreakdownRow('utm_content', params.content.toLowerCase().trim(), 'Campaign Content - To differentiate similar content or links'));
            }
            if (params.id && showId) {
                rows.push(createBreakdownRow('utm_id', params.id.trim(), 'Campaign ID - Internal campaign identifier'));
            }

            breakdownTbody.innerHTML = rows.join('');
        }

        // Create breakdown table row
        function createBreakdownRow(parameter, value, description) {
            description = description || '';
            return `
                <tr>
                    <td class="utmb-breakdown-param">${escapeHtml(parameter)}</td>
                    <td class="utmb-breakdown-value">${escapeHtml(value)}</td>
                    ${description ? '<td class="utmb-breakdown-desc">' + escapeHtml(description) + '</td>' : ''}
                </tr>
            `;
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return String(text).replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Generate QR Code
        function generateQRCode(url) {
            const qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=' + encodeURIComponent(url);

            qrCodeElement.innerHTML = `
                <img src="${qrApiUrl}"
                     alt="QR Code for UTM URL"
                     class="utmb-qr-image"
                     loading="lazy" />
            `;

            // Store QR URL for download
            if (downloadQrBtn) {
                downloadQrBtn.dataset.qrUrl = qrApiUrl;
            }
        }

        // Copy to clipboard
        function copyToClipboard() {
            if (!finalUrl) return;

            const text = finalUrl;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function() {
                    showCopiedState();
                    showToast('URL copied to clipboard!', 'success');
                }).catch(function(err) {
                    console.error('Failed to copy:', err);
                    fallbackCopy(text);
                });
            } else {
                fallbackCopy(text);
            }
        }

        // Fallback copy method for older browsers
        function fallbackCopy(text) {
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
                    showCopiedState();
                    showToast('URL copied to clipboard!', 'success');
                } else {
                    showToast('Failed to copy to clipboard', 'error');
                }
            } catch (err) {
                document.body.removeChild(textarea);
                console.error('Fallback copy failed:', err);
                showToast('Failed to copy to clipboard', 'error');
            }
        }

        // Show copied state
        function showCopiedState() {
            const originalText = copyBtn.innerHTML;
            copyBtn.innerHTML = '✓ Copied!';
            copyBtn.classList.add('copied');

            setTimeout(function() {
                copyBtn.innerHTML = originalText;
                copyBtn.classList.remove('copied');
            }, 2000);
        }

        // Download QR Code
        function downloadQRCode() {
            if (!downloadQrBtn || !downloadQrBtn.dataset.qrUrl) return;

            const qrUrl = downloadQrBtn.dataset.qrUrl;

            // Create a temporary link to download the image
            const link = document.createElement('a');
            link.href = qrUrl;
            link.download = 'utm-qr-code-' + Date.now() + '.png';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            showToast('QR Code download started!', 'success');
        }

        // Reset form
        function resetForm() {
            // Clear all inputs
            websiteUrlInput.value = '';
            sourceInput.value = '';
            mediumInput.selectedIndex = 0;
            campaignInput.value = '';
            if (termInput) termInput.value = '';
            if (contentInput) contentInput.value = '';
            if (idInput) idInput.value = '';

            // Clear errors
            clearErrors();

            // Update preview
            updatePreview();

            // Hide results
            resultsDiv.style.display = 'none';

            // Clear final URL
            finalUrl = '';

            // Clear localStorage if enabled
            if (rememberValues) {
                clearSavedValues();
            }

            // Focus on first input
            websiteUrlInput.focus();
        }

        // Save values to localStorage
        function saveValues() {
            if (!rememberValues) return;

            const values = {
                websiteUrl: websiteUrlInput.value,
                source: sourceInput.value,
                medium: mediumInput.value,
                campaign: campaignInput.value
            };

            if (termInput) values.term = termInput.value;
            if (contentInput) values.content = contentInput.value;
            if (idInput) values.id = idInput.value;

            try {
                localStorage.setItem('utmb_values', JSON.stringify(values));
            } catch (err) {
                console.error('Failed to save values:', err);
            }
        }

        // Load saved values from localStorage
        function loadSavedValues() {
            if (!rememberValues) return;

            try {
                const saved = localStorage.getItem('utmb_values');
                if (!saved) return;

                const values = JSON.parse(saved);

                if (values.websiteUrl) websiteUrlInput.value = values.websiteUrl;
                if (values.source) sourceInput.value = values.source;
                if (values.medium) mediumInput.value = values.medium;
                if (values.campaign) campaignInput.value = values.campaign;
                if (values.term && termInput) termInput.value = values.term;
                if (values.content && contentInput) contentInput.value = values.content;
                if (values.id && idInput) idInput.value = values.id;

            } catch (err) {
                console.error('Failed to load saved values:', err);
            }
        }

        // Clear saved values from localStorage
        function clearSavedValues() {
            if (!rememberValues) return;

            try {
                localStorage.removeItem('utmb_values');
            } catch (err) {
                console.error('Failed to clear saved values:', err);
            }
        }

        // Show toast notification
        function showToast(message, type) {
            if (!toast) return;

            type = type || 'success';

            const messageEl = toast.querySelector('.utmb-toast-message');
            if (messageEl) {
                messageEl.textContent = message;
            }

            // Update toast style based on type
            toast.classList.remove('success', 'error');
            toast.classList.add(type);

            toast.style.display = 'flex';

            setTimeout(function() {
                toast.style.display = 'none';
            }, 3000);
        }

        // Event listeners
        generateBtn.addEventListener('click', generateURL);
        copyBtn.addEventListener('click', copyToClipboard);
        resetBtn.addEventListener('click', resetForm);

        if (downloadQrBtn && showQr) {
            downloadQrBtn.addEventListener('click', downloadQRCode);
        }

        // Clear errors on input
        allInputs.forEach(function(input) {
            if (input) {
                input.addEventListener('input', function() {
                    const fieldGroup = this.closest('.utmb-field');
                    if (fieldGroup) {
                        const errorSpan = fieldGroup.querySelector('.utmb-error');
                        if (errorSpan) errorSpan.textContent = '';
                    }
                    this.classList.remove('utmb-error-input');
                });
            }
        });

        // Enter key support
        allInputs.forEach(function(input) {
            if (input) {
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        generateURL();
                    }
                });
            }
        });
    }
})();
