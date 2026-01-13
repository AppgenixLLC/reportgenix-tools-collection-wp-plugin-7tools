<?php
/**
 * Plugin Name: ReportGenix Tools Collection
 * Plugin URI: https://reportgenix.com
 * Description: A collection of professional business calculators including Conversion Rate Calculator and ROI Calculator. Use shortcodes to display tools on any page.
 * Version: 2.1.0
 * Author: ReportGenix
 * Author URI: https://reportgenix.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: reportgenix-tools-collection
 * Requires at least: 5.0
 * Requires PHP: 7.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Main Plugin Class
 */
class ReportGenix_Tools_Collection {

    /**
     * Plugin version
     */
    const VERSION = '2.1.0';

    /**
     * Plugin directory path
     */
    private $plugin_path;

    /**
     * Plugin directory URL
     */
    private $plugin_url;

    /**
     * Constructor
     */
    public function __construct() {
        $this->plugin_path = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);

        // Register shortcodes
        add_shortcode('conversion_rate_calculator', array($this, 'render_conversion_calculator'));
        add_shortcode('roi_calculator', array($this, 'render_roi_calculator'));
        add_shortcode('roas_calculator', array($this, 'render_roas_calculator'));
        add_shortcode('cac_calculator', array($this, 'render_cac_calculator'));
        add_shortcode('clv_calculator', array($this, 'render_clv_calculator'));
        add_shortcode('sku_generator', array($this, 'render_sku_generator'));
        add_shortcode('utm_builder', array($this, 'render_utm_builder'));
        add_shortcode('gross_profit_calculator', array($this, 'render_gross_profit_calculator'));
        add_shortcode('pod_profit_calculator', array($this, 'render_pod_profit_calculator'));
        add_shortcode('shopify_fee_calculator', array($this, 'render_shopify_fee_calculator'));

        // Enqueue assets
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));

        // Add admin menu
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Enqueue admin styles
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    /**
     * Enqueue styles and scripts
     */
    public function enqueue_assets() {
        global $post;

        // Enqueue Conversion Rate Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'conversion_rate_calculator')) {
            wp_enqueue_style(
                'crc-calculator-style',
                $this->plugin_url . 'assets/css/calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'crc-calculator-script',
                $this->plugin_url . 'assets/js/calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue ROI Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'roi_calculator')) {
            wp_enqueue_style(
                'roic-calculator-style',
                $this->plugin_url . 'assets/css/roi-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'roic-calculator-script',
                $this->plugin_url . 'assets/js/roi-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue ROAS Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'roas_calculator')) {
            wp_enqueue_style(
                'roas-calculator-style',
                $this->plugin_url . 'assets/css/roas-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'roas-calculator-script',
                $this->plugin_url . 'assets/js/roas-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue CAC Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'cac_calculator')) {
            wp_enqueue_style(
                'cac-calculator-style',
                $this->plugin_url . 'assets/css/cac-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'cac-calculator-script',
                $this->plugin_url . 'assets/js/cac-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue CLV Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'clv_calculator')) {
            wp_enqueue_style(
                'clv-calculator-style',
                $this->plugin_url . 'assets/css/clv-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'clv-calculator-script',
                $this->plugin_url . 'assets/js/clv-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue SKU Generator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'sku_generator')) {
            wp_enqueue_style(
                'sku-generator-style',
                $this->plugin_url . 'assets/css/sku-generator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'sku-generator-script',
                $this->plugin_url . 'assets/js/sku-generator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue UTM Builder assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'utm_builder')) {
            wp_enqueue_style(
                'utm-builder-style',
                $this->plugin_url . 'assets/css/utm-builder.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'utm-builder-script',
                $this->plugin_url . 'assets/js/utm-builder.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue Gross Profit Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'gross_profit_calculator')) {
            wp_enqueue_style(
                'gross-profit-calculator-style',
                $this->plugin_url . 'assets/css/gross-profit-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'gross-profit-calculator-script',
                $this->plugin_url . 'assets/js/gross-profit-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue POD Profit Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'pod_profit_calculator')) {
            wp_enqueue_style(
                'pod-profit-calculator-style',
                $this->plugin_url . 'assets/css/pod-profit-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'pod-profit-calculator-script',
                $this->plugin_url . 'assets/js/pod-profit-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }

        // Enqueue Shopify Fee Calculator assets
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'shopify_fee_calculator')) {
            wp_enqueue_style(
                'shopify-fee-calculator-style',
                $this->plugin_url . 'assets/css/shopify-fee-calculator.css',
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_script(
                'shopify-fee-calculator-script',
                $this->plugin_url . 'assets/js/shopify-fee-calculator.js',
                array(),
                self::VERSION,
                true
            );
        }
    }

    /**
     * Render Conversion Rate Calculator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_conversion_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'Conversion Rate Calculator',
            'button_text' => 'Calculate Conversion Rate',
            'show_benchmark' => 'true',
            'primary_color' => '#4F46E5',
        ), $atts, 'conversion_rate_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $button_text = sanitize_text_field($atts['button_text']);
        $show_benchmark = filter_var($atts['show_benchmark'], FILTER_VALIDATE_BOOLEAN);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        if (!$primary_color) {
            $primary_color = '#4F46E5';
        }

        // Generate unique ID for this calculator instance
        $unique_id = 'crc_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="crc-calculator-wrapper" id="<?php echo esc_attr($unique_id); ?>" data-primary-color="<?php echo esc_attr($primary_color); ?>" data-show-benchmark="<?php echo $show_benchmark ? 'true' : 'false'; ?>">
            <h2 class="crc-title"><?php echo esc_html($title); ?></h2>

            <div class="crc-form">
                <div class="crc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-visitors">Total Visitors:</label>
                    <input
                        type="text"
                        inputmode="numeric"
                        id="<?php echo esc_attr($unique_id); ?>-visitors"
                        class="crc-input crc-visitors"
                        placeholder="e.g., 10000"
                        required
                        aria-required="true"
                        aria-describedby="<?php echo esc_attr($unique_id); ?>-visitors-error"
                    >
                    <span class="crc-error" id="<?php echo esc_attr($unique_id); ?>-visitors-error" role="alert"></span>
                </div>

                <div class="crc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-orders">Total Orders:</label>
                    <input
                        type="text"
                        inputmode="numeric"
                        id="<?php echo esc_attr($unique_id); ?>-orders"
                        class="crc-input crc-orders"
                        placeholder="e.g., 150"
                        required
                        aria-required="true"
                        aria-describedby="<?php echo esc_attr($unique_id); ?>-orders-error"
                    >
                    <span class="crc-error" id="<?php echo esc_attr($unique_id); ?>-orders-error" role="alert"></span>
                </div>

                <div class="crc-button-group">
                    <button
                        type="button"
                        class="crc-calculate-btn"
                        aria-label="Calculate conversion rate"
                    >
                        <?php echo esc_html($button_text); ?>
                    </button>
                    <button
                        type="button"
                        class="crc-reset-btn"
                        aria-label="Reset calculator"
                    >
                        Reset
                    </button>
                </div>
            </div>

            <div class="crc-result" style="display:none;" role="region" aria-live="polite">
                <div class="crc-rate-container">
                    <div class="crc-rate">
                        Your Conversion Rate: <span class="crc-rate-value">0.00%</span>
                    </div>
                    <button
                        type="button"
                        class="crc-copy-btn"
                        aria-label="Copy result to clipboard"
                        title="Copy to clipboard"
                    >
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        <span class="crc-copy-text">Copy</span>
                    </button>
                </div>
                <?php if ($show_benchmark) : ?>
                <div class="crc-benchmark"></div>
                <?php endif; ?>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render ROI Calculator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_roi_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'Calculate your ROI',
            'subtitle' => 'Enter data from your analytics.',
            'currency' => '$',
            'currency_position' => 'before',
            'improvement_options' => '',
            'cta_button' => 'false',
            'cta_text' => 'Get Started',
            'cta_url' => '#',
            'primary_color' => '#6366F1',
        ), $atts, 'roi_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $currency = sanitize_text_field($atts['currency']);
        $currency_position = in_array($atts['currency_position'], array('before', 'after')) ? $atts['currency_position'] : 'before';
        $show_cta = filter_var($atts['cta_button'], FILTER_VALIDATE_BOOLEAN);
        $cta_text = sanitize_text_field($atts['cta_text']);
        $cta_url = esc_url($atts['cta_url']);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        if (!$primary_color) {
            $primary_color = '#6366F1';
        }

        // Parse improvement options if provided
        $improvement_options = array(
            array('value' => 0, 'label' => '0% improvement (current)'),
            array('value' => 15, 'label' => '15% improvement'),
            array('value' => 29, 'label' => '29% improvement'),
            array('value' => 43, 'label' => '43% improvement'),
            array('value' => 57, 'label' => '57% improvement'),
            array('value' => 71, 'label' => '71% improvement'),
            array('value' => 85, 'label' => '85% improvement'),
        );

        if (!empty($atts['improvement_options'])) {
            $custom_options = json_decode($atts['improvement_options'], true);
            if (is_array($custom_options)) {
                $improvement_options = $custom_options;
            }
        }

        // Generate unique ID for this calculator instance
        $unique_id = 'roic_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="roic-calculator-wrapper" id="<?php echo esc_attr($unique_id); ?>"
             data-currency="<?php echo esc_attr($currency); ?>"
             data-currency-position="<?php echo esc_attr($currency_position); ?>"
             data-show-cta="<?php echo $show_cta ? 'true' : 'false'; ?>"
             data-primary-color="<?php echo esc_attr($primary_color); ?>">

            <div class="roic-header">
                <h2 class="roic-title"><?php echo esc_html($title); ?></h2>
                <p class="roic-subtitle"><?php echo esc_html($subtitle); ?></p>
            </div>

            <!-- Currency Selector -->
            <div class="roic-currency-selector">
                <label for="<?php echo esc_attr($unique_id); ?>-currency" class="roic-currency-label">
                    Select Currency
                </label>
                <select id="<?php echo esc_attr($unique_id); ?>-currency" class="roic-currency-select">
                    <option value="USD">🇺🇸 USD - US Dollar ($)</option>
                    <option value="EUR">🇪🇺 EUR - Euro (€)</option>
                    <option value="GBP">🇬🇧 GBP - British Pound (£)</option>
                    <option value="JPY">🇯🇵 JPY - Japanese Yen (¥)</option>
                    <option value="CNY">🇨🇳 CNY - Chinese Yuan (¥)</option>
                    <option value="CHF">🇨🇭 CHF - Swiss Franc (CHF)</option>
                    <option value="CAD">🇨🇦 CAD - Canadian Dollar (C$)</option>
                    <option value="AUD">🇦🇺 AUD - Australian Dollar (A$)</option>
                    <option value="NZD">🇳🇿 NZD - New Zealand Dollar (NZ$)</option>
                    <option value="INR">🇮🇳 INR - Indian Rupee (₹)</option>
                    <option value="SGD">🇸🇬 SGD - Singapore Dollar (S$)</option>
                    <option value="HKD">🇭🇰 HKD - Hong Kong Dollar (HK$)</option>
                    <option value="KRW">🇰🇷 KRW - South Korean Won (₩)</option>
                    <option value="BRL">🇧🇷 BRL - Brazilian Real (R$)</option>
                    <option value="MXN">🇲🇽 MXN - Mexican Peso ($)</option>
                    <option value="ZAR">🇿🇦 ZAR - South African Rand (R)</option>
                    <option value="SEK">🇸🇪 SEK - Swedish Krona (kr)</option>
                    <option value="NOK">🇳🇴 NOK - Norwegian Krone (kr)</option>
                    <option value="DKK">🇩🇰 DKK - Danish Krone (kr)</option>
                    <option value="PLN">🇵🇱 PLN - Polish Zloty (zł)</option>
                    <option value="THB">🇹🇭 THB - Thai Baht (฿)</option>
                    <option value="IDR">🇮🇩 IDR - Indonesian Rupiah (Rp)</option>
                    <option value="MYR">🇲🇾 MYR - Malaysian Ringgit (RM)</option>
                    <option value="PHP">🇵🇭 PHP - Philippine Peso (₱)</option>
                    <option value="AED">🇦🇪 AED - UAE Dirham (د.إ)</option>
                    <option value="SAR">🇸🇦 SAR - Saudi Riyal (﷼)</option>
                    <option value="TRY">🇹🇷 TRY - Turkish Lira (₺)</option>
                    <option value="RUB">🇷🇺 RUB - Russian Ruble (₽)</option>
                    <option value="CZK">🇨🇿 CZK - Czech Koruna (Kč)</option>
                    <option value="ILS">🇮🇱 ILS - Israeli Shekel (₪)</option>
                </select>
            </div>

            <div class="roic-form">
                <!-- Monthly Sales -->
                <div class="roic-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-monthly-sales">
                        Monthly Sales
                    </label>
                    <div class="roic-input-wrapper">
                        <span class="roic-currency-prefix" style="display:none;"></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-monthly-sales"
                            class="roic-monthly-sales"
                            placeholder="e.g., 50000"
                            required
                            aria-required="true"
                        >
                        <span class="roic-currency-suffix" style="display:none;"></span>
                    </div>
                    <span class="roic-error" role="alert"></span>
                </div>

                <!-- Conversion Rate -->
                <div class="roic-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-conversion-rate">
                        Conversion rate in %
                    </label>
                    <div class="roic-input-wrapper">
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-conversion-rate"
                            class="roic-conversion-rate"
                            placeholder="e.g., 2.5"
                            required
                            aria-required="true"
                        >
                        <span class="roic-percent-suffix">%</span>
                    </div>
                    <span class="roic-error" role="alert"></span>
                </div>

                <!-- Monthly Spend -->
                <div class="roic-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-monthly-spend">
                        Monthly Spend/Investment
                    </label>
                    <div class="roic-input-wrapper">
                        <span class="roic-currency-prefix" style="display:none;"></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-monthly-spend"
                            class="roic-monthly-spend"
                            placeholder="e.g., 5000"
                            required
                            aria-required="true"
                        >
                        <span class="roic-currency-suffix" style="display:none;"></span>
                    </div>
                    <span class="roic-error" role="alert"></span>
                </div>

                <!-- Improvement Percentage -->
                <div class="roic-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-improvement">
                        Estimated conversion rate increase:
                    </label>
                    <select
                        id="<?php echo esc_attr($unique_id); ?>-improvement"
                        class="roic-improvement"
                        aria-label="Select estimated conversion rate improvement"
                    >
                        <?php foreach ($improvement_options as $option) : ?>
                            <option value="<?php echo esc_attr($option['value']); ?>"
                                <?php selected($option['value'], 15); ?>>
                                <?php echo esc_html($option['label']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <p class="roic-helper-text">Typical improvements range from 15% to 85% based on optimization efforts.</p>
                </div>

                <!-- Calculate Button -->
                <button
                    type="button"
                    class="roic-calculate-btn"
                    aria-label="Calculate ROI"
                >
                    Calculate ROI
                </button>
            </div>

            <!-- Results Section -->
            <div class="roic-results" style="display:none;" role="region" aria-live="polite">
                <div class="roic-results-grid">
                    <!-- New Conversion Rate Card -->
                    <div class="roic-result-card">
                        <div class="roic-card-icon">📈</div>
                        <div class="roic-card-label">New conversion rate</div>
                        <div class="roic-card-value roic-new-conversion-rate">0%</div>
                        <div class="roic-card-change positive roic-conversion-rate-change">+0%</div>
                    </div>

                    <!-- New Monthly Sales Card -->
                    <div class="roic-result-card">
                        <div class="roic-card-icon">💰</div>
                        <div class="roic-card-label">New monthly sales</div>
                        <div class="roic-card-value roic-new-monthly-sales"><?php echo esc_html($currency); ?>0</div>
                        <div class="roic-card-change positive roic-monthly-sales-change">+<?php echo esc_html($currency); ?>0</div>
                    </div>

                    <!-- ROI Card -->
                    <div class="roic-result-card roic-roi-card">
                        <div class="roic-card-icon">🎯</div>
                        <div class="roic-card-label">Estimated ROI</div>
                        <div class="roic-card-value roic-roi-value">0%</div>
                    </div>
                </div>

                <?php if ($show_cta) : ?>
                <!-- CTA Section -->
                <div class="roic-cta" style="display:none;">
                    <a href="<?php echo esc_url($cta_url); ?>" class="roic-cta-button">
                        <?php echo esc_html($cta_text); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render ROAS Calculator shortcode
     * Return on Ad Spend Calculator for Shopify
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_roas_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'ROAS Calculator',
            'subtitle' => 'Calculate your Return on Ad Spend and measure campaign profitability',
            'cta_button' => 'false',
            'cta_text' => 'Get Started',
            'cta_url' => '#',
            'primary_color' => '#3B82F6',
        ), $atts, 'roas_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $cta_button = filter_var($atts['cta_button'], FILTER_VALIDATE_BOOLEAN);
        $cta_text = sanitize_text_field($atts['cta_text']);
        $cta_url = esc_url($atts['cta_url']);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        if (!$primary_color) {
            $primary_color = '#3B82F6';
        }

        // Generate unique ID for this calculator instance
        $unique_id = 'roas_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="roas-calculator-wrapper" id="<?php echo esc_attr($unique_id); ?>"
             data-show-cta="<?php echo $cta_button ? 'true' : 'false'; ?>"
             style="--primary-color: <?php echo esc_attr($primary_color); ?>">

            <!-- Header -->
            <div class="roas-calculator-header">
                <h2 class="roas-calculator-title"><?php echo esc_html($title); ?></h2>
                <p class="roas-calculator-subtitle"><?php echo esc_html($subtitle); ?></p>
            </div>

            <!-- Currency Selector -->
            <div class="roas-currency-selector">
                <label for="<?php echo esc_attr($unique_id); ?>-currency" class="roas-currency-label">
                    Select Currency
                </label>
                <select id="<?php echo esc_attr($unique_id); ?>-currency" class="roas-currency-select">
                    <option value="USD">🇺🇸 USD - US Dollar ($)</option>
                    <option value="EUR">🇪🇺 EUR - Euro (€)</option>
                    <option value="GBP">🇬🇧 GBP - British Pound (£)</option>
                    <option value="JPY">🇯🇵 JPY - Japanese Yen (¥)</option>
                    <option value="CNY">🇨🇳 CNY - Chinese Yuan (¥)</option>
                    <option value="CHF">🇨🇭 CHF - Swiss Franc (CHF)</option>
                    <option value="CAD">🇨🇦 CAD - Canadian Dollar (C$)</option>
                    <option value="AUD">🇦🇺 AUD - Australian Dollar (A$)</option>
                    <option value="NZD">🇳🇿 NZD - New Zealand Dollar (NZ$)</option>
                    <option value="INR">🇮🇳 INR - Indian Rupee (₹)</option>
                    <option value="SGD">🇸🇬 SGD - Singapore Dollar (S$)</option>
                    <option value="HKD">🇭🇰 HKD - Hong Kong Dollar (HK$)</option>
                    <option value="KRW">🇰🇷 KRW - South Korean Won (₩)</option>
                    <option value="BRL">🇧🇷 BRL - Brazilian Real (R$)</option>
                    <option value="MXN">🇲🇽 MXN - Mexican Peso ($)</option>
                    <option value="ZAR">🇿🇦 ZAR - South African Rand (R)</option>
                    <option value="SEK">🇸🇪 SEK - Swedish Krona (kr)</option>
                    <option value="NOK">🇳🇴 NOK - Norwegian Krone (kr)</option>
                    <option value="DKK">🇩🇰 DKK - Danish Krone (kr)</option>
                    <option value="PLN">🇵🇱 PLN - Polish Zloty (zł)</option>
                    <option value="THB">🇹🇭 THB - Thai Baht (฿)</option>
                    <option value="IDR">🇮🇩 IDR - Indonesian Rupiah (Rp)</option>
                    <option value="MYR">🇲🇾 MYR - Malaysian Ringgit (RM)</option>
                    <option value="PHP">🇵🇭 PHP - Philippine Peso (₱)</option>
                    <option value="AED">🇦🇪 AED - UAE Dirham (د.إ)</option>
                    <option value="SAR">🇸🇦 SAR - Saudi Riyal (﷼)</option>
                    <option value="TRY">🇹🇷 TRY - Turkish Lira (₺)</option>
                    <option value="RUB">🇷🇺 RUB - Russian Ruble (₽)</option>
                    <option value="CZK">🇨🇿 CZK - Czech Koruna (Kč)</option>
                    <option value="ILS">🇮🇱 ILS - Israeli Shekel (₪)</option>
                </select>
            </div>

            <!-- Calculator Form -->
            <form class="roas-calculator-form">
                <div class="roas-form-grid">
                    <!-- Advertising Cost -->
                    <div class="roas-field">
                        <label for="<?php echo esc_attr($unique_id); ?>-ad-cost" class="roas-label">
                            Advertising Cost
                        </label>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-ad-cost"
                            class="roas-input roas-ad-cost"
                            placeholder="e.g., 5000.00"
                            required
                            aria-required="true"
                            aria-describedby="<?php echo esc_attr($unique_id); ?>-ad-cost-error"
                        >
                        <span id="<?php echo esc_attr($unique_id); ?>-ad-cost-error" class="roas-error" role="alert"></span>
                    </div>

                    <!-- Revenue Generated -->
                    <div class="roas-field">
                        <label for="<?php echo esc_attr($unique_id); ?>-revenue" class="roas-label">
                            Revenue Generated
                        </label>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-revenue"
                            class="roas-input roas-revenue"
                            placeholder="e.g., 20000.00"
                            required
                            aria-required="true"
                            aria-describedby="<?php echo esc_attr($unique_id); ?>-revenue-error"
                        >
                        <span id="<?php echo esc_attr($unique_id); ?>-revenue-error" class="roas-error" role="alert"></span>
                    </div>

                    <!-- Additional Expenses -->
                    <div class="roas-field">
                        <label for="<?php echo esc_attr($unique_id); ?>-expenses" class="roas-label">
                            Additional Expenses (Optional)
                        </label>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-expenses"
                            class="roas-input roas-expenses"
                            placeholder="e.g., 1000.00"
                            aria-describedby="<?php echo esc_attr($unique_id); ?>-expenses-error"
                        >
                        <span id="<?php echo esc_attr($unique_id); ?>-expenses-error" class="roas-error" role="alert"></span>
                    </div>
                </div>

                <!-- Calculate Button -->
                <button
                    type="button"
                    class="roas-calculate-btn"
                    aria-label="Calculate ROAS"
                >
                    Calculate ROAS
                </button>
            </form>

            <!-- Results Section -->
            <div class="roas-results" style="display:none;" role="region" aria-live="polite">

                <!-- Main ROAS Card with Gauge -->
                <div class="roas-main-card">
                    <div class="roas-main-label">Return on Ad Spend</div>

                    <!-- ROAS Gauge -->
                    <div class="roas-gauge-container">
                        <div class="roas-gauge">
                            <div class="roas-gauge-background"></div>
                            <div class="roas-gauge-fill"></div>
                            <div class="roas-gauge-needle"></div>
                            <div class="roas-gauge-center"></div>
                        </div>
                    </div>

                    <div class="roas-main-value">0.00</div>
                    <div class="roas-performance-badge roas-performance-poor">Poor</div>
                </div>

                <!-- Secondary Metrics -->
                <div class="roas-secondary-metrics">
                    <!-- Net Revenue -->
                    <div class="roas-metric-card">
                        <div class="roas-metric-label">Net Revenue</div>
                        <div class="roas-metric-value roas-net-revenue">$0.00</div>
                    </div>

                    <!-- Cost Per Dollar Revenue -->
                    <div class="roas-metric-card">
                        <div class="roas-metric-label">Cost Per $ Revenue</div>
                        <div class="roas-metric-value roas-cost-per-dollar">$0.00</div>
                    </div>

                    <!-- Profit Margin -->
                    <div class="roas-metric-card">
                        <div class="roas-metric-label">Profit Margin</div>
                        <div class="roas-metric-value roas-profit-margin">0.00%</div>
                    </div>
                </div>

                <!-- Breakdown Table -->
                <div class="roas-breakdown">
                    <h3 class="roas-breakdown-title">Calculation Breakdown</h3>
                    <table class="roas-breakdown-table">
                        <thead>
                            <tr>
                                <th>Metric</th>
                                <th>Value</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                    <button type="button" class="roas-copy-btn" aria-label="Copy results to clipboard">
                        📋 Copy Results
                    </button>
                    <button type="button" class="roas-reset-btn" aria-label="Reset calculator">
                        🔄 Reset
                    </button>
                </div>
            </div>

            <!-- CTA Section -->
            <?php if ($cta_button) : ?>
            <div class="roas-cta" style="display:none;">
                <h3 class="roas-cta-title">Ready to Improve Your ROAS?</h3>
                <p class="roas-cta-description">Get expert help optimizing your ad campaigns for better returns.</p>
                <a href="<?php echo esc_url($cta_url); ?>" class="roas-cta-btn">
                    <?php echo esc_html($cta_text); ?>
                </a>
            </div>
            <?php endif; ?>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render CAC Calculator shortcode
     * Customer Acquisition Cost Calculator
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_cac_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'Customer Acquisition Cost Calculator',
            'subtitle' => 'Calculate your CAC and measure acquisition efficiency',
            'show_aov_field' => 'true',
            'show_clv_field' => 'true',
            'show_benchmarks' => 'true',
            'show_tips' => 'true',
            'primary_color' => '#8B5CF6',
        ), $atts, 'cac_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $show_aov_field = filter_var($atts['show_aov_field'], FILTER_VALIDATE_BOOLEAN);
        $show_clv_field = filter_var($atts['show_clv_field'], FILTER_VALIDATE_BOOLEAN);
        $show_benchmarks = filter_var($atts['show_benchmarks'], FILTER_VALIDATE_BOOLEAN);
        $show_tips = filter_var($atts['show_tips'], FILTER_VALIDATE_BOOLEAN);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        if (!$primary_color) {
            $primary_color = '#8B5CF6';
        }

        // Generate unique ID for this calculator instance
        $unique_id = 'cac_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="cac-calculator-wrapper" id="<?php echo esc_attr($unique_id); ?>"
             data-show-aov="<?php echo $show_aov_field ? 'true' : 'false'; ?>"
             data-show-clv="<?php echo $show_clv_field ? 'true' : 'false'; ?>"
             data-show-benchmarks="<?php echo $show_benchmarks ? 'true' : 'false'; ?>"
             data-show-tips="<?php echo $show_tips ? 'true' : 'false'; ?>"
             style="--primary-color: <?php echo esc_attr($primary_color); ?>">

            <!-- Header -->
            <div class="cac-header">
                <h2 class="cac-title"><?php echo esc_html($title); ?></h2>
                <p class="cac-subtitle"><?php echo esc_html($subtitle); ?></p>
            </div>

            <!-- Currency Selector -->
            <div class="cac-currency-selector">
                <label for="<?php echo esc_attr($unique_id); ?>-currency" class="cac-currency-label">
                    Select Currency
                </label>
                <select id="<?php echo esc_attr($unique_id); ?>-currency" class="cac-currency-select">
                    <option value="USD">🇺🇸 USD - US Dollar ($)</option>
                    <option value="EUR">🇪🇺 EUR - Euro (€)</option>
                    <option value="GBP">🇬🇧 GBP - British Pound (£)</option>
                    <option value="JPY">🇯🇵 JPY - Japanese Yen (¥)</option>
                    <option value="CNY">🇨🇳 CNY - Chinese Yuan (¥)</option>
                    <option value="CHF">🇨🇭 CHF - Swiss Franc (CHF)</option>
                    <option value="CAD">🇨🇦 CAD - Canadian Dollar (C$)</option>
                    <option value="AUD">🇦🇺 AUD - Australian Dollar (A$)</option>
                    <option value="NZD">🇳🇿 NZD - New Zealand Dollar (NZ$)</option>
                    <option value="INR">🇮🇳 INR - Indian Rupee (₹)</option>
                    <option value="SGD">🇸🇬 SGD - Singapore Dollar (S$)</option>
                    <option value="HKD">🇭🇰 HKD - Hong Kong Dollar (HK$)</option>
                    <option value="KRW">🇰🇷 KRW - South Korean Won (₩)</option>
                    <option value="BRL">🇧🇷 BRL - Brazilian Real (R$)</option>
                    <option value="MXN">🇲🇽 MXN - Mexican Peso ($)</option>
                    <option value="ZAR">🇿🇦 ZAR - South African Rand (R)</option>
                    <option value="SEK">🇸🇪 SEK - Swedish Krona (kr)</option>
                    <option value="NOK">🇳🇴 NOK - Norwegian Krone (kr)</option>
                    <option value="DKK">🇩🇰 DKK - Danish Krone (kr)</option>
                    <option value="PLN">🇵🇱 PLN - Polish Zloty (zł)</option>
                    <option value="THB">🇹🇭 THB - Thai Baht (฿)</option>
                    <option value="IDR">🇮🇩 IDR - Indonesian Rupiah (Rp)</option>
                    <option value="MYR">🇲🇾 MYR - Malaysian Ringgit (RM)</option>
                    <option value="PHP">🇵🇭 PHP - Philippine Peso (₱)</option>
                    <option value="AED">🇦🇪 AED - UAE Dirham (د.إ)</option>
                    <option value="SAR">🇸🇦 SAR - Saudi Riyal (﷼)</option>
                    <option value="TRY">🇹🇷 TRY - Turkish Lira (₺)</option>
                    <option value="RUB">🇷🇺 RUB - Russian Ruble (₽)</option>
                    <option value="CZK">🇨🇿 CZK - Czech Koruna (Kč)</option>
                    <option value="ILS">🇮🇱 ILS - Israeli Shekel (₪)</option>
                </select>
            </div>

            <!-- Calculator Form -->
            <form class="cac-form">
                <div class="cac-form-grid">
                    <!-- Marketing Expenses -->
                    <div class="cac-field">
                        <label for="<?php echo esc_attr($unique_id); ?>-expenses" class="cac-label">
                            Total Marketing Expenses
                        </label>
                        <div class="cac-input-wrapper">
                            <span class="cac-currency-prefix" style="display:none;"></span>
                            <input
                                type="text"
                                inputmode="decimal"
                                id="<?php echo esc_attr($unique_id); ?>-expenses"
                                class="cac-input cac-expenses"
                                placeholder="e.g., 10000"
                                required
                                aria-required="true"
                                aria-describedby="<?php echo esc_attr($unique_id); ?>-expenses-help <?php echo esc_attr($unique_id); ?>-expenses-error"
                            >
                            <span class="cac-currency-suffix" style="display:none;"></span>
                        </div>
                        <p id="<?php echo esc_attr($unique_id); ?>-expenses-help" class="cac-helper">Include all marketing and advertising costs</p>
                        <span id="<?php echo esc_attr($unique_id); ?>-expenses-error" class="cac-error" role="alert"></span>
                    </div>

                    <!-- Number of Customers -->
                    <div class="cac-field">
                        <label for="<?php echo esc_attr($unique_id); ?>-customers" class="cac-label">
                            Number of New Customers Acquired
                        </label>
                        <div class="cac-input-wrapper">
                            <span class="cac-input-icon">👥</span>
                            <input
                                type="text"
                                inputmode="numeric"
                                id="<?php echo esc_attr($unique_id); ?>-customers"
                                class="cac-input cac-customers"
                                placeholder="e.g., 250"
                                required
                                aria-required="true"
                                aria-describedby="<?php echo esc_attr($unique_id); ?>-customers-error"
                            >
                        </div>
                        <span id="<?php echo esc_attr($unique_id); ?>-customers-error" class="cac-error" role="alert"></span>
                    </div>

                    <!-- Average Order Value (Optional) -->
                    <?php if ($show_aov_field) : ?>
                    <div class="cac-field cac-optional">
                        <label for="<?php echo esc_attr($unique_id); ?>-aov" class="cac-label">
                            Average Order Value <span class="cac-optional-badge">(Optional)</span>
                        </label>
                        <div class="cac-input-wrapper">
                            <span class="cac-currency-prefix" style="display:none;"></span>
                            <input
                                type="text"
                                inputmode="decimal"
                                id="<?php echo esc_attr($unique_id); ?>-aov"
                                class="cac-input cac-aov"
                                placeholder="e.g., 75"
                                aria-describedby="<?php echo esc_attr($unique_id); ?>-aov-help"
                            >
                            <span class="cac-currency-suffix" style="display:none;"></span>
                        </div>
                        <p id="<?php echo esc_attr($unique_id); ?>-aov-help" class="cac-helper">Enter to see CAC as % of AOV</p>
                    </div>
                    <?php endif; ?>

                    <!-- Customer Lifetime Value (Optional) -->
                    <?php if ($show_clv_field) : ?>
                    <div class="cac-field cac-optional">
                        <label for="<?php echo esc_attr($unique_id); ?>-clv" class="cac-label">
                            Customer Lifetime Value <span class="cac-optional-badge">(Optional)</span>
                        </label>
                        <div class="cac-input-wrapper">
                            <span class="cac-currency-prefix" style="display:none;"></span>
                            <input
                                type="text"
                                inputmode="decimal"
                                id="<?php echo esc_attr($unique_id); ?>-clv"
                                class="cac-input cac-clv"
                                placeholder="e.g., 300"
                                aria-describedby="<?php echo esc_attr($unique_id); ?>-clv-help"
                            >
                            <span class="cac-currency-suffix" style="display:none;"></span>
                        </div>
                        <p id="<?php echo esc_attr($unique_id); ?>-clv-help" class="cac-helper">Enter to see CAC:LTV ratio</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Calculate Button -->
                <button
                    type="button"
                    class="cac-calculate-btn"
                    aria-label="Calculate Customer Acquisition Cost"
                >
                    Calculate CAC
                </button>
            </form>

            <!-- Results Section -->
            <div class="cac-results" style="display:none;" role="region" aria-live="polite">

                <!-- Main CAC Result -->
                <div class="cac-main-result">
                    <div class="cac-result-icon">💰</div>
                    <div class="cac-result-value">$0.00</div>
                    <div class="cac-result-label">Customer Acquisition Cost</div>
                    <div class="cac-result-subtext">Cost to acquire each new customer</div>
                    <div class="cac-performance-badge">
                        <span class="cac-badge cac-badge-average">Average</span>
                    </div>
                </div>

                <!-- Secondary Metrics Grid -->
                <div class="cac-metrics-grid">
                    <!-- CAC % of AOV -->
                    <div class="cac-metric-card" id="cac-aov-metric" style="display:none;">
                        <div class="cac-metric-header">
                            <span class="cac-metric-icon">📊</span>
                            <span class="cac-metric-title">CAC as % of AOV</span>
                        </div>
                        <div class="cac-metric-value">0%</div>
                        <div class="cac-metric-bar">
                            <div class="cac-metric-bar-fill"></div>
                        </div>
                        <div class="cac-metric-status">-</div>
                    </div>

                    <!-- CAC:LTV Ratio -->
                    <div class="cac-metric-card" id="cac-ltv-metric" style="display:none;">
                        <div class="cac-metric-header">
                            <span class="cac-metric-icon">⚖️</span>
                            <span class="cac-metric-title">CAC:LTV Ratio</span>
                        </div>
                        <div class="cac-metric-value">1:0.0</div>
                        <div class="cac-metric-bar">
                            <div class="cac-metric-bar-fill"></div>
                        </div>
                        <div class="cac-metric-status">-</div>
                    </div>

                    <!-- Orders to Payback -->
                    <div class="cac-metric-card" id="cac-payback-metric" style="display:none;">
                        <div class="cac-metric-header">
                            <span class="cac-metric-icon">🔄</span>
                            <span class="cac-metric-title">Orders to Recover CAC</span>
                        </div>
                        <div class="cac-metric-value">0.0 orders</div>
                        <div class="cac-metric-description">Number of purchases needed to recover acquisition cost</div>
                    </div>
                </div>

                <!-- Summary Breakdown -->
                <div class="cac-breakdown">
                    <h4 class="cac-breakdown-title">Summary</h4>
                    <div class="cac-breakdown-row">
                        <span>Total Marketing Spend</span>
                        <span class="cac-breakdown-value cac-summary-spend">$0.00</span>
                    </div>
                    <div class="cac-breakdown-row">
                        <span>New Customers Acquired</span>
                        <span class="cac-breakdown-value cac-summary-customers">0</span>
                    </div>
                    <div class="cac-breakdown-row cac-breakdown-result">
                        <span><strong>Cost Per Customer</strong></span>
                        <span class="cac-breakdown-value cac-summary-cac">$0.00</span>
                    </div>
                </div>

                <!-- Tips Section -->
                <?php if ($show_tips) : ?>
                <div class="cac-tips">
                    <h4 class="cac-tips-title">💡 Tips to Reduce CAC</h4>
                    <ul class="cac-tips-list">
                        <li>Improve conversion rates to get more customers from same spend</li>
                        <li>Focus on high-performing channels and reduce wasteful spend</li>
                        <li>Leverage referral programs for lower-cost acquisition</li>
                        <li>Invest in SEO and content for organic customer growth</li>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="cac-actions">
                    <button type="button" class="cac-reset-btn" aria-label="Reset calculator">
                        🔄 Reset
                    </button>
                    <button type="button" class="cac-copy-btn" aria-label="Copy results to clipboard">
                        📋 Copy Results
                    </button>
                </div>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render CLV Calculator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_clv_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'Customer Lifetime Value Calculator',
            'subtitle' => 'Calculate your CLV effortlessly.',
            'default_currency' => 'USD',
            'show_profit_margin' => 'true',
            'show_cac_field' => 'true',
            'show_annual_value' => 'true',
            'show_tips' => 'true',
            'default_lifespan' => '',
            'default_frequency' => '',
            'primary_color' => '#059669',
        ), $atts, 'clv_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $default_currency = sanitize_text_field($atts['default_currency']);
        $show_profit_margin = filter_var($atts['show_profit_margin'], FILTER_VALIDATE_BOOLEAN);
        $show_cac_field = filter_var($atts['show_cac_field'], FILTER_VALIDATE_BOOLEAN);
        $show_annual_value = filter_var($atts['show_annual_value'], FILTER_VALIDATE_BOOLEAN);
        $show_tips = filter_var($atts['show_tips'], FILTER_VALIDATE_BOOLEAN);
        $default_lifespan = sanitize_text_field($atts['default_lifespan']);
        $default_frequency = sanitize_text_field($atts['default_frequency']);
        $primary_color = sanitize_hex_color($atts['primary_color']);

        // Start output buffering
        ob_start();
        ?>

        <div class="clv-calculator-wrapper"
             data-default-currency="<?php echo esc_attr($default_currency); ?>"
             data-show-profit-margin="<?php echo $show_profit_margin ? 'true' : 'false'; ?>"
             data-show-cac-field="<?php echo $show_cac_field ? 'true' : 'false'; ?>"
             data-show-annual-value="<?php echo $show_annual_value ? 'true' : 'false'; ?>"
             data-show-tips="<?php echo $show_tips ? 'true' : 'false'; ?>"
             data-primary-color="<?php echo esc_attr($primary_color); ?>">

            <!-- Header -->
            <div class="clv-header">
                <h2 class="clv-title"><?php echo esc_html($title); ?></h2>
                <p class="clv-subtitle"><?php echo esc_html($subtitle); ?></p>
            </div>

            <!-- Currency Selector -->
            <div class="clv-currency-selector">
                <label for="clv-currency" class="clv-currency-label">Currency:</label>
                <select id="clv-currency" class="clv-currency-select" aria-label="Select currency">
                    <option value="USD" data-symbol="$" data-position="before" <?php selected($default_currency, 'USD'); ?>>USD ($)</option>
                    <option value="EUR" data-symbol="€" data-position="after" <?php selected($default_currency, 'EUR'); ?>>EUR (€)</option>
                    <option value="GBP" data-symbol="£" data-position="before" <?php selected($default_currency, 'GBP'); ?>>GBP (£)</option>
                    <option value="JPY" data-symbol="¥" data-position="before" <?php selected($default_currency, 'JPY'); ?>>JPY (¥)</option>
                    <option value="CNY" data-symbol="¥" data-position="before" <?php selected($default_currency, 'CNY'); ?>>CNY (¥)</option>
                    <option value="CHF" data-symbol="CHF" data-position="before" <?php selected($default_currency, 'CHF'); ?>>CHF</option>
                    <option value="CAD" data-symbol="C$" data-position="before" <?php selected($default_currency, 'CAD'); ?>>CAD (C$)</option>
                    <option value="AUD" data-symbol="A$" data-position="before" <?php selected($default_currency, 'AUD'); ?>>AUD (A$)</option>
                    <option value="NZD" data-symbol="NZ$" data-position="before" <?php selected($default_currency, 'NZD'); ?>>NZD (NZ$)</option>
                    <option value="INR" data-symbol="₹" data-position="before" <?php selected($default_currency, 'INR'); ?>>INR (₹)</option>
                    <option value="SGD" data-symbol="S$" data-position="before" <?php selected($default_currency, 'SGD'); ?>>SGD (S$)</option>
                    <option value="HKD" data-symbol="HK$" data-position="before" <?php selected($default_currency, 'HKD'); ?>>HKD (HK$)</option>
                    <option value="KRW" data-symbol="₩" data-position="before" <?php selected($default_currency, 'KRW'); ?>>KRW (₩)</option>
                    <option value="BRL" data-symbol="R$" data-position="before" <?php selected($default_currency, 'BRL'); ?>>BRL (R$)</option>
                    <option value="MXN" data-symbol="$" data-position="before" <?php selected($default_currency, 'MXN'); ?>>MXN ($)</option>
                    <option value="ZAR" data-symbol="R" data-position="before" <?php selected($default_currency, 'ZAR'); ?>>ZAR (R)</option>
                    <option value="SEK" data-symbol="kr" data-position="after" <?php selected($default_currency, 'SEK'); ?>>SEK (kr)</option>
                    <option value="NOK" data-symbol="kr" data-position="after" <?php selected($default_currency, 'NOK'); ?>>NOK (kr)</option>
                    <option value="DKK" data-symbol="kr" data-position="after" <?php selected($default_currency, 'DKK'); ?>>DKK (kr)</option>
                    <option value="PLN" data-symbol="zł" data-position="after" <?php selected($default_currency, 'PLN'); ?>>PLN (zł)</option>
                    <option value="THB" data-symbol="฿" data-position="before" <?php selected($default_currency, 'THB'); ?>>THB (฿)</option>
                    <option value="IDR" data-symbol="Rp" data-position="before" <?php selected($default_currency, 'IDR'); ?>>IDR (Rp)</option>
                    <option value="MYR" data-symbol="RM" data-position="before" <?php selected($default_currency, 'MYR'); ?>>MYR (RM)</option>
                    <option value="PHP" data-symbol="₱" data-position="before" <?php selected($default_currency, 'PHP'); ?>>PHP (₱)</option>
                    <option value="AED" data-symbol="د.إ" data-position="before" <?php selected($default_currency, 'AED'); ?>>AED (د.إ)</option>
                    <option value="SAR" data-symbol="﷼" data-position="before" <?php selected($default_currency, 'SAR'); ?>>SAR (﷼)</option>
                    <option value="TRY" data-symbol="₺" data-position="before" <?php selected($default_currency, 'TRY'); ?>>TRY (₺)</option>
                    <option value="RUB" data-symbol="₽" data-position="before" <?php selected($default_currency, 'RUB'); ?>>RUB (₽)</option>
                    <option value="CZK" data-symbol="Kč" data-position="after" <?php selected($default_currency, 'CZK'); ?>>CZK (Kč)</option>
                    <option value="ILS" data-symbol="₪" data-position="before" <?php selected($default_currency, 'ILS'); ?>>ILS (₪)</option>
                </select>
            </div>

            <!-- Form -->
            <div class="clv-form">

                <!-- Average Purchase Value -->
                <div class="clv-field">
                    <label for="clv-purchase-value">Average Purchase Value:</label>
                    <div class="clv-input-wrapper">
                        <span class="clv-currency-prefix" style="display:none;"></span>
                        <input type="number"
                               id="clv-purchase-value"
                               class="clv-input"
                               min="0.01"
                               step="0.01"
                               placeholder="e.g., 75"
                               required
                               aria-required="true"
                               aria-describedby="clv-purchase-value-help">
                        <span class="clv-currency-suffix" style="display:none;"></span>
                    </div>
                    <p class="clv-helper-text" id="clv-purchase-value-help">Average amount spent per order</p>
                    <span class="clv-error" role="alert"></span>
                </div>

                <!-- Purchase Frequency -->
                <div class="clv-field">
                    <label for="clv-frequency">Purchase Frequency:</label>
                    <div class="clv-input-wrapper clv-input-with-suffix">
                        <input type="number"
                               id="clv-frequency"
                               class="clv-input"
                               min="0.1"
                               step="0.1"
                               placeholder="e.g., 4"
                               value="<?php echo esc_attr($default_frequency); ?>"
                               required
                               aria-required="true"
                               aria-describedby="clv-frequency-help">
                        <span class="clv-input-suffix">purchases/year</span>
                    </div>
                    <p class="clv-helper-text" id="clv-frequency-help">Average number of purchases per year</p>
                    <span class="clv-error" role="alert"></span>
                </div>

                <!-- Customer Lifespan -->
                <div class="clv-field">
                    <label for="clv-lifespan">Customer Lifespan:</label>
                    <div class="clv-input-wrapper clv-input-with-suffix">
                        <input type="number"
                               id="clv-lifespan"
                               class="clv-input"
                               min="0.1"
                               step="0.1"
                               placeholder="e.g., 3"
                               value="<?php echo esc_attr($default_lifespan); ?>"
                               required
                               aria-required="true"
                               aria-describedby="clv-lifespan-help">
                        <span class="clv-input-suffix">years</span>
                    </div>
                    <p class="clv-helper-text" id="clv-lifespan-help">Average years a customer stays active</p>
                    <span class="clv-error" role="alert"></span>
                </div>

                <!-- Optional: Profit Margin -->
                <?php if ($show_profit_margin) : ?>
                <div class="clv-field clv-optional">
                    <label for="clv-margin">Profit Margin (optional):</label>
                    <div class="clv-input-wrapper clv-input-with-suffix">
                        <input type="number"
                               id="clv-margin"
                               class="clv-input"
                               min="0"
                               max="100"
                               step="0.1"
                               placeholder="e.g., 30"
                               aria-describedby="clv-margin-help">
                        <span class="clv-input-suffix">%</span>
                    </div>
                    <p class="clv-helper-text" id="clv-margin-help">Enter to calculate profit-based CLV</p>
                </div>
                <?php endif; ?>

                <!-- Optional: CAC -->
                <?php if ($show_cac_field) : ?>
                <div class="clv-field clv-optional">
                    <label for="clv-cac">Customer Acquisition Cost (optional):</label>
                    <div class="clv-input-wrapper">
                        <span class="clv-currency-prefix" style="display:none;"></span>
                        <input type="number"
                               id="clv-cac"
                               class="clv-input"
                               min="0"
                               step="0.01"
                               placeholder="e.g., 50"
                               aria-describedby="clv-cac-help">
                        <span class="clv-currency-suffix" style="display:none;"></span>
                    </div>
                    <p class="clv-helper-text" id="clv-cac-help">Enter to see CLV:CAC ratio</p>
                </div>
                <?php endif; ?>

                <button type="button" class="clv-calculate-btn" aria-label="Calculate CLV">
                    Calculate CLV
                </button>
            </div>

            <!-- Results -->
            <div class="clv-results" style="display:none;" role="region" aria-live="polite">

                <!-- Main CLV Result -->
                <div class="clv-main-result">
                    <div class="clv-result-icon">💎</div>
                    <div class="clv-result-value">$0.00</div>
                    <div class="clv-result-label">Customer Lifetime Value</div>
                    <div class="clv-result-subtext">Total revenue expected from each customer</div>
                </div>

                <!-- Profit-Based CLV -->
                <?php if ($show_profit_margin) : ?>
                <div class="clv-profit-result" id="clv-profit-section" style="display:none;">
                    <div class="clv-profit-value">$0.00</div>
                    <div class="clv-profit-label">Profit-Based CLV</div>
                    <div class="clv-profit-subtext">Actual profit per customer over lifetime</div>
                </div>
                <?php endif; ?>

                <!-- CLV:CAC Ratio Health -->
                <?php if ($show_cac_field) : ?>
                <div class="clv-ratio-health" id="clv-ratio-section" style="display:none;">
                    <div class="clv-ratio-display">
                        <span class="clv-ratio-value">0:1</span>
                        <span class="clv-ratio-label">CLV:CAC Ratio</span>
                    </div>
                    <div class="clv-ratio-bar">
                        <div class="clv-ratio-bar-fill"></div>
                        <div class="clv-ratio-markers">
                            <span class="clv-marker">1:1</span>
                            <span class="clv-marker">3:1</span>
                            <span class="clv-marker">5:1+</span>
                        </div>
                    </div>
                    <div class="clv-ratio-status">
                        <span class="clv-status-badge">Good</span>
                        <span class="clv-status-text">Healthy customer economics</span>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Metrics Grid -->
                <div class="clv-metrics-grid">

                    <!-- Annual Customer Value -->
                    <?php if ($show_annual_value) : ?>
                    <div class="clv-metric-card">
                        <div class="clv-metric-icon">📅</div>
                        <div class="clv-metric-value" id="clv-annual-value">$0.00</div>
                        <div class="clv-metric-label">Annual Customer Value</div>
                    </div>
                    <?php endif; ?>

                    <!-- Total Lifetime Orders -->
                    <div class="clv-metric-card">
                        <div class="clv-metric-icon">🛒</div>
                        <div class="clv-metric-value" id="clv-total-orders">0</div>
                        <div class="clv-metric-label">Lifetime Orders</div>
                    </div>

                    <!-- Net Customer Value -->
                    <?php if ($show_cac_field) : ?>
                    <div class="clv-metric-card" id="clv-net-value-card" style="display:none;">
                        <div class="clv-metric-icon">💵</div>
                        <div class="clv-metric-value" id="clv-net-value">$0.00</div>
                        <div class="clv-metric-label">Net Value Per Customer</div>
                    </div>
                    <?php endif; ?>

                    <!-- CAC Payback Period -->
                    <?php if ($show_cac_field) : ?>
                    <div class="clv-metric-card" id="clv-payback-card" style="display:none;">
                        <div class="clv-metric-icon">⏱️</div>
                        <div class="clv-metric-value" id="clv-payback">0 months</div>
                        <div class="clv-metric-label">CAC Payback Period</div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Breakdown Table -->
                <div class="clv-breakdown">
                    <h4 class="clv-breakdown-title">Calculation Breakdown</h4>
                    <table class="clv-breakdown-table">
                        <tr>
                            <td>Average Purchase Value</td>
                            <td id="clv-breakdown-apv">$0.00</td>
                        </tr>
                        <tr>
                            <td>× Purchase Frequency</td>
                            <td id="clv-breakdown-freq">0 /year</td>
                        </tr>
                        <tr>
                            <td>= Annual Customer Value</td>
                            <td id="clv-breakdown-annual">$0.00</td>
                        </tr>
                        <tr>
                            <td>× Customer Lifespan</td>
                            <td id="clv-breakdown-lifespan">0 years</td>
                        </tr>
                        <tr class="clv-breakdown-result">
                            <td><strong>= Customer Lifetime Value</strong></td>
                            <td id="clv-breakdown-total"><strong>$0.00</strong></td>
                        </tr>
                    </table>
                </div>

                <!-- Tips Section -->
                <?php if ($show_tips) : ?>
                <div class="clv-tips" id="clv-tips-section">
                    <h4 class="clv-tips-title">💡 Ways to Increase CLV</h4>
                    <ul class="clv-tips-list">
                        <li><strong>Increase AOV:</strong> Use upsells, cross-sells, and bundles</li>
                        <li><strong>Boost Frequency:</strong> Email marketing, subscriptions, loyalty programs</li>
                        <li><strong>Extend Lifespan:</strong> Exceptional service, community building, personalization</li>
                        <li><strong>Improve Margins:</strong> Optimize costs, negotiate with suppliers</li>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- What-If Simulator -->
                <div class="clv-simulator" id="clv-simulator-section">
                    <h4 class="clv-simulator-title">🔮 What-If Simulator</h4>
                    <p class="clv-simulator-intro">See how improving each metric affects your CLV:</p>
                    <div class="clv-simulator-grid">
                        <div class="clv-sim-item">
                            <span class="clv-sim-label">+10% Purchase Value</span>
                            <span class="clv-sim-result" id="clv-sim-apv">$0</span>
                        </div>
                        <div class="clv-sim-item">
                            <span class="clv-sim-label">+1 Purchase/Year</span>
                            <span class="clv-sim-result" id="clv-sim-freq">$0</span>
                        </div>
                        <div class="clv-sim-item">
                            <span class="clv-sim-label">+1 Year Lifespan</span>
                            <span class="clv-sim-result" id="clv-sim-life">$0</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="clv-actions">
                    <button type="button" class="clv-reset-btn" aria-label="Reset calculator">
                        🔄 Reset Calculator
                    </button>
                    <button type="button" class="clv-copy-btn" aria-label="Copy results to clipboard">
                        📋 Copy Results
                    </button>
                </div>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render SKU Generator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_sku_generator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'SKU Generator',
            'subtitle' => 'Generate unique SKUs for your products instantly.',
            'max_skus' => '1000',
            'default_length' => '8',
            'default_type' => 'random_numbers',
            'show_export' => 'true',
            'show_preview' => 'true',
            'default_prefix' => '',
            'default_suffix' => '',
            'primary_color' => '#2563EB',
        ), $atts, 'sku_generator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $max_skus = intval($atts['max_skus']);
        $default_length = intval($atts['default_length']);
        $default_type = sanitize_text_field($atts['default_type']);
        $show_export = filter_var($atts['show_export'], FILTER_VALIDATE_BOOLEAN);
        $show_preview = filter_var($atts['show_preview'], FILTER_VALIDATE_BOOLEAN);
        $default_prefix = sanitize_text_field($atts['default_prefix']);
        $default_suffix = sanitize_text_field($atts['default_suffix']);
        $primary_color = sanitize_hex_color($atts['primary_color']);

        // Ensure valid ranges
        if ($max_skus < 1) $max_skus = 1000;
        if ($max_skus > 10000) $max_skus = 10000;
        if ($default_length < 1) $default_length = 1;
        if ($default_length > 36) $default_length = 36;

        // Start output buffering
        ob_start();
        ?>

        <div class="skugen-wrapper"
             data-max-skus="<?php echo esc_attr($max_skus); ?>"
             data-show-export="<?php echo $show_export ? 'true' : 'false'; ?>"
             data-show-preview="<?php echo $show_preview ? 'true' : 'false'; ?>"
             data-primary-color="<?php echo esc_attr($primary_color); ?>">

            <!-- Header -->
            <div class="skugen-header">
                <h2 class="skugen-title"><?php echo esc_html($title); ?></h2>
                <p class="skugen-subtitle"><?php echo esc_html($subtitle); ?></p>
            </div>

            <!-- Form -->
            <div class="skugen-form">

                <!-- Prefix -->
                <div class="skugen-field">
                    <label for="skugen-prefix">Prefix (optional):</label>
                    <input type="text"
                           id="skugen-prefix"
                           class="skugen-input"
                           maxlength="10"
                           placeholder="e.g., PROD, SHO, CLO"
                           value="<?php echo esc_attr($default_prefix); ?>"
                           aria-describedby="skugen-prefix-help">
                    <p class="skugen-helper-text" id="skugen-prefix-help">Added to the beginning of each SKU</p>
                </div>

                <!-- Suffix -->
                <div class="skugen-field">
                    <label for="skugen-suffix">Suffix (optional):</label>
                    <input type="text"
                           id="skugen-suffix"
                           class="skugen-input"
                           maxlength="10"
                           placeholder="e.g., 2024, US, WH"
                           value="<?php echo esc_attr($default_suffix); ?>"
                           aria-describedby="skugen-suffix-help">
                    <p class="skugen-helper-text" id="skugen-suffix-help">Added to the end of each SKU</p>
                </div>

                <!-- SKU Length -->
                <div class="skugen-field">
                    <label for="skugen-length">SKU Length:</label>
                    <select id="skugen-length" class="skugen-select" aria-describedby="skugen-length-help">
                        <?php for ($i = 1; $i <= 36; $i++) : ?>
                            <option value="<?php echo $i; ?>" <?php selected($default_length, $i); ?>><?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>
                    <p class="skugen-helper-text" id="skugen-length-help">Length of the random/sequential portion only</p>
                </div>

                <!-- Number of SKUs -->
                <div class="skugen-field">
                    <label for="skugen-count">Number of SKUs:</label>
                    <input type="number"
                           id="skugen-count"
                           class="skugen-input"
                           min="1"
                           max="<?php echo esc_attr($max_skus); ?>"
                           value="10"
                           placeholder="e.g., 10"
                           required
                           aria-required="true"
                           aria-describedby="skugen-count-help">
                    <p class="skugen-helper-text" id="skugen-count-help">Maximum <?php echo esc_html($max_skus); ?> SKUs at once</p>
                    <span class="skugen-error" role="alert"></span>
                </div>

                <!-- Character Type -->
                <div class="skugen-field">
                    <label for="skugen-type">Character Type:</label>
                    <select id="skugen-type" class="skugen-select">
                        <option value="sequential" <?php selected($default_type, 'sequential'); ?>>Numbers (Sequential)</option>
                        <option value="random_numbers" <?php selected($default_type, 'random_numbers'); ?>>Numbers (Random)</option>
                        <option value="letters" <?php selected($default_type, 'letters'); ?>>Letters Only</option>
                        <option value="alphanumeric" <?php selected($default_type, 'alphanumeric'); ?>>Numbers & Letters</option>
                    </select>
                </div>

                <!-- Separator -->
                <div class="skugen-field">
                    <label for="skugen-separator">Separator:</label>
                    <select id="skugen-separator" class="skugen-select" aria-describedby="skugen-separator-help">
                        <option value="" selected>None</option>
                        <option value="-">Hyphen (-)</option>
                        <option value="_">Underscore (_)</option>
                        <option value=".">Dot (.)</option>
                    </select>
                    <p class="skugen-helper-text" id="skugen-separator-help">Character between prefix, code, and suffix</p>
                </div>

                <!-- Starting Number (conditional) -->
                <div class="skugen-field" id="skugen-start-field" style="display:none;">
                    <label for="skugen-start">Starting Number:</label>
                    <input type="number"
                           id="skugen-start"
                           class="skugen-input"
                           min="0"
                           value="1"
                           placeholder="e.g., 1001"
                           aria-describedby="skugen-start-help">
                    <p class="skugen-helper-text" id="skugen-start-help">First number in the sequence</p>
                </div>

                <!-- Exclude Confusing Characters -->
                <div class="skugen-field skugen-checkbox-field">
                    <label class="skugen-checkbox-label">
                        <input type="checkbox" id="skugen-exclude-confusing" class="skugen-checkbox" checked>
                        <span>Exclude confusing characters (0, O, 1, I, l)</span>
                    </label>
                    <p class="skugen-helper-text">Prevents mix-ups between similar looking characters</p>
                </div>

                <!-- Live Preview -->
                <?php if ($show_preview) : ?>
                <div class="skugen-preview">
                    <span class="skugen-preview-label">Preview:</span>
                    <span class="skugen-preview-value" id="skugen-preview">XXXXXXXX</span>
                </div>
                <?php endif; ?>

                <button type="button" class="skugen-generate-btn" aria-label="Generate SKUs">
                    Generate SKUs
                </button>
            </div>

            <!-- Results -->
            <div class="skugen-results" style="display:none;" role="region" aria-live="polite">

                <!-- Results Header -->
                <div class="skugen-results-header">
                    <h3 class="skugen-results-title">Generated SKUs</h3>
                    <div class="skugen-results-stats">
                        <span id="skugen-stats-count">0 SKUs generated</span>
                    </div>
                </div>

                <!-- SKU List -->
                <div class="skugen-sku-list" id="skugen-sku-list">
                    <!-- Generated SKUs will appear here dynamically -->
                </div>

                <!-- Action Buttons -->
                <div class="skugen-actions">
                    <button type="button" class="skugen-copy-all-btn" aria-label="Copy all SKUs to clipboard">
                        <span class="skugen-btn-icon">📋</span>
                        Copy All SKUs
                    </button>
                    <?php if ($show_export) : ?>
                    <button type="button" class="skugen-download-csv-btn" aria-label="Download as CSV">
                        <span class="skugen-btn-icon">📄</span>
                        Download CSV
                    </button>
                    <button type="button" class="skugen-download-txt-btn" aria-label="Download as TXT">
                        <span class="skugen-btn-icon">📝</span>
                        Download TXT
                    </button>
                    <?php endif; ?>
                    <button type="button" class="skugen-clear-btn" aria-label="Clear results">
                        <span class="skugen-btn-icon">🗑️</span>
                        Clear
                    </button>
                </div>

                <!-- Copy Success Toast -->
                <div class="skugen-toast" id="skugen-toast" style="display:none;" role="status" aria-live="polite">
                    <span class="skugen-toast-icon">✓</span>
                    <span class="skugen-toast-message">Copied to clipboard!</span>
                </div>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render UTM Builder shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_utm_builder($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'UTM Builder',
            'subtitle' => 'Build UTM tracking links 🔗 in seconds. Track your marketing performance instantly.',
            'show_term' => 'true',
            'show_content' => 'true',
            'show_id' => 'false',
            'show_qr' => 'true',
            'show_breakdown' => 'true',
            'default_url' => '',
            'primary_color' => '#7C3AED',
            'remember_values' => 'true',
        ), $atts, 'utm_builder');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $show_term = filter_var($atts['show_term'], FILTER_VALIDATE_BOOLEAN);
        $show_content = filter_var($atts['show_content'], FILTER_VALIDATE_BOOLEAN);
        $show_id = filter_var($atts['show_id'], FILTER_VALIDATE_BOOLEAN);
        $show_qr = filter_var($atts['show_qr'], FILTER_VALIDATE_BOOLEAN);
        $show_breakdown = filter_var($atts['show_breakdown'], FILTER_VALIDATE_BOOLEAN);
        $default_url = esc_url($atts['default_url']);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        $remember_values = filter_var($atts['remember_values'], FILTER_VALIDATE_BOOLEAN);

        // Start output buffering
        ob_start();
        ?>

        <div class="utmb-wrapper"
             data-show-term="<?php echo $show_term ? 'true' : 'false'; ?>"
             data-show-content="<?php echo $show_content ? 'true' : 'false'; ?>"
             data-show-id="<?php echo $show_id ? 'true' : 'false'; ?>"
             data-show-qr="<?php echo $show_qr ? 'true' : 'false'; ?>"
             data-show-breakdown="<?php echo $show_breakdown ? 'true' : 'false'; ?>"
             data-remember-values="<?php echo $remember_values ? 'true' : 'false'; ?>"
             data-primary-color="<?php echo esc_attr($primary_color); ?>">

            <!-- Header -->
            <div class="utmb-header">
                <h2 class="utmb-title"><?php echo esc_html($title); ?></h2>
                <p class="utmb-subtitle"><?php echo wp_kses_post($subtitle); ?></p>
            </div>

            <!-- Form -->
            <div class="utmb-form">

                <!-- Website URL -->
                <div class="utmb-field utmb-required">
                    <label for="utmb-url">Website URL: <span class="utmb-required-star">*</span></label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">🔗</span>
                        <input type="url"
                               id="utmb-url"
                               class="utmb-input"
                               placeholder="https://yourstore.com/products/example"
                               value="<?php echo esc_attr($default_url); ?>"
                               required
                               aria-required="true"
                               aria-describedby="utmb-url-help">
                    </div>
                    <p class="utmb-helper-text" id="utmb-url-help">Enter your full website or page URL</p>
                    <span class="utmb-error" role="alert"></span>
                </div>

                <!-- Campaign Source -->
                <div class="utmb-field utmb-required">
                    <label for="utmb-source">Campaign Source: <span class="utmb-required-star">*</span></label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">📍</span>
                        <input type="text"
                               id="utmb-source"
                               class="utmb-input"
                               list="utmb-source-list"
                               placeholder="e.g., facebook, google, newsletter"
                               required
                               aria-required="true"
                               aria-describedby="utmb-source-help">
                        <datalist id="utmb-source-list">
                            <option value="facebook">
                            <option value="instagram">
                            <option value="google">
                            <option value="twitter">
                            <option value="linkedin">
                            <option value="youtube">
                            <option value="tiktok">
                            <option value="pinterest">
                            <option value="newsletter">
                            <option value="email">
                            <option value="bing">
                            <option value="reddit">
                        </datalist>
                    </div>
                    <p class="utmb-helper-text" id="utmb-source-help">Where the traffic comes from (utm_source)</p>
                    <span class="utmb-error" role="alert"></span>
                </div>

                <!-- Campaign Medium -->
                <div class="utmb-field utmb-required">
                    <label for="utmb-medium">Campaign Medium: <span class="utmb-required-star">*</span></label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">📢</span>
                        <select id="utmb-medium"
                                class="utmb-select"
                                required
                                aria-required="true"
                                aria-describedby="utmb-medium-help">
                            <option value="" disabled selected>Select Medium</option>
                            <option value="cpc">CPC (Cost Per Click)</option>
                            <option value="social">Social</option>
                            <option value="email">Email</option>
                            <option value="organic">Organic</option>
                            <option value="referral">Referral</option>
                            <option value="display">Display</option>
                            <option value="affiliate">Affiliate</option>
                            <option value="video">Video</option>
                            <option value="banner">Banner</option>
                            <option value="retargeting">Retargeting</option>
                            <option value="influencer">Influencer</option>
                            <option value="podcast">Podcast</option>
                            <option value="sms">SMS</option>
                            <option value="push">Push Notification</option>
                            <option value="qr">QR Code</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <p class="utmb-helper-text" id="utmb-medium-help">The marketing medium (utm_medium)</p>
                    <span class="utmb-error" role="alert"></span>
                </div>

                <!-- Campaign Name -->
                <div class="utmb-field utmb-required">
                    <label for="utmb-campaign">Campaign Name: <span class="utmb-required-star">*</span></label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">🏷️</span>
                        <input type="text"
                               id="utmb-campaign"
                               class="utmb-input"
                               placeholder="e.g., summer_sale, black_friday"
                               required
                               aria-required="true"
                               aria-describedby="utmb-campaign-help">
                    </div>
                    <p class="utmb-helper-text" id="utmb-campaign-help">Your campaign identifier (utm_campaign)</p>
                    <span class="utmb-error" role="alert"></span>
                </div>

                <!-- Campaign Term (Optional) -->
                <?php if ($show_term) : ?>
                <div class="utmb-field utmb-optional">
                    <label for="utmb-term">Campaign Term:</label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">🔍</span>
                        <input type="text"
                               id="utmb-term"
                               class="utmb-input"
                               placeholder="e.g., running+shoes"
                               aria-describedby="utmb-term-help">
                    </div>
                    <p class="utmb-helper-text" id="utmb-term-help">Optional: For paid keywords (utm_term)</p>
                </div>
                <?php endif; ?>

                <!-- Campaign Content (Optional) -->
                <?php if ($show_content) : ?>
                <div class="utmb-field utmb-optional">
                    <label for="utmb-content">Campaign Content:</label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">📝</span>
                        <input type="text"
                               id="utmb-content"
                               class="utmb-input"
                               placeholder="e.g., banner_ad, text_link"
                               aria-describedby="utmb-content-help">
                    </div>
                    <p class="utmb-helper-text" id="utmb-content-help">Optional: To differentiate ads (utm_content)</p>
                </div>
                <?php endif; ?>

                <!-- Campaign ID (Optional - Enhancement) -->
                <?php if ($show_id) : ?>
                <div class="utmb-field utmb-optional">
                    <label for="utmb-id">Campaign ID:</label>
                    <div class="utmb-input-wrapper">
                        <span class="utmb-input-icon">🆔</span>
                        <input type="text"
                               id="utmb-id"
                               class="utmb-input"
                               placeholder="e.g., abc123"
                               aria-describedby="utmb-id-help">
                    </div>
                    <p class="utmb-helper-text" id="utmb-id-help">Optional: Unique campaign ID (utm_id)</p>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="utmb-actions">
                    <button type="button" class="utmb-generate-btn" aria-label="Generate URL">
                        Generate URL
                    </button>
                    <button type="button" class="utmb-reset-btn" aria-label="Reset form">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Live Preview -->
            <div class="utmb-preview" id="utmb-preview-section">
                <h4 class="utmb-preview-title">Live Preview:</h4>
                <div class="utmb-preview-url" id="utmb-preview-url">
                    Enter required fields to see preview...
                </div>
            </div>

            <!-- Results Section -->
            <div class="utmb-results" id="utmb-results-section" style="display:none;" role="region" aria-live="polite">

                <!-- Results Header -->
                <div class="utmb-results-header">
                    <h3>Your Tracked URL:</h3>
                </div>

                <!-- Generated URL Display -->
                <div class="utmb-url-display">
                    <div class="utmb-url-box" id="utmb-generated-url">
                        <!-- Generated URL appears here -->
                    </div>
                    <button type="button" class="utmb-copy-btn" id="utmb-copy-btn" aria-label="Copy URL to clipboard">
                        <span class="utmb-copy-icon">📋</span>
                        <span class="utmb-copy-text">Copy URL</span>
                    </button>
                </div>

                <!-- URL Length -->
                <div class="utmb-url-stats">
                    <span id="utmb-url-length">0 characters</span>
                </div>

                <!-- URL Breakdown -->
                <?php if ($show_breakdown) : ?>
                <div class="utmb-breakdown" id="utmb-breakdown-section">
                    <h4 class="utmb-breakdown-title">URL Breakdown:</h4>
                    <table class="utmb-breakdown-table">
                        <tr>
                            <td class="utmb-param-name">Base URL</td>
                            <td class="utmb-param-value" id="utmb-bd-base">-</td>
                        </tr>
                        <tr>
                            <td class="utmb-param-name">utm_source</td>
                            <td class="utmb-param-value" id="utmb-bd-source">-</td>
                        </tr>
                        <tr>
                            <td class="utmb-param-name">utm_medium</td>
                            <td class="utmb-param-value" id="utmb-bd-medium">-</td>
                        </tr>
                        <tr>
                            <td class="utmb-param-name">utm_campaign</td>
                            <td class="utmb-param-value" id="utmb-bd-campaign">-</td>
                        </tr>
                        <?php if ($show_term) : ?>
                        <tr id="utmb-bd-term-row" style="display:none;">
                            <td class="utmb-param-name">utm_term</td>
                            <td class="utmb-param-value" id="utmb-bd-term">-</td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($show_content) : ?>
                        <tr id="utmb-bd-content-row" style="display:none;">
                            <td class="utmb-param-name">utm_content</td>
                            <td class="utmb-param-value" id="utmb-bd-content">-</td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($show_id) : ?>
                        <tr id="utmb-bd-id-row" style="display:none;">
                            <td class="utmb-param-name">utm_id</td>
                            <td class="utmb-param-value" id="utmb-bd-id">-</td>
                        </tr>
                        <?php endif; ?>
                    </table>
                </div>
                <?php endif; ?>

                <!-- QR Code Section -->
                <?php if ($show_qr) : ?>
                <div class="utmb-qr-section" id="utmb-qr-section">
                    <h4 class="utmb-qr-title">QR Code:</h4>
                    <div class="utmb-qr-container">
                        <div class="utmb-qr-code" id="utmb-qr-code">
                            <!-- QR Code appears here -->
                        </div>
                        <button type="button" class="utmb-download-qr-btn" id="utmb-download-qr" aria-label="Download QR code">
                            📥 Download QR Code
                        </button>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Copy Toast -->
                <div class="utmb-toast" id="utmb-toast" style="display:none;" role="status" aria-live="polite">
                    <span class="utmb-toast-icon">✓</span>
                    <span class="utmb-toast-message">Copied to clipboard!</span>
                </div>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render Gross Profit Calculator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_gross_profit_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'Gross Profit Calculator',
            'subtitle' => 'Calculate your gross profit and margin in real-time.',
            'currency' => '$',
            'max_items' => '1000',
            'primary_color' => '#4F46E5',
            'profit_color' => '#10B981',
        ), $atts, 'gross_profit_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $currency = sanitize_text_field($atts['currency']);
        $max_items = intval($atts['max_items']);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        $profit_color = sanitize_hex_color($atts['profit_color']);

        // Ensure valid ranges
        if ($max_items < 1) $max_items = 1;
        if ($max_items > 10000) $max_items = 10000;
        if (!$primary_color) $primary_color = '#4F46E5';
        if (!$profit_color) $profit_color = '#10B981';

        // Generate unique ID for this calculator instance
        $unique_id = 'gpc_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="gpc-wrapper"
             id="<?php echo esc_attr($unique_id); ?>"
             data-currency="<?php echo esc_attr($currency); ?>"
             data-max-items="<?php echo esc_attr($max_items); ?>"
             data-primary-color="<?php echo esc_attr($primary_color); ?>"
             data-profit-color="<?php echo esc_attr($profit_color); ?>">

            <!-- Header -->
            <div class="gpc-header">
                <h2 class="gpc-title"><?php echo esc_html($title); ?></h2>
                <?php if ($subtitle) : ?>
                <p class="gpc-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Form -->
            <div class="gpc-form">

                <!-- Sales Price -->
                <div class="gpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-sales-price">
                        Sales Price (per unit):
                    </label>
                    <div class="gpc-input-wrapper">
                        <span class="gpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-sales-price"
                            class="gpc-input gpc-sales-price"
                            placeholder="0.00"
                            aria-label="Sales price per unit"
                            aria-describedby="<?php echo esc_attr($unique_id); ?>-sales-price-help"
                        >
                    </div>
                    <p class="gpc-helper-text" id="<?php echo esc_attr($unique_id); ?>-sales-price-help">
                        The price you sell each unit for
                    </p>
                </div>

                <!-- COGS -->
                <div class="gpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-cogs">
                        COGS - Cost of Goods Sold (per unit):
                    </label>
                    <div class="gpc-input-wrapper">
                        <span class="gpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-cogs"
                            class="gpc-input gpc-cogs"
                            placeholder="0.00"
                            aria-label="Cost of goods sold per unit"
                            aria-describedby="<?php echo esc_attr($unique_id); ?>-cogs-help"
                        >
                    </div>
                    <p class="gpc-helper-text" id="<?php echo esc_attr($unique_id); ?>-cogs-help">
                        The cost to produce or purchase each unit
                    </p>
                </div>

                <!-- Items Sold -->
                <div class="gpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-items">
                        Items Sold:
                    </label>
                    <div class="gpc-slider-wrapper">
                        <input
                            type="range"
                            id="<?php echo esc_attr($unique_id); ?>-items-slider"
                            class="gpc-slider"
                            min="1"
                            max="<?php echo esc_attr($max_items); ?>"
                            value="100"
                            aria-label="Number of items sold"
                            aria-describedby="<?php echo esc_attr($unique_id); ?>-items-help"
                        >
                        <input
                            type="number"
                            id="<?php echo esc_attr($unique_id); ?>-items"
                            class="gpc-number-input"
                            min="1"
                            max="<?php echo esc_attr($max_items); ?>"
                            value="100"
                            aria-label="Number of items sold (numeric input)"
                        >
                    </div>
                    <p class="gpc-helper-text" id="<?php echo esc_attr($unique_id); ?>-items-help">
                        Total number of units sold (1-<?php echo esc_html($max_items); ?>)
                    </p>
                </div>

            </div>

            <!-- Results Section -->
            <div class="gpc-results">

                <!-- Gross Profit Card -->
                <div class="gpc-result-card gpc-profit-card">
                    <div class="gpc-result-label">
                        <span class="gpc-result-icon">💰</span>
                        Gross Profit
                    </div>
                    <div class="gpc-result-value" id="<?php echo esc_attr($unique_id); ?>-profit-value">
                        <?php echo esc_html($currency); ?>0.00
                    </div>
                    <div class="gpc-result-formula">
                        (Sales Price - COGS) × Items Sold
                    </div>
                </div>

                <!-- Gross Profit Margin Card -->
                <div class="gpc-result-card gpc-margin-card">
                    <div class="gpc-result-label">
                        <span class="gpc-result-icon">📊</span>
                        Gross Profit Margin
                    </div>
                    <div class="gpc-result-value" id="<?php echo esc_attr($unique_id); ?>-margin-value">
                        0.00%
                    </div>
                    <div class="gpc-result-formula">
                        ((Sales Price - COGS) / Sales Price) × 100
                    </div>
                    <div class="gpc-margin-indicator" id="<?php echo esc_attr($unique_id); ?>-margin-indicator">
                        <div class="gpc-indicator-bar">
                            <div class="gpc-indicator-fill" id="<?php echo esc_attr($unique_id); ?>-indicator-fill"></div>
                        </div>
                        <div class="gpc-indicator-label" id="<?php echo esc_attr($unique_id); ?>-indicator-label">
                            Enter values to calculate
                        </div>
                    </div>
                </div>

            </div>

            <!-- Info Section -->
            <div class="gpc-info">
                <h4>Understanding Your Results:</h4>
                <ul>
                    <li><strong>Gross Profit:</strong> The total profit before operating expenses</li>
                    <li><strong>Gross Margin:</strong> Profitability as a percentage of sales</li>
                    <li><strong>Good Margin:</strong> &gt;50% (Excellent), 30-50% (Good), 20-30% (Fair), &lt;20% (Low)</li>
                </ul>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render POD Profit Calculator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_pod_profit_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'POD Profit Calculator',
            'subtitle' => 'Calculate your Print on Demand profits with detailed cost breakdown.',
            'currency' => '$',
            'primary_color' => '#4F46E5',
            'profit_color' => '#10B981',
            'loss_color' => '#EF4444',
        ), $atts, 'pod_profit_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);
        $currency = sanitize_text_field($atts['currency']);
        $primary_color = sanitize_hex_color($atts['primary_color']);
        $profit_color = sanitize_hex_color($atts['profit_color']);
        $loss_color = sanitize_hex_color($atts['loss_color']);

        // Set defaults if sanitization fails
        if (!$primary_color) $primary_color = '#4F46E5';
        if (!$profit_color) $profit_color = '#10B981';
        if (!$loss_color) $loss_color = '#EF4444';

        // Generate unique ID for this calculator instance
        $unique_id = 'podpc_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="podpc-wrapper"
             id="<?php echo esc_attr($unique_id); ?>"
             data-currency="<?php echo esc_attr($currency); ?>"
             data-primary-color="<?php echo esc_attr($primary_color); ?>"
             data-profit-color="<?php echo esc_attr($profit_color); ?>"
             data-loss-color="<?php echo esc_attr($loss_color); ?>">

            <!-- Header -->
            <div class="podpc-header">
                <h2 class="podpc-title"><?php echo esc_html($title); ?></h2>
                <?php if ($subtitle) : ?>
                <p class="podpc-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Form (2 columns on desktop) -->
            <div class="podpc-form">

                <!-- Selling Price -->
                <div class="podpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-selling-price">
                        <span class="podpc-icon">💰</span>
                        Selling Price Per Item:
                    </label>
                    <div class="podpc-input-wrapper">
                        <span class="podpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-selling-price"
                            class="podpc-input podpc-selling-price"
                            placeholder="0.00"
                            aria-label="Selling price per item"
                        >
                    </div>
                </div>

                <!-- Shipping Fees -->
                <div class="podpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-shipping">
                        <span class="podpc-icon">📦</span>
                        Shipping Fees Per Item:
                    </label>
                    <div class="podpc-input-wrapper">
                        <span class="podpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-shipping"
                            class="podpc-input podpc-shipping"
                            placeholder="0.00"
                            aria-label="Shipping fees per item"
                        >
                    </div>
                </div>

                <!-- Items Sold -->
                <div class="podpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-items">
                        <span class="podpc-icon">🛒</span>
                        Items Sold:
                    </label>
                    <input
                        type="number"
                        id="<?php echo esc_attr($unique_id); ?>-items"
                        class="podpc-input podpc-items"
                        min="1"
                        value="1"
                        aria-label="Number of items sold"
                    >
                </div>

                <!-- Marketing Fees (CPA) -->
                <div class="podpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-marketing">
                        <span class="podpc-icon">📊</span>
                        Marketing Fees Per Item (CPA):
                    </label>
                    <div class="podpc-input-wrapper">
                        <span class="podpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-marketing"
                            class="podpc-input podpc-marketing"
                            placeholder="0.00"
                            aria-label="Marketing fees per item"
                        >
                    </div>
                </div>

                <!-- Product Costs -->
                <div class="podpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-product-costs">
                        <span class="podpc-icon">🏷️</span>
                        Product Costs Per Item:
                    </label>
                    <div class="podpc-input-wrapper">
                        <span class="podpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-product-costs"
                            class="podpc-input podpc-product-costs"
                            placeholder="0.00"
                            aria-label="Product costs per item"
                        >
                    </div>
                </div>

                <!-- Other Fees (Optional) -->
                <div class="podpc-field">
                    <label for="<?php echo esc_attr($unique_id); ?>-other-fees">
                        <span class="podpc-icon">💳</span>
                        Other Fees Per Item (optional):
                    </label>
                    <div class="podpc-input-wrapper">
                        <span class="podpc-currency-prefix"><?php echo esc_html($currency); ?></span>
                        <input
                            type="text"
                            inputmode="decimal"
                            id="<?php echo esc_attr($unique_id); ?>-other-fees"
                            class="podpc-input podpc-other-fees"
                            placeholder="0.00"
                            aria-label="Other fees per item"
                        >
                    </div>
                    <p class="podpc-helper-text">Transaction fees, payment processing, etc.</p>
                </div>

            </div>

            <!-- Results Section (2x2 Grid) -->
            <div class="podpc-results">

                <!-- Revenue Card -->
                <div class="podpc-result-card podpc-revenue-card">
                    <div class="podpc-result-label">
                        <span class="podpc-result-icon">💵</span>
                        Revenue
                    </div>
                    <div class="podpc-result-value" id="<?php echo esc_attr($unique_id); ?>-revenue">
                        <?php echo esc_html($currency); ?>0.00
                    </div>
                    <div class="podpc-result-formula">
                        Selling Price × Items Sold
                    </div>
                </div>

                <!-- Total Costs Card -->
                <div class="podpc-result-card podpc-costs-card">
                    <div class="podpc-result-label">
                        <span class="podpc-result-icon">💸</span>
                        Total Costs
                    </div>
                    <div class="podpc-result-value" id="<?php echo esc_attr($unique_id); ?>-costs">
                        <?php echo esc_html($currency); ?>0.00
                    </div>
                    <div class="podpc-result-formula">
                        All Fees × Items Sold
                    </div>
                </div>

                <!-- Net Profit Card -->
                <div class="podpc-result-card podpc-profit-card">
                    <div class="podpc-result-label">
                        <span class="podpc-result-icon">🎯</span>
                        Net Profit
                    </div>
                    <div class="podpc-result-value" id="<?php echo esc_attr($unique_id); ?>-profit">
                        <?php echo esc_html($currency); ?>0.00
                    </div>
                    <div class="podpc-result-formula">
                        Revenue - Total Costs
                    </div>
                </div>

                <!-- Net Profit Margin Card -->
                <div class="podpc-result-card podpc-margin-card">
                    <div class="podpc-result-label">
                        <span class="podpc-result-icon">📈</span>
                        Net Profit Margin
                    </div>
                    <div class="podpc-result-value" id="<?php echo esc_attr($unique_id); ?>-margin">
                        0.00%
                    </div>
                    <div class="podpc-result-formula">
                        (Net Profit / Revenue) × 100
                    </div>
                </div>

            </div>

            <!-- Info Section -->
            <div class="podpc-info">
                <h4>💡 Understanding POD Costs:</h4>
                <ul>
                    <li><strong>Shipping Fees:</strong> Cost to ship each item to customer</li>
                    <li><strong>Marketing Fees (CPA):</strong> Cost Per Acquisition - advertising spend per sale</li>
                    <li><strong>Product Costs:</strong> Manufacturing, printing, and base product costs</li>
                    <li><strong>Other Fees:</strong> Payment processing, platform fees, taxes</li>
                    <li><strong>Target Margin:</strong> Aim for 20-30% net profit margin for sustainable POD business</li>
                </ul>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Render Shopify Fee Calculator shortcode
     *
     * @param array $atts Shortcode attributes
     * @return string HTML output
     */
    public function render_shopify_fee_calculator($atts) {
        // Parse shortcode attributes
        $atts = shortcode_atts(array(
            'title' => 'Shopify Fee Calculator',
            'subtitle' => 'Compare payment processing fees across all Shopify plans.',

            // Plan Prices
            'basic_price' => '39',
            'shopify_price' => '105',
            'advanced_price' => '399',

            // Shopify Payments Rates (percentage)
            'basic_sp_percent' => '2.9',
            'shopify_sp_percent' => '2.6',
            'advanced_sp_percent' => '2.4',

            // Shopify Payments Fixed Fees
            'basic_sp_fixed' => '0.30',
            'shopify_sp_fixed' => '0.30',
            'advanced_sp_fixed' => '0.30',

            // Transaction Fees (percentage) - when not using Shopify Payments
            'basic_transaction_fee' => '2.0',
            'shopify_transaction_fee' => '1.0',
            'advanced_transaction_fee' => '0.5',

            // PayPal Rates
            'paypal_percent' => '2.9',
            'paypal_fixed' => '0.30',
        ), $atts, 'shopify_fee_calculator');

        // Sanitize attributes
        $title = sanitize_text_field($atts['title']);
        $subtitle = sanitize_text_field($atts['subtitle']);

        // Sanitize numeric values
        $basic_price = floatval($atts['basic_price']);
        $shopify_price = floatval($atts['shopify_price']);
        $advanced_price = floatval($atts['advanced_price']);

        $basic_sp_percent = floatval($atts['basic_sp_percent']);
        $shopify_sp_percent = floatval($atts['shopify_sp_percent']);
        $advanced_sp_percent = floatval($atts['advanced_sp_percent']);

        $basic_sp_fixed = floatval($atts['basic_sp_fixed']);
        $shopify_sp_fixed = floatval($atts['shopify_sp_fixed']);
        $advanced_sp_fixed = floatval($atts['advanced_sp_fixed']);

        $basic_transaction_fee = floatval($atts['basic_transaction_fee']);
        $shopify_transaction_fee = floatval($atts['shopify_transaction_fee']);
        $advanced_transaction_fee = floatval($atts['advanced_transaction_fee']);

        $paypal_percent = floatval($atts['paypal_percent']);
        $paypal_fixed = floatval($atts['paypal_fixed']);

        // Generate unique ID for this calculator instance
        $unique_id = 'shopify_' . uniqid();

        // Start output buffering
        ob_start();
        ?>

        <div class="shopify-calc-wrapper" id="<?php echo esc_attr($unique_id); ?>"
             data-basic-price="<?php echo esc_attr($basic_price); ?>"
             data-shopify-price="<?php echo esc_attr($shopify_price); ?>"
             data-advanced-price="<?php echo esc_attr($advanced_price); ?>"
             data-basic-sp-percent="<?php echo esc_attr($basic_sp_percent); ?>"
             data-shopify-sp-percent="<?php echo esc_attr($shopify_sp_percent); ?>"
             data-advanced-sp-percent="<?php echo esc_attr($advanced_sp_percent); ?>"
             data-basic-sp-fixed="<?php echo esc_attr($basic_sp_fixed); ?>"
             data-shopify-sp-fixed="<?php echo esc_attr($shopify_sp_fixed); ?>"
             data-advanced-sp-fixed="<?php echo esc_attr($advanced_sp_fixed); ?>"
             data-basic-transaction-fee="<?php echo esc_attr($basic_transaction_fee); ?>"
             data-shopify-transaction-fee="<?php echo esc_attr($shopify_transaction_fee); ?>"
             data-advanced-transaction-fee="<?php echo esc_attr($advanced_transaction_fee); ?>"
             data-paypal-percent="<?php echo esc_attr($paypal_percent); ?>"
             data-paypal-fixed="<?php echo esc_attr($paypal_fixed); ?>">

            <!-- Header -->
            <div class="shopify-calc-header">
                <h2 class="shopify-calc-title"><?php echo esc_html($title); ?></h2>
                <?php if ($subtitle) : ?>
                <p class="shopify-calc-subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>

            <!-- Input Section -->
            <div class="shopify-calc-inputs">

                <!-- Section 1: Time Period -->
                <div class="shopify-calc-section">
                    <h3 class="shopify-calc-section-title">
                        <span class="shopify-calc-icon">📅</span>
                        Time Period
                    </h3>
                    <div class="shopify-calc-radio-group">
                        <label class="shopify-calc-radio-label">
                            <input type="radio" name="period" id="monthly" value="monthly" checked>
                            <span>Monthly</span>
                        </label>
                        <label class="shopify-calc-radio-label">
                            <input type="radio" name="period" id="yearly" value="yearly">
                            <span>Yearly</span>
                        </label>
                    </div>
                </div>

                <!-- Section 2: Payment Methods -->
                <div class="shopify-calc-section">
                    <h3 class="shopify-calc-section-title">
                        <span class="shopify-calc-icon">💳</span>
                        Payment Methods (Select All That Apply)
                    </h3>
                    <div class="shopify-calc-checkbox-group">
                        <label class="shopify-calc-checkbox-label">
                            <input type="checkbox" id="shopify-payments" checked>
                            <span>Shopify Payments</span>
                        </label>
                        <label class="shopify-calc-checkbox-label">
                            <input type="checkbox" id="paypal">
                            <span>PayPal</span>
                        </label>
                        <label class="shopify-calc-checkbox-label">
                            <input type="checkbox" id="other-gateway">
                            <span>Other Payment Gateway</span>
                        </label>
                    </div>

                    <!-- Other Gateway Details -->
                    <div class="shopify-calc-other-gateway hidden">
                        <div class="shopify-calc-field">
                            <label for="gateway-percent">Gateway Percentage Fee:</label>
                            <div class="shopify-calc-input-wrapper">
                                <input
                                    type="number"
                                    id="gateway-percent"
                                    class="shopify-calc-input"
                                    step="0.1"
                                    min="0"
                                    placeholder="2.9"
                                    value="2.9"
                                >
                                <span class="shopify-calc-percent-suffix">%</span>
                            </div>
                        </div>
                        <div class="shopify-calc-field">
                            <label for="gateway-fixed">Gateway Fixed Fee:</label>
                            <div class="shopify-calc-input-wrapper">
                                <span class="shopify-calc-currency-prefix">$</span>
                                <input
                                    type="text"
                                    inputmode="decimal"
                                    id="gateway-fixed"
                                    class="shopify-calc-input"
                                    placeholder="0.30"
                                    value="0.30"
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Sales Information -->
                <div class="shopify-calc-section">
                    <h3 class="shopify-calc-section-title">
                        <span class="shopify-calc-icon">💰</span>
                        Sales Information
                    </h3>
                    <div class="shopify-calc-field">
                        <label for="sales-value">Total Sales Value:</label>
                        <div class="shopify-calc-input-wrapper">
                            <span class="shopify-calc-currency-prefix">$</span>
                            <input
                                type="text"
                                inputmode="decimal"
                                id="sales-value"
                                class="shopify-calc-input"
                                placeholder="10000.00"
                            >
                        </div>
                    </div>
                    <div class="shopify-calc-field">
                        <label for="transactions">Number of Transactions:</label>
                        <input
                            type="number"
                            id="transactions"
                            class="shopify-calc-input"
                            min="1"
                            placeholder="100"
                        >
                    </div>
                </div>

            </div>

            <!-- Results Section -->
            <div class="shopify-calc-results">
                <h3 class="shopify-calc-results-title">💎 Plan Comparison</h3>

                <div class="shopify-calc-plans">

                    <!-- Basic Plan -->
                    <div class="shopify-calc-plan">
                        <div class="shopify-calc-plan-header">
                            <h4 class="shopify-calc-plan-name">Basic</h4>
                            <p class="shopify-calc-plan-price">$<?php echo number_format($basic_price, 0); ?>/month</p>
                        </div>
                        <div class="shopify-calc-fee-breakdown">
                            <!-- Fees populated by JS -->
                        </div>
                        <div class="shopify-calc-total shopify-calc-fee-item">
                            <span class="shopify-calc-total-label">Total Fees:</span>
                            <span class="shopify-calc-total-value">$0.00</span>
                        </div>
                    </div>

                    <!-- Shopify Plan -->
                    <div class="shopify-calc-plan">
                        <div class="shopify-calc-plan-header">
                            <h4 class="shopify-calc-plan-name">Shopify</h4>
                            <p class="shopify-calc-plan-price">$<?php echo number_format($shopify_price, 0); ?>/month</p>
                        </div>
                        <div class="shopify-calc-fee-breakdown">
                            <!-- Fees populated by JS -->
                        </div>
                        <div class="shopify-calc-total shopify-calc-fee-item">
                            <span class="shopify-calc-total-label">Total Fees:</span>
                            <span class="shopify-calc-total-value">$0.00</span>
                        </div>
                    </div>

                    <!-- Advanced Plan -->
                    <div class="shopify-calc-plan">
                        <div class="shopify-calc-plan-header">
                            <h4 class="shopify-calc-plan-name">Advanced</h4>
                            <p class="shopify-calc-plan-price">$<?php echo number_format($advanced_price, 0); ?>/month</p>
                        </div>
                        <div class="shopify-calc-fee-breakdown">
                            <!-- Fees populated by JS -->
                        </div>
                        <div class="shopify-calc-total shopify-calc-fee-item">
                            <span class="shopify-calc-total-label">Total Fees:</span>
                            <span class="shopify-calc-total-value">$0.00</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            'Tools Collection',           // Page title
            'Tools Collection',           // Menu title
            'manage_options',             // Capability
            'tools-collection',           // Menu slug
            array($this, 'render_documentation_page'), // Callback
            'dashicons-admin-tools',      // Icon
            30                            // Position
        );

        // Add submenu for documentation
        add_submenu_page(
            'tools-collection',           // Parent slug
            'Calculator Documentation',   // Page title
            'Documentation',              // Menu title
            'manage_options',             // Capability
            'tools-collection',           // Menu slug (same as parent)
            array($this, 'render_documentation_page') // Callback
        );
    }

    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our admin page
        if ($hook !== 'toplevel_page_tools-collection') {
            return;
        }

        // Add inline admin styles
        wp_add_inline_style('wp-admin', $this->get_admin_css());
    }

    /**
     * Get admin CSS
     */
    private function get_admin_css() {
        return '
            .crc-admin-wrapper {
                max-width: 1200px;
                margin: 20px 0;
            }
            .crc-admin-header {
                background: #fff;
                padding: 30px;
                border-left: 4px solid #4F46E5;
                margin-bottom: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .crc-admin-header h1 {
                margin: 0 0 10px 0;
                color: #1F2937;
                font-size: 28px;
            }
            .crc-admin-header p {
                margin: 0;
                color: #6B7280;
                font-size: 16px;
            }
            .crc-admin-section {
                background: #fff;
                padding: 30px;
                margin-bottom: 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .crc-admin-section h2 {
                margin: 0 0 20px 0;
                color: #1F2937;
                font-size: 22px;
                border-bottom: 2px solid #E5E7EB;
                padding-bottom: 10px;
            }
            .crc-admin-section h3 {
                margin: 25px 0 15px 0;
                color: #374151;
                font-size: 18px;
            }
            .crc-shortcode-box {
                background: #F9FAFB;
                border: 1px solid #E5E7EB;
                border-radius: 6px;
                padding: 15px;
                margin: 15px 0;
                font-family: "Courier New", monospace;
                font-size: 14px;
                position: relative;
            }
            .crc-shortcode-box code {
                background: transparent;
                padding: 0;
                color: #DC2626;
            }
            .crc-copy-shortcode {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 5px 12px;
                background: #4F46E5;
                color: #fff;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 12px;
                transition: all 0.2s;
            }
            .crc-copy-shortcode:hover {
                background: #4338CA;
            }
            .crc-copy-shortcode.copied {
                background: #10B981;
            }
            .crc-attributes-table {
                width: 100%;
                border-collapse: collapse;
                margin: 15px 0;
            }
            .crc-attributes-table th,
            .crc-attributes-table td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #E5E7EB;
            }
            .crc-attributes-table th {
                background: #F9FAFB;
                font-weight: 600;
                color: #374151;
            }
            .crc-attributes-table td code {
                background: #F9FAFB;
                padding: 2px 6px;
                border-radius: 3px;
                color: #DC2626;
                font-size: 13px;
            }
            .crc-preview-section {
                margin-top: 20px;
                padding-top: 20px;
                border-top: 2px solid #E5E7EB;
            }
            .crc-feature-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 15px;
                margin: 20px 0;
            }
            .crc-feature-item {
                background: #F9FAFB;
                padding: 15px;
                border-radius: 6px;
                border-left: 3px solid #4F46E5;
            }
            .crc-feature-item h4 {
                margin: 0 0 8px 0;
                color: #1F2937;
                font-size: 16px;
            }
            .crc-feature-item p {
                margin: 0;
                color: #6B7280;
                font-size: 14px;
                line-height: 1.5;
            }
            .crc-support-box {
                background: #EEF2FF;
                border: 1px solid #C7D2FE;
                border-radius: 6px;
                padding: 20px;
                margin: 20px 0;
            }
            .crc-support-box h3 {
                margin: 0 0 10px 0;
                color: #3730A3;
            }
            .crc-support-box p {
                margin: 5px 0;
                color: #4338CA;
            }
        ';
    }

    /**
     * Render documentation page
     */
    public function render_documentation_page() {
        ?>
        <div class="wrap crc-admin-wrapper">
            <div class="crc-admin-header">
                <h1>ReportGenix Tools Collection - Documentation</h1>
                <p>Learn how to use our professional business calculators in your WordPress pages and posts.</p>
            </div>

            <!-- Tools Overview -->
            <div class="crc-admin-section">
                <h2>Available Tools</h2>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Conversion Rate Calculator</h4>
                        <p>Calculate and display conversion rates with performance benchmarks.</p>
                        <code>[conversion_rate_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>ROI Calculator</h4>
                        <p>Calculate Return on Investment with detailed metrics and projections.</p>
                        <code>[roi_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>ROAS Calculator</h4>
                        <p>Calculate Return on Ad Spend to measure advertising campaign effectiveness.</p>
                        <code>[roas_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>CAC Calculator</h4>
                        <p>Calculate Customer Acquisition Cost with detailed metrics and breakdowns.</p>
                        <code>[cac_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>CLV Calculator</h4>
                        <p>Calculate Customer Lifetime Value with CLV:CAC ratio analysis and What-If simulator.</p>
                        <code>[clv_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>SKU Generator</h4>
                        <p>Generate unique SKU codes with multiple formats, export options, and QR codes.</p>
                        <code>[sku_generator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>UTM Builder</h4>
                        <p>Build UTM tracking URLs for campaigns with live preview and QR code generation.</p>
                        <code>[utm_builder]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Gross Profit Calculator</h4>
                        <p>Calculate gross profit and margin in real-time with visual indicators.</p>
                        <code>[gross_profit_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>POD Profit Calculator</h4>
                        <p>Calculate print-on-demand profit margins with comprehensive cost analysis.</p>
                        <code>[pod_profit_calculator]</code>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Shopify Fee Calculator</h4>
                        <p>Compare payment processing fees across all Shopify plans with best value detection.</p>
                        <code>[shopify_fee_calculator]</code>
                    </div>
                </div>
            </div>

            <!-- Conversion Rate Calculator -->
            <div class="crc-admin-section">
                <h2>1. Conversion Rate Calculator</h2>

                <h3>Basic Usage</h3>
                <p>To display the conversion rate calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[conversion_rate_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[conversion_rate_calculator]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the conversion rate calculator using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the calculator</td>
                            <td>"Conversion Rate Calculator"</td>
                            <td><code>title="Calculate Your Rate"</code></td>
                        </tr>
                        <tr>
                            <td><code>button_text</code></td>
                            <td>Text displayed on the calculate button</td>
                            <td>"Calculate Conversion Rate"</td>
                            <td><code>button_text="Calculate Now"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_benchmark</code></td>
                            <td>Show or hide performance indicators</td>
                            <td>true</td>
                            <td><code>show_benchmark="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Custom button color (hex format)</td>
                            <td>#4F46E5</td>
                            <td><code>primary_color="#FF6B6B"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Example 1: Custom Title</h3>
                <div class="crc-shortcode-box">
                    <code>[conversion_rate_calculator title="Calculate Your Store's Conversion"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[conversion_rate_calculator title=&quot;Calculate Your Store\'s Conversion&quot;]')">Copy</button>
                </div>

                <h3>Example 2: Hide Performance Benchmark</h3>
                <div class="crc-shortcode-box">
                    <code>[conversion_rate_calculator show_benchmark="false"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[conversion_rate_calculator show_benchmark=&quot;false&quot;]')">Copy</button>
                </div>

                <h3>Example 3: Custom Button Color</h3>
                <div class="crc-shortcode-box">
                    <code>[conversion_rate_calculator primary_color="#FF6B6B"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[conversion_rate_calculator primary_color=&quot;#FF6B6B&quot;]')">Copy</button>
                </div>

                <h3>Example 4: All Attributes Combined</h3>
                <div class="crc-shortcode-box">
                    <code>[conversion_rate_calculator title="My Calculator" button_text="Calculate Now" show_benchmark="true" primary_color="#10B981"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[conversion_rate_calculator title=&quot;My Calculator&quot; button_text=&quot;Calculate Now&quot; show_benchmark=&quot;true&quot; primary_color=&quot;#10B981&quot;]')">Copy</button>
                </div>
            </div>

            <!-- Features -->
            <div class="crc-admin-section">
                <h2>Calculator Features</h2>

                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Responsive Design</h4>
                        <p>Works perfectly on desktop, tablet, and mobile devices.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Performance Benchmarks</h4>
                        <p>Shows industry-standard performance indicators based on the calculated rate.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy to Clipboard</h4>
                        <p>Users can easily copy the calculated result with one click.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Input Validation</h4>
                        <p>Comprehensive validation ensures accurate calculations.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Keyboard Accessible</h4>
                        <p>Full keyboard navigation support and WCAG compliance.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Number Formatting</h4>
                        <p>Automatically formats large numbers with thousand separators.</p>
                    </div>
                </div>
            </div>

            <!-- Performance Indicators -->
            <div class="crc-admin-section">
                <h2>Performance Indicators</h2>
                <p>When <code>show_benchmark="true"</code>, the calculator displays performance indicators:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Conversion Rate</th>
                            <th>Indicator</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Below 1%</td>
                            <td>🔴 Needs Improvement</td>
                            <td>Below industry average</td>
                        </tr>
                        <tr>
                            <td>1% - 3%</td>
                            <td>🟡 Average</td>
                            <td>On par with industry standards</td>
                        </tr>
                        <tr>
                            <td>3% - 5%</td>
                            <td>🟢 Good</td>
                            <td>Performing above average</td>
                        </tr>
                        <tr>
                            <td>Above 5%</td>
                            <td>🌟 Excellent</td>
                            <td>Outstanding conversion rate</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ROI Calculator -->
            <div class="crc-admin-section">
                <h2>2. ROI Calculator</h2>

                <h3>Basic Usage</h3>
                <p>To display the ROI calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[roi_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roi_calculator]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the ROI calculator using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the calculator</td>
                            <td>"Calculate your ROI"</td>
                            <td><code>title="Marketing ROI Calculator"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text below the title</td>
                            <td>"Enter data from your analytics."</td>
                            <td><code>subtitle="Calculate your investment return"</code></td>
                        </tr>
                        <tr>
                            <td><code>currency</code></td>
                            <td>Currency symbol to display</td>
                            <td>$</td>
                            <td><code>currency="€"</code></td>
                        </tr>
                        <tr>
                            <td><code>currency_position</code></td>
                            <td>Position of currency symbol</td>
                            <td>before</td>
                            <td><code>currency_position="after"</code></td>
                        </tr>
                        <tr>
                            <td><code>cta_button</code></td>
                            <td>Show call-to-action button after results</td>
                            <td>false</td>
                            <td><code>cta_button="true"</code></td>
                        </tr>
                        <tr>
                            <td><code>cta_text</code></td>
                            <td>Text for the CTA button</td>
                            <td>"Get Started"</td>
                            <td><code>cta_text="Start Free Trial"</code></td>
                        </tr>
                        <tr>
                            <td><code>cta_url</code></td>
                            <td>URL for the CTA button</td>
                            <td>#</td>
                            <td><code>cta_url="/signup"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Custom primary color (hex format)</td>
                            <td>#6366F1</td>
                            <td><code>primary_color="#8B5CF6"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Example 1: Basic ROI Calculator</h3>
                <div class="crc-shortcode-box">
                    <code>[roi_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roi_calculator]')">Copy</button>
                </div>

                <h3>Example 2: With Custom Title and Currency</h3>
                <div class="crc-shortcode-box">
                    <code>[roi_calculator title="Marketing ROI Calculator" currency="€" currency_position="after"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roi_calculator title=&quot;Marketing ROI Calculator&quot; currency=&quot;€&quot; currency_position=&quot;after&quot;]')">Copy</button>
                </div>

                <h3>Example 3: With Call-to-Action Button</h3>
                <div class="crc-shortcode-box">
                    <code>[roi_calculator cta_button="true" cta_text="Start Free Trial" cta_url="/signup"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roi_calculator cta_button=&quot;true&quot; cta_text=&quot;Start Free Trial&quot; cta_url=&quot;/signup&quot;]')">Copy</button>
                </div>

                <h3>Example 4: All Attributes Combined</h3>
                <div class="crc-shortcode-box">
                    <code>[roi_calculator title="Calculate Your Marketing ROI" subtitle="See your potential returns" currency="£" currency_position="before" cta_button="true" cta_text="Get Started" cta_url="/contact"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roi_calculator title=&quot;Calculate Your Marketing ROI&quot; subtitle=&quot;See your potential returns&quot; currency=&quot;£&quot; currency_position=&quot;before&quot; cta_button=&quot;true&quot; cta_text=&quot;Get Started&quot; cta_url=&quot;/contact&quot;]')">Copy</button>
                </div>

                <h3>Currency Support</h3>
                <p>The ROI calculator includes a built-in currency selector with support for 30 major world currencies:</p>
                <ul style="list-style: disc; margin-left: 20px; margin-bottom: 1rem; columns: 2;">
                    <li>USD - US Dollar ($)</li>
                    <li>EUR - Euro (€)</li>
                    <li>GBP - British Pound (£)</li>
                    <li>JPY - Japanese Yen (¥)</li>
                    <li>CNY - Chinese Yuan (¥)</li>
                    <li>CHF - Swiss Franc (CHF)</li>
                    <li>CAD - Canadian Dollar (C$)</li>
                    <li>AUD - Australian Dollar (A$)</li>
                    <li>NZD - New Zealand Dollar (NZ$)</li>
                    <li>INR - Indian Rupee (₹)</li>
                    <li>SGD - Singapore Dollar (S$)</li>
                    <li>HKD - Hong Kong Dollar (HK$)</li>
                    <li>KRW - South Korean Won (₩)</li>
                    <li>BRL - Brazilian Real (R$)</li>
                    <li>MXN - Mexican Peso ($)</li>
                    <li>ZAR - South African Rand (R)</li>
                    <li>SEK - Swedish Krona (kr)</li>
                    <li>NOK - Norwegian Krone (kr)</li>
                    <li>DKK - Danish Krone (kr)</li>
                    <li>PLN - Polish Zloty (zł)</li>
                    <li>THB - Thai Baht (฿)</li>
                    <li>IDR - Indonesian Rupiah (Rp)</li>
                    <li>MYR - Malaysian Ringgit (RM)</li>
                    <li>PHP - Philippine Peso (₱)</li>
                    <li>AED - UAE Dirham (د.إ)</li>
                    <li>SAR - Saudi Riyal (﷼)</li>
                    <li>TRY - Turkish Lira (₺)</li>
                    <li>RUB - Russian Ruble (₽)</li>
                    <li>CZK - Czech Koruna (Kč)</li>
                    <li>ILS - Israeli Shekel (₪)</li>
                </ul>
                <p>The selected currency is saved in browser localStorage for user convenience.</p>

                <h3>ROI Calculator Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>30 Currency Support</h4>
                        <p>Built-in currency selector with 30 major world currencies and localStorage sync.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>3 Result Cards</h4>
                        <p>Displays new conversion rate, new monthly sales, and estimated ROI.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Animated Counters</h4>
                        <p>Smooth number counting animations when displaying results.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Color-Coded ROI</h4>
                        <p>Visual indicators based on ROI performance (negative, moderate, good, excellent).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>CTA Integration</h4>
                        <p>Optional call-to-action button after results for lead generation.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Responsive Grid</h4>
                        <p>3-column layout on desktop, stacks beautifully on mobile.</p>
                    </div>
                </div>
            </div>

            <!-- ROAS Calculator -->
            <div class="crc-admin-section">
                <h2>3. ROAS Calculator (Return on Ad Spend)</h2>

                <h3>Basic Usage</h3>
                <p>To display the ROAS calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[roas_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roas_calculator]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the ROAS calculator using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the calculator</td>
                            <td>"ROAS Calculator"</td>
                            <td><code>title="Ad Campaign ROI"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text below the title</td>
                            <td>"Calculate your Return on Ad Spend and measure campaign profitability"</td>
                            <td><code>subtitle="Measure your ad performance"</code></td>
                        </tr>
                        <tr>
                            <td><code>cta_button</code></td>
                            <td>Show call-to-action button after results</td>
                            <td>false</td>
                            <td><code>cta_button="true"</code></td>
                        </tr>
                        <tr>
                            <td><code>cta_text</code></td>
                            <td>Text for the CTA button</td>
                            <td>"Get Started"</td>
                            <td><code>cta_text="Start Free Trial"</code></td>
                        </tr>
                        <tr>
                            <td><code>cta_url</code></td>
                            <td>URL for the CTA button</td>
                            <td>#</td>
                            <td><code>cta_url="/contact"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Custom primary color (hex format)</td>
                            <td>#3B82F6</td>
                            <td><code>primary_color="#8B5CF6"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Example 1: Basic ROAS Calculator</h3>
                <div class="crc-shortcode-box">
                    <code>[roas_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roas_calculator]')">Copy</button>
                </div>

                <h3>Example 2: With Custom Title and Subtitle</h3>
                <div class="crc-shortcode-box">
                    <code>[roas_calculator title="Shopify Ad Campaign ROI" subtitle="Calculate your advertising returns"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roas_calculator title=&quot;Shopify Ad Campaign ROI&quot; subtitle=&quot;Calculate your advertising returns&quot;]')">Copy</button>
                </div>

                <h3>Example 3: With Call-to-Action Button</h3>
                <div class="crc-shortcode-box">
                    <code>[roas_calculator cta_button="true" cta_text="Optimize My Ads" cta_url="/services"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roas_calculator cta_button=&quot;true&quot; cta_text=&quot;Optimize My Ads&quot; cta_url=&quot;/services&quot;]')">Copy</button>
                </div>

                <h3>Example 4: Fully Customized for Agency</h3>
                <div class="crc-shortcode-box">
                    <code>[roas_calculator title="Client Ad Performance" subtitle="Track campaign profitability" cta_button="true" cta_text="Request Consultation" cta_url="/contact" primary_color="#8B5CF6"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[roas_calculator title=&quot;Client Ad Performance&quot; subtitle=&quot;Track campaign profitability&quot; cta_button=&quot;true&quot; cta_text=&quot;Request Consultation&quot; cta_url=&quot;/contact&quot; primary_color=&quot;#8B5CF6&quot;]')">Copy</button>
                </div>

                <h3>Currency Support</h3>
                <p>The ROAS calculator includes a built-in currency selector with support for 30 major world currencies:</p>
                <ul style="list-style: disc; margin-left: 20px; margin-bottom: 1rem; columns: 2;">
                    <li>USD - US Dollar ($)</li>
                    <li>EUR - Euro (€)</li>
                    <li>GBP - British Pound (£)</li>
                    <li>JPY - Japanese Yen (¥)</li>
                    <li>CNY - Chinese Yuan (¥)</li>
                    <li>CHF - Swiss Franc (CHF)</li>
                    <li>CAD - Canadian Dollar (C$)</li>
                    <li>AUD - Australian Dollar (A$)</li>
                    <li>NZD - New Zealand Dollar (NZ$)</li>
                    <li>INR - Indian Rupee (₹)</li>
                    <li>SGD - Singapore Dollar (S$)</li>
                    <li>HKD - Hong Kong Dollar (HK$)</li>
                    <li>KRW - South Korean Won (₩)</li>
                    <li>BRL - Brazilian Real (R$)</li>
                    <li>MXN - Mexican Peso ($)</li>
                    <li>ZAR - South African Rand (R)</li>
                    <li>SEK - Swedish Krona (kr)</li>
                    <li>NOK - Norwegian Krone (kr)</li>
                    <li>DKK - Danish Krone (kr)</li>
                    <li>PLN - Polish Zloty (zł)</li>
                    <li>THB - Thai Baht (฿)</li>
                    <li>IDR - Indonesian Rupiah (Rp)</li>
                    <li>MYR - Malaysian Ringgit (RM)</li>
                    <li>PHP - Philippine Peso (₱)</li>
                    <li>AED - UAE Dirham (د.إ)</li>
                    <li>SAR - Saudi Riyal (﷼)</li>
                    <li>TRY - Turkish Lira (₺)</li>
                    <li>RUB - Russian Ruble (₽)</li>
                    <li>CZK - Czech Koruna (Kč)</li>
                    <li>ILS - Israeli Shekel (₪)</li>
                </ul>
                <p>The selected currency is saved in browser localStorage for user convenience.</p>

                <h3>Calculation Formulas</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Formula</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Total Cost</strong></td>
                            <td>Advertising Cost + Additional Expenses</td>
                            <td>Total amount spent on the campaign</td>
                        </tr>
                        <tr>
                            <td><strong>Net Revenue</strong></td>
                            <td>Revenue - Total Cost</td>
                            <td>Actual profit from the campaign</td>
                        </tr>
                        <tr>
                            <td><strong>ROAS</strong></td>
                            <td>Revenue / Total Cost</td>
                            <td>Return on ad spend (e.g., 3.5 means $3.50 revenue per $1 spent)</td>
                        </tr>
                        <tr>
                            <td><strong>Cost Per Dollar Revenue</strong></td>
                            <td>Total Cost / Revenue</td>
                            <td>How much you spend to generate $1 in revenue</td>
                        </tr>
                        <tr>
                            <td><strong>Profit Margin</strong></td>
                            <td>(Net Revenue / Revenue) × 100</td>
                            <td>Percentage of revenue that is profit</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Performance Indicators</h3>
                <p>The calculator displays color-coded performance badges based on ROAS:</p>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Performance Level</th>
                            <th>ROAS Range</th>
                            <th>Color</th>
                            <th>Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Poor</strong></td>
                            <td>&lt; 1.0</td>
                            <td>🔴 Red</td>
                            <td>Losing money - spending more than earning</td>
                        </tr>
                        <tr>
                            <td><strong>Break-even</strong></td>
                            <td>1.0 - 1.5</td>
                            <td>🟠 Orange</td>
                            <td>Breaking even or slight profit</td>
                        </tr>
                        <tr>
                            <td><strong>Average</strong></td>
                            <td>1.5 - 2.5</td>
                            <td>🟡 Yellow</td>
                            <td>Decent performance, room for improvement</td>
                        </tr>
                        <tr>
                            <td><strong>Good</strong></td>
                            <td>2.5 - 4.0</td>
                            <td>🟢 Light Green</td>
                            <td>Good returns on advertising spend</td>
                        </tr>
                        <tr>
                            <td><strong>Excellent</strong></td>
                            <td>4.0 - 6.0</td>
                            <td>💚 Green</td>
                            <td>Excellent campaign performance</td>
                        </tr>
                        <tr>
                            <td><strong>Outstanding</strong></td>
                            <td>&gt; 6.0</td>
                            <td>🌟 Dark Green/Gold</td>
                            <td>Outstanding results with pulse animation</td>
                        </tr>
                    </tbody>
                </table>

                <h3>ROAS Calculator Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Visual ROAS Gauge</h4>
                        <p>Semi-circular gauge with animated needle showing ROAS performance at a glance.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>30 Currency Support</h4>
                        <p>Built-in currency selector with 30 major world currencies and localStorage sync.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Secondary Metrics</h4>
                        <p>Displays Net Revenue, Cost Per Dollar Revenue, and Profit Margin.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Breakdown Table</h4>
                        <p>Detailed calculation breakdown with formulas and descriptions.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>6 Performance Levels</h4>
                        <p>Color-coded badges from Poor to Outstanding with pulse animation.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy & Reset</h4>
                        <p>Copy results to clipboard and reset calculator with one click.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Optional CTA</h4>
                        <p>Configurable call-to-action button for lead generation.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Animated Counters</h4>
                        <p>Smooth number counting animations for engaging results display.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Flexible Symbol Positioning</h4>
                        <p>Automatic currency symbol positioning (before/after) based on currency standards.</p>
                    </div>
                </div>
            </div>

            <!-- CAC Calculator -->
            <div class="crc-admin-section">
                <h2>4. CAC Calculator (Customer Acquisition Cost)</h2>

                <h3>Basic Usage</h3>
                <p>To display the CAC calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[cac_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[cac_calculator]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the CAC calculator using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the calculator</td>
                            <td>"Customer Acquisition Cost Calculator"</td>
                            <td><code>title="Calculate Your CAC"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text below the title</td>
                            <td>"Calculate your CAC and measure acquisition efficiency"</td>
                            <td><code>subtitle="Measure acquisition costs"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_aov_field</code></td>
                            <td>Show Average Order Value field</td>
                            <td>true</td>
                            <td><code>show_aov_field="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_clv_field</code></td>
                            <td>Show Customer Lifetime Value field</td>
                            <td>true</td>
                            <td><code>show_clv_field="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_benchmarks</code></td>
                            <td>Show industry benchmark comparisons</td>
                            <td>true</td>
                            <td><code>show_benchmarks="true"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_tips</code></td>
                            <td>Show optimization tips section</td>
                            <td>true</td>
                            <td><code>show_tips="true"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Custom primary color (hex format)</td>
                            <td>#8B5CF6</td>
                            <td><code>primary_color="#10B981"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Example 1: Basic CAC Calculator</h3>
                <div class="crc-shortcode-box">
                    <code>[cac_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[cac_calculator]')">Copy</button>
                </div>

                <h3>Example 2: With Custom Title</h3>
                <div class="crc-shortcode-box">
                    <code>[cac_calculator title="Calculate Customer Acquisition Cost" subtitle="Measure your marketing efficiency"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[cac_calculator title=&quot;Calculate Customer Acquisition Cost&quot; subtitle=&quot;Measure your marketing efficiency&quot;]')">Copy</button>
                </div>

                <h3>Example 3: Essential Metrics Only</h3>
                <div class="crc-shortcode-box">
                    <code>[cac_calculator show_aov_field="false" show_clv_field="false" show_tips="false"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[cac_calculator show_aov_field=&quot;false&quot; show_clv_field=&quot;false&quot; show_tips=&quot;false&quot;]')">Copy</button>
                </div>

                <h3>Example 4: Full Configuration</h3>
                <div class="crc-shortcode-box">
                    <code>[cac_calculator title="CAC Analysis Tool" show_aov_field="true" show_clv_field="true" show_tips="true" primary_color="#10B981"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[cac_calculator title=&quot;CAC Analysis Tool&quot; show_aov_field=&quot;true&quot; show_clv_field=&quot;true&quot; show_tips=&quot;true&quot; primary_color=&quot;#10B981&quot;]')">Copy</button>
                </div>

                <h3>Currency Support</h3>
                <p>The CAC calculator includes a built-in currency selector with support for 30 major world currencies:</p>
                <ul style="list-style: disc; margin-left: 20px; margin-bottom: 1rem; columns: 2;">
                    <li>USD - US Dollar ($)</li>
                    <li>EUR - Euro (€)</li>
                    <li>GBP - British Pound (£)</li>
                    <li>JPY - Japanese Yen (¥)</li>
                    <li>CNY - Chinese Yuan (¥)</li>
                    <li>CHF - Swiss Franc (CHF)</li>
                    <li>CAD - Canadian Dollar (C$)</li>
                    <li>AUD - Australian Dollar (A$)</li>
                    <li>NZD - New Zealand Dollar (NZ$)</li>
                    <li>INR - Indian Rupee (₹)</li>
                    <li>SGD - Singapore Dollar (S$)</li>
                    <li>HKD - Hong Kong Dollar (HK$)</li>
                    <li>KRW - South Korean Won (₩)</li>
                    <li>BRL - Brazilian Real (R$)</li>
                    <li>MXN - Mexican Peso ($)</li>
                    <li>ZAR - South African Rand (R)</li>
                    <li>SEK - Swedish Krona (kr)</li>
                    <li>NOK - Norwegian Krone (kr)</li>
                    <li>DKK - Danish Krone (kr)</li>
                    <li>PLN - Polish Zloty (zł)</li>
                    <li>THB - Thai Baht (฿)</li>
                    <li>IDR - Indonesian Rupiah (Rp)</li>
                    <li>MYR - Malaysian Ringgit (RM)</li>
                    <li>PHP - Philippine Peso (₱)</li>
                    <li>AED - UAE Dirham (د.إ)</li>
                    <li>SAR - Saudi Riyal (﷼)</li>
                    <li>TRY - Turkish Lira (₺)</li>
                    <li>RUB - Russian Ruble (₽)</li>
                    <li>CZK - Czech Koruna (Kč)</li>
                    <li>ILS - Israeli Shekel (₪)</li>
                </ul>
                <p>The selected currency is saved in browser localStorage for user convenience.</p>

                <h3>Calculation Formulas</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Formula</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>CAC (Customer Acquisition Cost)</strong></td>
                            <td>Total Marketing Expenses / Number of Customers</td>
                            <td>Cost to acquire each new customer</td>
                        </tr>
                        <tr>
                            <td><strong>CAC as % of AOV</strong></td>
                            <td>(CAC / Average Order Value) × 100</td>
                            <td>What percentage of first purchase goes to acquisition</td>
                        </tr>
                        <tr>
                            <td><strong>CAC:LTV Ratio</strong></td>
                            <td>Customer Lifetime Value / CAC</td>
                            <td>Return on acquisition investment (displayed as 1:X)</td>
                        </tr>
                        <tr>
                            <td><strong>Orders to Payback</strong></td>
                            <td>CAC / Average Order Value</td>
                            <td>Number of purchases needed to recover CAC</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Performance Benchmarks</h3>
                <p>The calculator displays color-coded performance badges based on CAC value:</p>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>CAC Range</th>
                            <th>Performance Level</th>
                            <th>Color</th>
                            <th>Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Below $10</td>
                            <td>Very Low CAC</td>
                            <td>🟡 Yellow</td>
                            <td>May be underinvesting in acquisition</td>
                        </tr>
                        <tr>
                            <td>$10 - $30</td>
                            <td>Low CAC</td>
                            <td>🟢 Green</td>
                            <td>Efficient acquisition</td>
                        </tr>
                        <tr>
                            <td>$30 - $50</td>
                            <td>Average CAC</td>
                            <td>🔵 Blue</td>
                            <td>Typical for most industries</td>
                        </tr>
                        <tr>
                            <td>$50 - $100</td>
                            <td>Moderate CAC</td>
                            <td>🟠 Orange</td>
                            <td>Consider optimization</td>
                        </tr>
                        <tr>
                            <td>$100 - $200</td>
                            <td>High CAC</td>
                            <td>🟠 Orange</td>
                            <td>Ensure LTV justifies cost</td>
                        </tr>
                        <tr>
                            <td>Above $200</td>
                            <td>Very High CAC</td>
                            <td>🔴 Red</td>
                            <td>Review acquisition strategy</td>
                        </tr>
                    </tbody>
                </table>
                <p><em>Note: Benchmarks vary by industry. B2B and SaaS typically have higher CAC than e-commerce.</em></p>

                <h3>Secondary Metrics Thresholds</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Excellent</th>
                            <th>Good</th>
                            <th>Average</th>
                            <th>Poor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>CAC as % of AOV</strong></td>
                            <td>&lt; 20%</td>
                            <td>20-30%</td>
                            <td>30-50%</td>
                            <td>&gt; 50%</td>
                        </tr>
                        <tr>
                            <td><strong>CAC:LTV Ratio</strong></td>
                            <td>1:5 or better</td>
                            <td>1:3 to 1:5</td>
                            <td>1:2 to 1:3</td>
                            <td>&lt; 1:2</td>
                        </tr>
                    </tbody>
                </table>

                <h3>CAC Calculator Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>30 Currency Support</h4>
                        <p>Built-in currency selector with 30 major world currencies and localStorage sync.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Performance Benchmarks</h4>
                        <p>6-tier CAC performance rating from Very Low to Very High with context.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Optional Advanced Metrics</h4>
                        <p>CAC as % of AOV, CAC:LTV ratio, and Orders to Payback calculations.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Visual Progress Bars</h4>
                        <p>Animated color-coded bars showing performance for each metric.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Optimization Tips</h4>
                        <p>Actionable suggestions to reduce CAC and improve acquisition efficiency.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Animated Counters</h4>
                        <p>Smooth number counting animations for engaging results display.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy & Reset</h4>
                        <p>Copy results to clipboard and reset calculator with one click.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Configurable Display</h4>
                        <p>Show/hide AOV, CLV, benchmarks, and tips based on your needs.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Industry Context</h4>
                        <p>Benchmarks adjusted for different business models and industries.</p>
                    </div>
                </div>
            </div>

            <!-- CLV Calculator Documentation -->
            <div class="crc-admin-section">
                <h2>5. Customer Lifetime Value (CLV) Calculator</h2>
                <p>Calculate the total revenue expected from each customer over their entire relationship with your business.</p>

                <h3>Basic Usage</h3>
                <div class="crc-shortcode-box">
                    <code>[clv_calculator]</code>
                    <button onclick="crcCopyShortcode(this, '[clv_calculator]')" class="crc-copy-btn">Copy</button>
                </div>

                <h3>Shortcode Attributes</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Default</th>
                            <th>Description</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>"Customer Lifetime Value Calculator"</td>
                            <td>Main heading text</td>
                            <td>Any text</td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>"Calculate your CLV effortlessly."</td>
                            <td>Subtitle description</td>
                            <td>Any text</td>
                        </tr>
                        <tr>
                            <td><code>default_currency</code></td>
                            <td>"USD"</td>
                            <td>Initial currency selection</td>
                            <td>USD, EUR, GBP, JPY, etc. (30 currencies)</td>
                        </tr>
                        <tr>
                            <td><code>show_profit_margin</code></td>
                            <td>"true"</td>
                            <td>Show profit margin input field</td>
                            <td>true, false</td>
                        </tr>
                        <tr>
                            <td><code>show_cac_field</code></td>
                            <td>"true"</td>
                            <td>Show CAC input field</td>
                            <td>true, false</td>
                        </tr>
                        <tr>
                            <td><code>show_annual_value</code></td>
                            <td>"true"</td>
                            <td>Show annual customer value metric</td>
                            <td>true, false</td>
                        </tr>
                        <tr>
                            <td><code>show_tips</code></td>
                            <td>"true"</td>
                            <td>Show CLV improvement tips</td>
                            <td>true, false</td>
                        </tr>
                        <tr>
                            <td><code>default_lifespan</code></td>
                            <td>""</td>
                            <td>Pre-fill customer lifespan value</td>
                            <td>Any positive number</td>
                        </tr>
                        <tr>
                            <td><code>default_frequency</code></td>
                            <td>""</td>
                            <td>Pre-fill purchase frequency value</td>
                            <td>Any positive number</td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>"#059669"</td>
                            <td>Primary brand color (emerald green)</td>
                            <td>Any hex color</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Examples</h3>

                <h4>Example 1: Basic CLV Calculator</h4>
                <div class="crc-shortcode-box">
                    <code>[clv_calculator]</code>
                    <button onclick="crcCopyShortcode(this, '[clv_calculator]')" class="crc-copy-btn">Copy</button>
                </div>

                <h4>Example 2: E-commerce CLV Calculator</h4>
                <div class="crc-shortcode-box">
                    <code>[clv_calculator title="Calculate Customer Value" default_currency="EUR" show_profit_margin="true" show_cac_field="true"]</code>
                    <button onclick="crcCopyShortcode(this, '[clv_calculator title=&quot;Calculate Customer Value&quot; default_currency=&quot;EUR&quot; show_profit_margin=&quot;true&quot; show_cac_field=&quot;true&quot;]')" class="crc-copy-btn">Copy</button>
                </div>

                <h4>Example 3: Simple CLV Calculator (No Advanced Metrics)</h4>
                <div class="crc-shortcode-box">
                    <code>[clv_calculator show_profit_margin="false" show_cac_field="false" show_tips="false"]</code>
                    <button onclick="crcCopyShortcode(this, '[clv_calculator show_profit_margin=&quot;false&quot; show_cac_field=&quot;false&quot; show_tips=&quot;false&quot;]')" class="crc-copy-btn">Copy</button>
                </div>

                <h4>Example 4: SaaS CLV Calculator with Defaults</h4>
                <div class="crc-shortcode-box">
                    <code>[clv_calculator title="SaaS Customer Value Calculator" default_frequency="12" default_lifespan="3" primary_color="#6366F1"]</code>
                    <button onclick="crcCopyShortcode(this, '[clv_calculator title=&quot;SaaS Customer Value Calculator&quot; default_frequency=&quot;12&quot; default_lifespan=&quot;3&quot; primary_color=&quot;#6366F1&quot;]')" class="crc-copy-btn">Copy</button>
                </div>

                <h3>Supported Currencies (30)</h3>
                <div class="crc-currency-grid">
                    <span>🇺🇸 USD ($)</span>
                    <span>🇪🇺 EUR (€)</span>
                    <span>🇬🇧 GBP (£)</span>
                    <span>🇯🇵 JPY (¥)</span>
                    <span>🇨🇳 CNY (¥)</span>
                    <span>🇨🇭 CHF</span>
                    <span>🇨🇦 CAD (C$)</span>
                    <span>🇦🇺 AUD (A$)</span>
                    <span>🇳🇿 NZD (NZ$)</span>
                    <span>🇮🇳 INR (₹)</span>
                    <span>🇸🇬 SGD (S$)</span>
                    <span>🇭🇰 HKD (HK$)</span>
                    <span>🇰🇷 KRW (₩)</span>
                    <span>🇧🇷 BRL (R$)</span>
                    <span>🇲🇽 MXN ($)</span>
                    <span>🇿🇦 ZAR (R)</span>
                    <span>🇸🇪 SEK (kr)</span>
                    <span>🇳🇴 NOK (kr)</span>
                    <span>🇩🇰 DKK (kr)</span>
                    <span>🇵🇱 PLN (zł)</span>
                    <span>🇹🇭 THB (฿)</span>
                    <span>🇮🇩 IDR (Rp)</span>
                    <span>🇲🇾 MYR (RM)</span>
                    <span>🇵🇭 PHP (₱)</span>
                    <span>🇦🇪 AED (د.إ)</span>
                    <span>🇸🇦 SAR (﷼)</span>
                    <span>🇹🇷 TRY (₺)</span>
                    <span>🇷🇺 RUB (₽)</span>
                    <span>🇨🇿 CZK (Kč)</span>
                    <span>🇮🇱 ILS (₪)</span>
                </div>

                <h3>Calculation Formulas</h3>
                <table class="crc-formula-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Formula</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Customer Lifetime Value (CLV)</td>
                            <td>Average Purchase Value × Purchase Frequency × Customer Lifespan</td>
                        </tr>
                        <tr>
                            <td>Annual Customer Value</td>
                            <td>Average Purchase Value × Purchase Frequency</td>
                        </tr>
                        <tr>
                            <td>Total Lifetime Orders</td>
                            <td>Purchase Frequency × Customer Lifespan</td>
                        </tr>
                        <tr>
                            <td>Profit-Based CLV</td>
                            <td>CLV × (Profit Margin / 100)</td>
                        </tr>
                        <tr>
                            <td>CLV:CAC Ratio</td>
                            <td>CLV / CAC</td>
                        </tr>
                        <tr>
                            <td>Net Customer Value</td>
                            <td>CLV - CAC</td>
                        </tr>
                        <tr>
                            <td>CAC Payback Period</td>
                            <td>(CAC / Annual Customer Value) × 12 months</td>
                        </tr>
                    </tbody>
                </table>

                <h3>CLV:CAC Ratio Benchmarks</h3>
                <table class="crc-benchmark-table">
                    <thead>
                        <tr>
                            <th>Ratio</th>
                            <th>Performance</th>
                            <th>Color</th>
                            <th>Meaning</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Below 1:1</td>
                            <td>Critical</td>
                            <td>🔴 Red</td>
                            <td>You're losing money on each customer</td>
                        </tr>
                        <tr>
                            <td>1:1 to 2:1</td>
                            <td>Poor</td>
                            <td>🟠 Orange</td>
                            <td>Barely profitable</td>
                        </tr>
                        <tr>
                            <td>2:1 to 3:1</td>
                            <td>Average</td>
                            <td>🟡 Yellow</td>
                            <td>Industry standard minimum</td>
                        </tr>
                        <tr>
                            <td>3:1 to 5:1</td>
                            <td>Good</td>
                            <td>🟢 Light Green</td>
                            <td>Healthy customer economics</td>
                        </tr>
                        <tr>
                            <td>Above 5:1</td>
                            <td>Excellent</td>
                            <td>🟢 Green</td>
                            <td>Strong unit economics</td>
                        </tr>
                    </tbody>
                </table>
                <p><em>Note: A 3:1 ratio is generally considered the minimum for sustainable growth. SaaS companies typically target 5:1 or higher.</em></p>

                <h3>CLV Calculator Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>30 Currency Support</h4>
                        <p>Built-in currency selector with 30 major world currencies and localStorage sync.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>CLV:CAC Ratio Health</h4>
                        <p>Visual gauge showing ratio health with 5 performance tiers from Critical to Excellent.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Profit-Based CLV</h4>
                        <p>Optional profit margin input to calculate actual profit per customer over lifetime.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>What-If Simulator</h4>
                        <p>See how improving each metric (purchase value, frequency, lifespan) affects CLV.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>CAC Payback Period</h4>
                        <p>Calculate how long it takes to recover customer acquisition costs.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Calculation Breakdown</h4>
                        <p>Step-by-step formula display showing how CLV is calculated.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Improvement Tips</h4>
                        <p>Actionable suggestions to increase CLV through multiple strategies.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Animated Counters</h4>
                        <p>Smooth number counting animations for engaging results display.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy & Reset</h4>
                        <p>Copy all results to clipboard and reset calculator with one click.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Configurable Display</h4>
                        <p>Show/hide profit margin, CAC field, annual value, and tips based on your needs.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Pre-filled Values</h4>
                        <p>Set default frequency and lifespan values for your specific business model.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Net Customer Value</h4>
                        <p>Automatically calculates net value per customer (CLV - CAC) when CAC is provided.</p>
                    </div>
                </div>
            </div>

            <!-- SKU Generator Documentation -->
            <div class="crc-admin-section">
                <h2>6. SKU Generator</h2>
                <p>Generate unique SKU (Stock Keeping Unit) codes for your products instantly with multiple generation methods.</p>

                <h3>Basic Usage</h3>
                <div class="crc-shortcode-box">
                    <code>[sku_generator]</code>
                    <button onclick="crcCopyShortcode(this, '[sku_generator]')" class="crc-copy-btn">Copy</button>
                </div>

                <h3>Shortcode Attributes</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Default</th>
                            <th>Description</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>"SKU Generator"</td>
                            <td>Main heading text</td>
                            <td>Any text</td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>"Generate unique SKUs for your products instantly."</td>
                            <td>Subtitle description</td>
                            <td>Any text</td>
                        </tr>
                        <tr>
                            <td><code>max_skus</code></td>
                            <td>"1000"</td>
                            <td>Maximum SKUs allowed to generate</td>
                            <td>1-10000</td>
                        </tr>
                        <tr>
                            <td><code>default_length</code></td>
                            <td>"8"</td>
                            <td>Default SKU code length</td>
                            <td>1-36</td>
                        </tr>
                        <tr>
                            <td><code>default_type</code></td>
                            <td>"random_numbers"</td>
                            <td>Default character type</td>
                            <td>sequential, random_numbers, letters, alphanumeric</td>
                        </tr>
                        <tr>
                            <td><code>show_export</code></td>
                            <td>"true"</td>
                            <td>Show CSV/TXT export buttons</td>
                            <td>true, false</td>
                        </tr>
                        <tr>
                            <td><code>show_preview</code></td>
                            <td>"true"</td>
                            <td>Show live SKU preview</td>
                            <td>true, false</td>
                        </tr>
                        <tr>
                            <td><code>default_prefix</code></td>
                            <td>""</td>
                            <td>Pre-filled prefix value</td>
                            <td>Any text (max 10 chars)</td>
                        </tr>
                        <tr>
                            <td><code>default_suffix</code></td>
                            <td>""</td>
                            <td>Pre-filled suffix value</td>
                            <td>Any text (max 10 chars)</td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>"#2563EB"</td>
                            <td>Primary brand color (blue)</td>
                            <td>Any hex color</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Examples</h3>

                <h4>Example 1: Basic SKU Generator</h4>
                <div class="crc-shortcode-box">
                    <code>[sku_generator]</code>
                    <button onclick="crcCopyShortcode(this, '[sku_generator]')" class="crc-copy-btn">Copy</button>
                </div>

                <h4>Example 2: Product SKU Generator with Prefix</h4>
                <div class="crc-shortcode-box">
                    <code>[sku_generator title="Product SKU Generator" default_prefix="PROD" default_length="10"]</code>
                    <button onclick="crcCopyShortcode(this, '[sku_generator title=&quot;Product SKU Generator&quot; default_prefix=&quot;PROD&quot; default_length=&quot;10&quot;]')" class="crc-copy-btn">Copy</button>
                </div>

                <h4>Example 3: Sequential SKU Generator</h4>
                <div class="crc-shortcode-box">
                    <code>[sku_generator default_type="sequential" default_length="6" max_skus="500"]</code>
                    <button onclick="crcCopyShortcode(this, '[sku_generator default_type=&quot;sequential&quot; default_length=&quot;6&quot; max_skus=&quot;500&quot;]')" class="crc-copy-btn">Copy</button>
                </div>

                <h4>Example 4: Alphanumeric SKU Generator with Prefix and Suffix</h4>
                <div class="crc-shortcode-box">
                    <code>[sku_generator default_type="alphanumeric" default_prefix="SHO" default_suffix="2024"]</code>
                    <button onclick="crcCopyShortcode(this, '[sku_generator default_type=&quot;alphanumeric&quot; default_prefix=&quot;SHO&quot; default_suffix=&quot;2024&quot;]')" class="crc-copy-btn">Copy</button>
                </div>

                <h3>Character Type Options</h3>
                <table class="crc-formula-table">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Description</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sequential Numbers</td>
                            <td>sequential</td>
                            <td>Sequential numbers with zero padding</td>
                            <td>00001, 00002, 00003</td>
                        </tr>
                        <tr>
                            <td>Random Numbers</td>
                            <td>random_numbers</td>
                            <td>Random digits (0-9)</td>
                            <td>847291, 103847, 928371</td>
                        </tr>
                        <tr>
                            <td>Letters Only</td>
                            <td>letters</td>
                            <td>Random uppercase letters (A-Z)</td>
                            <td>KXMWPQ, BNTRLF, HGJDKS</td>
                        </tr>
                        <tr>
                            <td>Alphanumeric</td>
                            <td>alphanumeric</td>
                            <td>Mix of uppercase letters and numbers</td>
                            <td>A7K9M2, B3X8P1, C4W2R9</td>
                        </tr>
                    </tbody>
                </table>

                <h3>SKU Assembly Format</h3>
                <p><strong>Final SKU Format:</strong> <code>[PREFIX][SEPARATOR][CODE][SEPARATOR][SUFFIX]</code></p>
                <p><strong>Example:</strong> <code>PROD-A7K9M2X3-2024</code></p>
                <ul>
                    <li><strong>Prefix:</strong> PROD</li>
                    <li><strong>Separator:</strong> - (hyphen)</li>
                    <li><strong>Code:</strong> A7K9M2X3 (8 alphanumeric characters)</li>
                    <li><strong>Suffix:</strong> 2024</li>
                </ul>

                <h3>Confusing Character Exclusion</h3>
                <p>When enabled, the following similar-looking characters are excluded to prevent mix-ups:</p>
                <table class="crc-benchmark-table">
                    <thead>
                        <tr>
                            <th>Excluded Characters</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>0 (zero) and O (letter O)</td>
                            <td>Look identical in many fonts</td>
                        </tr>
                        <tr>
                            <td>1 (one), I (letter I), and l (lowercase L)</td>
                            <td>Look very similar in many fonts</td>
                        </tr>
                    </tbody>
                </table>
                <p><em>Available character sets when exclusion is enabled:</em></p>
                <ul>
                    <li><strong>Numbers:</strong> 2, 3, 4, 5, 6, 7, 8, 9</li>
                    <li><strong>Letters:</strong> A, B, C, D, E, F, G, H, J, K, L, M, N, P, Q, R, S, T, U, V, W, X, Y, Z</li>
                </ul>

                <h3>SKU Generator Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Multiple Generation Methods</h4>
                        <p>Sequential numbers, random numbers, letters only, or alphanumeric combinations.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Customizable Prefix & Suffix</h4>
                        <p>Add brand identifiers, categories, or year codes to your SKUs.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Flexible Separators</h4>
                        <p>Choose from hyphen, underscore, dot, or no separator.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Adjustable Length</h4>
                        <p>Generate SKUs from 1 to 36 characters long for the code portion.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Bulk Generation</h4>
                        <p>Generate up to 1000 unique SKUs at once (configurable up to 10,000).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Live Preview</h4>
                        <p>See real-time preview of SKU format as you configure options.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Duplicate Prevention</h4>
                        <p>Ensures all generated SKUs are unique within each batch.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Confusing Character Filter</h4>
                        <p>Optional exclusion of similar-looking characters (0, O, 1, I, l).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy Individual SKUs</h4>
                        <p>Click to copy any single SKU with visual feedback.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy All SKUs</h4>
                        <p>One-click copy all generated SKUs to clipboard.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Export to CSV</h4>
                        <p>Download generated SKUs as CSV file for spreadsheet import.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Export to TXT</h4>
                        <p>Download generated SKUs as plain text file.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Monospace Display</h4>
                        <p>Easy-to-read monospace font for SKU display.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Alternating Row Colors</h4>
                        <p>Zebra striping for easier scanning of large SKU lists.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Sequential Start Number</h4>
                        <p>Begin sequential generation from any number (e.g., 1001, 5000).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Toast Notifications</h4>
                        <p>Visual feedback when copying or downloading SKUs.</p>
                    </div>
                </div>

                <h3>Use Cases</h3>
                <ul>
                    <li><strong>E-commerce Products:</strong> Generate unique identifiers for inventory management</li>
                    <li><strong>Warehouse Management:</strong> Create location-based or category-based SKUs</li>
                    <li><strong>Manufacturing:</strong> Sequential part numbers with prefixes for different product lines</li>
                    <li><strong>Retail:</strong> Brand and year-specific product codes</li>
                    <li><strong>Services:</strong> Service package or subscription identifiers</li>
                </ul>
            </div>

            <!-- UTM Builder Documentation -->
            <div class="crc-admin-section">
                <h2>7. UTM Builder</h2>

                <h3>Basic Usage</h3>
                <p>To display the UTM Builder tool, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[utm_builder]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[utm_builder]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the UTM Builder using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the builder</td>
                            <td>"UTM Builder"</td>
                            <td><code>title="Campaign URL Builder"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text with description</td>
                            <td>"Build UTM tracking links..."</td>
                            <td><code>subtitle="Create trackable URLs"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_term</code></td>
                            <td>Show/hide Campaign Term field</td>
                            <td>true</td>
                            <td><code>show_term="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_content</code></td>
                            <td>Show/hide Campaign Content field</td>
                            <td>true</td>
                            <td><code>show_content="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_id</code></td>
                            <td>Show/hide Campaign ID field</td>
                            <td>false</td>
                            <td><code>show_id="true"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_qr</code></td>
                            <td>Show/hide QR code generation</td>
                            <td>true</td>
                            <td><code>show_qr="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>show_breakdown</code></td>
                            <td>Show/hide URL breakdown table</td>
                            <td>true</td>
                            <td><code>show_breakdown="false"</code></td>
                        </tr>
                        <tr>
                            <td><code>default_url</code></td>
                            <td>Pre-fill the website URL field</td>
                            <td>""</td>
                            <td><code>default_url="https://example.com"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Custom button color (hex format)</td>
                            <td>#7C3AED</td>
                            <td><code>primary_color="#9333EA"</code></td>
                        </tr>
                        <tr>
                            <td><code>remember_values</code></td>
                            <td>Remember user inputs in localStorage</td>
                            <td>true</td>
                            <td><code>remember_values="false"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Example 1: Basic UTM Builder</h3>
                <div class="crc-shortcode-box">
                    <code>[utm_builder]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[utm_builder]')">Copy</button>
                </div>

                <h3>Example 2: Simplified Builder (Required Fields Only)</h3>
                <div class="crc-shortcode-box">
                    <code>[utm_builder show_term="false" show_content="false" show_qr="false"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[utm_builder show_term=&quot;false&quot; show_content=&quot;false&quot; show_qr=&quot;false&quot;]')">Copy</button>
                </div>

                <h3>Example 3: Marketing Agency Setup</h3>
                <div class="crc-shortcode-box">
                    <code>[utm_builder title="Client Campaign Builder" show_id="true" default_url="https://client-website.com"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[utm_builder title=&quot;Client Campaign Builder&quot; show_id=&quot;true&quot; default_url=&quot;https://client-website.com&quot;]')">Copy</button>
                </div>

                <h3>Example 4: Custom Branded</h3>
                <div class="crc-shortcode-box">
                    <code>[utm_builder title="Create Tracking Link" subtitle="Build your campaign URLs" primary_color="#9333EA"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[utm_builder title=&quot;Create Tracking Link&quot; subtitle=&quot;Build your campaign URLs&quot; primary_color=&quot;#9333EA&quot;]')">Copy</button>
                </div>

                <h3>Campaign Medium Options</h3>
                <p>The builder includes 16 pre-configured medium options:</p>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Medium</th>
                            <th>Description</th>
                            <th>Use Case</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>cpc</code></td>
                            <td>Cost per click</td>
                            <td>Paid search campaigns (Google Ads, Bing Ads)</td>
                        </tr>
                        <tr>
                            <td><code>ppc</code></td>
                            <td>Pay per click</td>
                            <td>General paid advertising campaigns</td>
                        </tr>
                        <tr>
                            <td><code>social</code></td>
                            <td>Social media</td>
                            <td>Organic social posts (Facebook, Instagram, Twitter)</td>
                        </tr>
                        <tr>
                            <td><code>social-paid</code></td>
                            <td>Paid social</td>
                            <td>Paid social media advertising</td>
                        </tr>
                        <tr>
                            <td><code>email</code></td>
                            <td>Email marketing</td>
                            <td>Email newsletters and campaigns</td>
                        </tr>
                        <tr>
                            <td><code>display</code></td>
                            <td>Display advertising</td>
                            <td>Banner ads, Google Display Network</td>
                        </tr>
                        <tr>
                            <td><code>affiliate</code></td>
                            <td>Affiliate marketing</td>
                            <td>Affiliate partner links</td>
                        </tr>
                        <tr>
                            <td><code>referral</code></td>
                            <td>Referral traffic</td>
                            <td>Referral programs and partner sites</td>
                        </tr>
                        <tr>
                            <td><code>organic</code></td>
                            <td>Organic search</td>
                            <td>Natural search engine results</td>
                        </tr>
                        <tr>
                            <td><code>video</code></td>
                            <td>Video advertising</td>
                            <td>YouTube ads, video platforms</td>
                        </tr>
                        <tr>
                            <td><code>podcast</code></td>
                            <td>Podcast advertising</td>
                            <td>Podcast sponsorships and mentions</td>
                        </tr>
                        <tr>
                            <td><code>sms</code></td>
                            <td>SMS marketing</td>
                            <td>Text message campaigns</td>
                        </tr>
                        <tr>
                            <td><code>influencer</code></td>
                            <td>Influencer marketing</td>
                            <td>Influencer partnerships and posts</td>
                        </tr>
                        <tr>
                            <td><code>pr</code></td>
                            <td>Public relations</td>
                            <td>Press releases and media coverage</td>
                        </tr>
                        <tr>
                            <td><code>retargeting</code></td>
                            <td>Retargeting campaigns</td>
                            <td>Remarketing and retargeting ads</td>
                        </tr>
                        <tr>
                            <td><code>qr</code></td>
                            <td>QR code</td>
                            <td>QR code campaigns (print, packaging)</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Campaign Source Suggestions</h3>
                <p>The builder provides autocomplete suggestions for common sources:</p>
                <ul>
                    <li><strong>facebook</strong> - Facebook organic or ads</li>
                    <li><strong>instagram</strong> - Instagram posts or ads</li>
                    <li><strong>google</strong> - Google Ads or organic</li>
                    <li><strong>twitter</strong> - Twitter/X posts or ads</li>
                    <li><strong>linkedin</strong> - LinkedIn posts or ads</li>
                    <li><strong>youtube</strong> - YouTube videos or ads</li>
                    <li><strong>tiktok</strong> - TikTok content or ads</li>
                    <li><strong>pinterest</strong> - Pinterest pins or ads</li>
                    <li><strong>newsletter</strong> - Email newsletter</li>
                    <li><strong>email</strong> - Email campaigns</li>
                    <li><strong>bing</strong> - Bing Ads</li>
                    <li><strong>reddit</strong> - Reddit posts or ads</li>
                </ul>

                <h3>UTM Parameters Explained</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Required</th>
                            <th>Description</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>utm_source</code></td>
                            <td>✓ Yes</td>
                            <td>Identifies which site sent the traffic</td>
                            <td>facebook, google, newsletter</td>
                        </tr>
                        <tr>
                            <td><code>utm_medium</code></td>
                            <td>✓ Yes</td>
                            <td>Identifies what type of link was used</td>
                            <td>cpc, social, email</td>
                        </tr>
                        <tr>
                            <td><code>utm_campaign</code></td>
                            <td>✓ Yes</td>
                            <td>Identifies the specific campaign</td>
                            <td>summer_sale, product_launch</td>
                        </tr>
                        <tr>
                            <td><code>utm_term</code></td>
                            <td>Optional</td>
                            <td>Identifies paid search keywords</td>
                            <td>running+shoes, blue+widgets</td>
                        </tr>
                        <tr>
                            <td><code>utm_content</code></td>
                            <td>Optional</td>
                            <td>Differentiates similar content or links</td>
                            <td>logolink, textlink, banner_ad</td>
                        </tr>
                        <tr>
                            <td><code>utm_id</code></td>
                            <td>Optional</td>
                            <td>Internal campaign ID for tracking systems</td>
                            <td>camp_12345, promo_2024_q1</td>
                        </tr>
                    </tbody>
                </table>

                <h3>UTM Builder Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Live URL Preview</h4>
                        <p>See your UTM URL update in real-time as you type each parameter.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Smart URL Formatting</h4>
                        <p>Auto-lowercase source/medium, converts spaces to underscores in campaign names.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>URL Validation</h4>
                        <p>Validates website URLs and automatically adds protocol (https://) if missing.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Required Field Indicators</h4>
                        <p>Visual indicators show which fields are required vs optional.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>16 Medium Options</h4>
                        <p>Pre-configured dropdown with all standard campaign mediums (cpc, social, email, etc.).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Source Autocomplete</h4>
                        <p>Datalist suggestions for 12 popular traffic sources (Facebook, Google, Instagram, etc.).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>URL Breakdown Table</h4>
                        <p>Displays all UTM parameters in a table with descriptions (optional, configurable).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>QR Code Generation</h4>
                        <p>Automatically generates QR code for the UTM URL using QR Server API.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>QR Code Download</h4>
                        <p>Download generated QR code as PNG image for print materials.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Character Count</h4>
                        <p>Shows final URL length with warning if exceeding 2048 characters.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Copy to Clipboard</h4>
                        <p>One-click copy with visual feedback and toast notification.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>LocalStorage Memory</h4>
                        <p>Remembers your inputs for next visit (optional, configurable).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Form Validation</h4>
                        <p>Inline error messages for required fields with clear guidance.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Reset Functionality</h4>
                        <p>Clear all inputs and start fresh with one click.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Emoji Icons</h4>
                        <p>Visual field identifiers using emoji icons for better UX.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Existing Query Params</h4>
                        <p>Preserves existing URL parameters while adding UTM parameters.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Keyboard Support</h4>
                        <p>Press Enter in any field to generate URL instantly.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Monospace Display</h4>
                        <p>URLs displayed in monospace font for easier reading and validation.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Purple Theme</h4>
                        <p>Beautiful violet/purple color scheme (#7C3AED) matching marketing tools aesthetic.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Responsive Design</h4>
                        <p>Fully responsive layout optimized for mobile, tablet, and desktop.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Toast Notifications</h4>
                        <p>Visual feedback for actions (copy, errors) with animated toast messages.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Loading States</h4>
                        <p>Button loading animations during URL generation for better UX.</p>
                    </div>
                </div>

                <h3>Use Cases</h3>
                <ul>
                    <li><strong>Marketing Agencies:</strong> Create trackable campaign URLs for multiple clients</li>
                    <li><strong>Social Media Marketing:</strong> Track performance of posts across different platforms</li>
                    <li><strong>Email Campaigns:</strong> Measure click-through rates from email newsletters</li>
                    <li><strong>Paid Advertising:</strong> Monitor ROI from Google Ads, Facebook Ads, etc.</li>
                    <li><strong>Influencer Marketing:</strong> Track traffic from different influencer partnerships</li>
                    <li><strong>Content Marketing:</strong> Measure effectiveness of guest posts and syndicated content</li>
                    <li><strong>Affiliate Programs:</strong> Create unique tracking links for each affiliate partner</li>
                    <li><strong>Print Materials:</strong> Generate QR codes for brochures, business cards, and posters</li>
                    <li><strong>A/B Testing:</strong> Compare performance of different ad variations (utm_content)</li>
                    <li><strong>Multi-Channel Attribution:</strong> Understand customer journey across all touchpoints</li>
                </ul>

                <h3>Best Practices</h3>
                <ul>
                    <li><strong>Be Consistent:</strong> Use standardized naming conventions across all campaigns</li>
                    <li><strong>Use Lowercase:</strong> The builder automatically converts to lowercase for consistency</li>
                    <li><strong>Underscores Over Spaces:</strong> Campaign names auto-convert spaces to underscores</li>
                    <li><strong>Be Specific:</strong> Use descriptive campaign names (e.g., "summer_sale_2024" not "sale")</li>
                    <li><strong>Track Everything:</strong> Add UTM parameters to all external marketing links</li>
                    <li><strong>Keep URLs Short:</strong> Monitor the character count to avoid overly long URLs</li>
                    <li><strong>Test Before Launch:</strong> Always test UTM links before sharing publicly</li>
                    <li><strong>Document Campaigns:</strong> Keep a spreadsheet of all UTM campaigns for reference</li>
                </ul>
            </div>

            <!-- Gross Profit Calculator Documentation -->
            <div class="crc-admin-section">
                <h2>8. Gross Profit Calculator</h2>

                <h3>Basic Usage</h3>
                <p>To display the Gross Profit Calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[gross_profit_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[gross_profit_calculator]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the Gross Profit Calculator using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the calculator</td>
                            <td>"Gross Profit Calculator"</td>
                            <td><code>title="Calculate Your Profit"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text with description</td>
                            <td>"Calculate your gross profit and margin in real-time."</td>
                            <td><code>subtitle="Analyze profitability"</code></td>
                        </tr>
                        <tr>
                            <td><code>currency</code></td>
                            <td>Currency symbol to display</td>
                            <td>$</td>
                            <td><code>currency="€"</code></td>
                        </tr>
                        <tr>
                            <td><code>max_items</code></td>
                            <td>Maximum number of items for slider</td>
                            <td>1000</td>
                            <td><code>max_items="5000"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Primary color for margins (hex format)</td>
                            <td>#4F46E5</td>
                            <td><code>primary_color="#7C3AED"</code></td>
                        </tr>
                        <tr>
                            <td><code>profit_color</code></td>
                            <td>Color for profit display (hex format)</td>
                            <td>#10B981</td>
                            <td><code>profit_color="#059669"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Examples</h3>

                <h3>Example 1: Basic Gross Profit Calculator</h3>
                <div class="crc-shortcode-box">
                    <code>[gross_profit_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[gross_profit_calculator]')">Copy</button>
                </div>

                <h3>Example 2: Custom Title and Currency</h3>
                <div class="crc-shortcode-box">
                    <code>[gross_profit_calculator title="Product Profitability Analysis" currency="€"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[gross_profit_calculator title=&quot;Product Profitability Analysis&quot; currency=&quot;€&quot;]')">Copy</button>
                </div>

                <h3>Example 3: High Volume Sales</h3>
                <div class="crc-shortcode-box">
                    <code>[gross_profit_calculator max_items="10000" title="High Volume Calculator"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[gross_profit_calculator max_items=&quot;10000&quot; title=&quot;High Volume Calculator&quot;]')">Copy</button>
                </div>

                <h3>Example 4: Custom Colors</h3>
                <div class="crc-shortcode-box">
                    <code>[gross_profit_calculator primary_color="#7C3AED" profit_color="#059669"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[gross_profit_calculator primary_color=&quot;#7C3AED&quot; profit_color=&quot;#059669&quot;]')">Copy</button>
                </div>

                <h3>What It Calculates</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Formula</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Gross Profit</strong></td>
                            <td>(Sales Price - COGS) × Items Sold</td>
                            <td>Total profit before operating expenses</td>
                        </tr>
                        <tr>
                            <td><strong>Gross Profit Margin</strong></td>
                            <td>((Sales Price - COGS) / Sales Price) × 100</td>
                            <td>Profitability as a percentage of sales</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Key Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Real-Time Calculations</h4>
                        <p>Results update instantly as you type - no submit button needed.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Synced Slider & Input</h4>
                        <p>Range slider and number input stay perfectly synchronized.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Currency Formatting</h4>
                        <p>Automatic currency formatting with thousand separators.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Visual Margin Indicator</h4>
                        <p>Color-coded progress bar shows margin quality (Low, Fair, Good, Excellent).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Negative Value Handling</h4>
                        <p>Automatically detects losses and displays them in red with warning.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Mobile Responsive</h4>
                        <p>Optimized for all screen sizes - mobile, tablet, and desktop.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Custom Branding</h4>
                        <p>Customize colors to match your brand identity.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Educational Info</h4>
                        <p>Built-in guide explains margin benchmarks and what they mean.</p>
                    </div>
                </div>

                <h3>Margin Interpretation Guide</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Margin Range</th>
                            <th>Rating</th>
                            <th>Indicator Color</th>
                            <th>Recommendation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&lt; 0%</td>
                            <td>Loss</td>
                            <td style="color: #EF4444;">🔴 Red</td>
                            <td>Review your pricing immediately</td>
                        </tr>
                        <tr>
                            <td>0-20%</td>
                            <td>Low Margin</td>
                            <td style="color: #EF4444;">🟠 Orange</td>
                            <td>Consider cost optimization</td>
                        </tr>
                        <tr>
                            <td>20-30%</td>
                            <td>Fair Margin</td>
                            <td style="color: #F59E0B;">🟡 Yellow</td>
                            <td>Room for improvement</td>
                        </tr>
                        <tr>
                            <td>30-50%</td>
                            <td>Good Margin</td>
                            <td style="color: #10B981;">🟢 Green</td>
                            <td>Strong profitability</td>
                        </tr>
                        <tr>
                            <td>&gt; 50%</td>
                            <td>Excellent Margin</td>
                            <td style="color: #059669;">🟢 Dark Green</td>
                            <td>Outstanding performance!</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Use Cases</h3>
                <ul>
                    <li><strong>E-commerce Stores:</strong> Calculate profitability for individual products</li>
                    <li><strong>Retail Businesses:</strong> Analyze margins across different product categories</li>
                    <li><strong>Wholesale Operations:</strong> Determine optimal pricing strategies</li>
                    <li><strong>Manufacturing:</strong> Assess cost structures and pricing models</li>
                    <li><strong>Service Providers:</strong> Calculate service delivery profitability</li>
                    <li><strong>Restaurants & Cafes:</strong> Analyze menu item profitability</li>
                    <li><strong>Drop Shipping:</strong> Quick margin calculations for product sourcing</li>
                    <li><strong>Financial Planning:</strong> Teach profit margin concepts to clients</li>
                    <li><strong>Business Consultants:</strong> Demonstrate profitability analysis to clients</li>
                    <li><strong>Sales Teams:</strong> Calculate deal profitability during negotiations</li>
                </ul>

                <h3>Best Practices</h3>
                <ul>
                    <li><strong>Include All Costs:</strong> Ensure COGS includes materials, labor, and overhead</li>
                    <li><strong>Target 40%+ Margins:</strong> Aim for healthy margins to cover operating expenses</li>
                    <li><strong>Compare by Category:</strong> Different products can have different margin expectations</li>
                    <li><strong>Monitor Regularly:</strong> Track margins over time to spot trends</li>
                    <li><strong>Factor in Discounts:</strong> Use average selling price, not list price</li>
                    <li><strong>Consider Volume:</strong> Higher volumes can sometimes justify lower margins</li>
                    <li><strong>Account for Returns:</strong> Factor return rates into your calculations</li>
                    <li><strong>Review Suppliers:</strong> Regularly negotiate COGS with suppliers</li>
                </ul>

                <h3>Technical Features</h3>
                <ul>
                    <li><strong>Input Validation:</strong> Prevents invalid entries (negative numbers, letters)</li>
                    <li><strong>Zero Division Handling:</strong> Gracefully handles edge cases</li>
                    <li><strong>Decimal Precision:</strong> Displays values with 2 decimal places</li>
                    <li><strong>Number Formatting:</strong> Adds thousand separators for readability</li>
                    <li><strong>Slider Range:</strong> Configurable maximum items (1-10,000)</li>
                    <li><strong>Accessibility:</strong> ARIA labels for screen readers</li>
                    <li><strong>Custom Colors:</strong> Full color customization support</li>
                    <li><strong>Multiple Currencies:</strong> Display any currency symbol</li>
                </ul>
            </div>

            <!-- POD Profit Calculator Documentation -->
            <div class="crc-admin-section">
                <h2>9. POD Profit Calculator (Print on Demand)</h2>

                <h3>Basic Usage</h3>
                <p>To display the POD Profit Calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[pod_profit_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[pod_profit_calculator]')">Copy</button>
                </div>

                <h3>Attributes</h3>
                <p>Customize the POD Profit Calculator using these attributes:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above the calculator</td>
                            <td>"POD Profit Calculator"</td>
                            <td><code>title="Calculate POD Profits"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text with description</td>
                            <td>"Calculate your print-on-demand profit margins with precision."</td>
                            <td><code>subtitle="Analyze POD profitability"</code></td>
                        </tr>
                        <tr>
                            <td><code>currency</code></td>
                            <td>Currency symbol to display</td>
                            <td>$</td>
                            <td><code>currency="€"</code></td>
                        </tr>
                        <tr>
                            <td><code>primary_color</code></td>
                            <td>Primary color for input focus (hex format)</td>
                            <td>#4F46E5</td>
                            <td><code>primary_color="#7C3AED"</code></td>
                        </tr>
                        <tr>
                            <td><code>profit_color</code></td>
                            <td>Color for positive profit display (hex format)</td>
                            <td>#10B981</td>
                            <td><code>profit_color="#059669"</code></td>
                        </tr>
                        <tr>
                            <td><code>loss_color</code></td>
                            <td>Color for negative profit/loss display (hex format)</td>
                            <td>#EF4444</td>
                            <td><code>loss_color="#DC2626"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Examples</h3>

                <h3>Example 1: Basic POD Calculator</h3>
                <div class="crc-shortcode-box">
                    <code>[pod_profit_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[pod_profit_calculator]')">Copy</button>
                </div>

                <h3>Example 2: Custom Title and Currency</h3>
                <div class="crc-shortcode-box">
                    <code>[pod_profit_calculator title="T-Shirt Profit Analysis" currency="£"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[pod_profit_calculator title=&quot;T-Shirt Profit Analysis&quot; currency=&quot;£&quot;]')">Copy</button>
                </div>

                <h3>Example 3: Custom Colors</h3>
                <div class="crc-shortcode-box">
                    <code>[pod_profit_calculator primary_color="#7C3AED" profit_color="#059669" loss_color="#DC2626"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[pod_profit_calculator primary_color=&quot;#7C3AED&quot; profit_color=&quot;#059669&quot; loss_color=&quot;#DC2626&quot;]')">Copy</button>
                </div>

                <h3>What It Calculates</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Metric</th>
                            <th>Formula</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Revenue</strong></td>
                            <td>Selling Price × Items Sold</td>
                            <td>Total income from sales</td>
                        </tr>
                        <tr>
                            <td><strong>Total Costs</strong></td>
                            <td>(Shipping + Marketing + Product Costs + Other Fees) × Items</td>
                            <td>All expenses per item × quantity sold</td>
                        </tr>
                        <tr>
                            <td><strong>Net Profit</strong></td>
                            <td>Revenue - Total Costs</td>
                            <td>Actual profit after all expenses</td>
                        </tr>
                        <tr>
                            <td><strong>Net Profit Margin</strong></td>
                            <td>(Net Profit / Revenue) × 100</td>
                            <td>Profitability as percentage of revenue</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Input Fields</h3>
                <ul>
                    <li><strong>Selling Price:</strong> The price you charge customers per item</li>
                    <li><strong>Shipping Fees:</strong> Shipping cost per item (to customer)</li>
                    <li><strong>Items Sold:</strong> Number of units sold</li>
                    <li><strong>Marketing Fees (CPA):</strong> Cost per acquisition - ad spend per item sold</li>
                    <li><strong>Product Costs:</strong> Base cost from POD provider (production + fulfillment)</li>
                    <li><strong>Other Fees:</strong> Platform fees, transaction fees, taxes, etc.</li>
                </ul>

                <h3>Key Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>Real-Time Calculations</h4>
                        <p>All metrics update instantly as you type - no submit button needed.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>2x2 Results Grid</h4>
                        <p>Four key metrics displayed in an organized grid layout.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Negative Profit Detection</h4>
                        <p>Automatically highlights losses in red when profit is negative.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Currency Formatting</h4>
                        <p>Professional currency formatting with thousand separators.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>2-Column Input Layout</h4>
                        <p>Desktop-optimized 2-column form, stacks to 1 column on mobile.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Color-Coded Results</h4>
                        <p>Revenue (blue), Costs (amber), Profit (green/red), Margin (indigo).</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Mobile Responsive</h4>
                        <p>Fully responsive design optimized for all screen sizes.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Custom Branding</h4>
                        <p>Customize colors to match your brand identity.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Info Section</h4>
                        <p>Built-in tips for understanding and improving profit margins.</p>
                    </div>
                </div>

                <h3>Profit Margin Interpretation</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Margin Range</th>
                            <th>Assessment</th>
                            <th>Recommendation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&lt; 0%</td>
                            <td>Loss - Losing money on each sale</td>
                            <td>Review all costs and increase pricing immediately</td>
                        </tr>
                        <tr>
                            <td>0-15%</td>
                            <td>Very Low Margin - Barely profitable</td>
                            <td>Reduce costs or increase prices to improve sustainability</td>
                        </tr>
                        <tr>
                            <td>15-25%</td>
                            <td>Low Margin - Minimal profit</td>
                            <td>Look for ways to optimize costs and marketing efficiency</td>
                        </tr>
                        <tr>
                            <td>25-40%</td>
                            <td>Good Margin - Healthy profitability</td>
                            <td>Standard for POD business, maintain and scale</td>
                        </tr>
                        <tr>
                            <td>&gt; 40%</td>
                            <td>Excellent Margin - Strong profitability</td>
                            <td>Outstanding performance, consider reinvesting in growth</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Use Cases</h3>
                <ul>
                    <li><strong>POD Sellers:</strong> Calculate profits for t-shirts, mugs, posters, etc.</li>
                    <li><strong>Etsy Stores:</strong> Factor in platform fees and shipping costs</li>
                    <li><strong>Amazon Merch:</strong> Analyze profitability across different products</li>
                    <li><strong>Redbubble Artists:</strong> Understand margins for different product types</li>
                    <li><strong>Shopify POD:</strong> Calculate true profit after all fees</li>
                    <li><strong>Marketing Analysis:</strong> Determine sustainable CPA for ad campaigns</li>
                    <li><strong>Product Selection:</strong> Compare profitability of different POD products</li>
                    <li><strong>Pricing Strategy:</strong> Find optimal price points for maximum profit</li>
                </ul>

                <h3>Best Practices</h3>
                <ul>
                    <li><strong>Include ALL Costs:</strong> Don't forget platform fees, transaction fees, and taxes</li>
                    <li><strong>Target 30%+ Margins:</strong> POD businesses should aim for 30-40% margins</li>
                    <li><strong>Track Marketing CPA:</strong> Know your true customer acquisition cost</li>
                    <li><strong>Factor in Returns:</strong> Set aside 2-5% for returns and refunds</li>
                    <li><strong>Test Products:</strong> Use calculator to validate new product ideas before launch</li>
                    <li><strong>Monitor Suppliers:</strong> Compare POD providers for best base costs</li>
                    <li><strong>Optimize Shipping:</strong> Negotiate better rates or pass costs to customers</li>
                    <li><strong>Scale Wisely:</strong> Only scale products with proven healthy margins</li>
                </ul>
            </div>

            <!-- Shopify Fee Calculator Documentation -->
            <div class="crc-admin-section">
                <h2>10. Shopify Fee Calculator</h2>

                <h3>Basic Usage</h3>
                <p>To display the Shopify Fee Calculator, use this shortcode:</p>

                <div class="crc-shortcode-box">
                    <code>[shopify_fee_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[shopify_fee_calculator]')">Copy</button>
                </div>

                <h3>Description</h3>
                <p>The Shopify Fee Calculator helps you compare payment processing fees across all three Shopify plans (Basic, Shopify, and Advanced). It automatically calculates and highlights the most cost-effective plan based on your sales volume and payment methods.</p>

                <h3>Attributes</h3>
                <p>All pricing and fee rates are customizable via shortcode attributes, making it easy to update when Shopify changes their pricing:</p>

                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th>Description</th>
                            <th>Default Value</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="background: #F3F4F6; font-weight: bold;">General Settings</td>
                        </tr>
                        <tr>
                            <td><code>title</code></td>
                            <td>Custom title displayed above calculator</td>
                            <td>"Shopify Fee Calculator"</td>
                            <td><code>title="Compare Shopify Plans"</code></td>
                        </tr>
                        <tr>
                            <td><code>subtitle</code></td>
                            <td>Subtitle text with description</td>
                            <td>"Compare payment processing fees..."</td>
                            <td><code>subtitle="Find your best plan"</code></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="background: #F3F4F6; font-weight: bold;">Plan Prices (Monthly)</td>
                        </tr>
                        <tr>
                            <td><code>basic_price</code></td>
                            <td>Basic plan monthly price</td>
                            <td>39</td>
                            <td><code>basic_price="42"</code></td>
                        </tr>
                        <tr>
                            <td><code>shopify_price</code></td>
                            <td>Shopify plan monthly price</td>
                            <td>105</td>
                            <td><code>shopify_price="108"</code></td>
                        </tr>
                        <tr>
                            <td><code>advanced_price</code></td>
                            <td>Advanced plan monthly price</td>
                            <td>399</td>
                            <td><code>advanced_price="399"</code></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="background: #F3F4F6; font-weight: bold;">Shopify Payments Rates (Percentage)</td>
                        </tr>
                        <tr>
                            <td><code>basic_sp_percent</code></td>
                            <td>Basic plan Shopify Payments rate (%)</td>
                            <td>2.9</td>
                            <td><code>basic_sp_percent="3.0"</code></td>
                        </tr>
                        <tr>
                            <td><code>shopify_sp_percent</code></td>
                            <td>Shopify plan Shopify Payments rate (%)</td>
                            <td>2.6</td>
                            <td><code>shopify_sp_percent="2.7"</code></td>
                        </tr>
                        <tr>
                            <td><code>advanced_sp_percent</code></td>
                            <td>Advanced plan Shopify Payments rate (%)</td>
                            <td>2.4</td>
                            <td><code>advanced_sp_percent="2.5"</code></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="background: #F3F4F6; font-weight: bold;">Shopify Payments Fixed Fees</td>
                        </tr>
                        <tr>
                            <td><code>basic_sp_fixed</code></td>
                            <td>Basic plan fixed fee per transaction</td>
                            <td>0.30</td>
                            <td><code>basic_sp_fixed="0.30"</code></td>
                        </tr>
                        <tr>
                            <td><code>shopify_sp_fixed</code></td>
                            <td>Shopify plan fixed fee per transaction</td>
                            <td>0.30</td>
                            <td><code>shopify_sp_fixed="0.30"</code></td>
                        </tr>
                        <tr>
                            <td><code>advanced_sp_fixed</code></td>
                            <td>Advanced plan fixed fee per transaction</td>
                            <td>0.30</td>
                            <td><code>advanced_sp_fixed="0.30"</code></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="background: #F3F4F6; font-weight: bold;">Transaction Fees (for Third-Party Gateways)</td>
                        </tr>
                        <tr>
                            <td><code>basic_transaction_fee</code></td>
                            <td>Basic plan transaction fee (%)</td>
                            <td>2.0</td>
                            <td><code>basic_transaction_fee="2.0"</code></td>
                        </tr>
                        <tr>
                            <td><code>shopify_transaction_fee</code></td>
                            <td>Shopify plan transaction fee (%)</td>
                            <td>1.0</td>
                            <td><code>shopify_transaction_fee="1.0"</code></td>
                        </tr>
                        <tr>
                            <td><code>advanced_transaction_fee</code></td>
                            <td>Advanced plan transaction fee (%)</td>
                            <td>0.5</td>
                            <td><code>advanced_transaction_fee="0.5"</code></td>
                        </tr>
                        <tr>
                            <td colspan="4" style="background: #F3F4F6; font-weight: bold;">PayPal Rates</td>
                        </tr>
                        <tr>
                            <td><code>paypal_percent</code></td>
                            <td>PayPal percentage fee</td>
                            <td>2.9</td>
                            <td><code>paypal_percent="3.1"</code></td>
                        </tr>
                        <tr>
                            <td><code>paypal_fixed</code></td>
                            <td>PayPal fixed fee per transaction</td>
                            <td>0.30</td>
                            <td><code>paypal_fixed="0.35"</code></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Examples</h3>

                <h3>Example 1: Basic Calculator with Default Rates</h3>
                <div class="crc-shortcode-box">
                    <code>[shopify_fee_calculator]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[shopify_fee_calculator]')">Copy</button>
                </div>

                <h3>Example 2: Updated 2026 Pricing</h3>
                <div class="crc-shortcode-box">
                    <code>[shopify_fee_calculator basic_price="42" shopify_price="108" advanced_price="399"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[shopify_fee_calculator basic_price=&quot;42&quot; shopify_price=&quot;108&quot; advanced_price=&quot;399&quot;]')">Copy</button>
                </div>

                <h3>Example 3: Custom PayPal Rates</h3>
                <div class="crc-shortcode-box">
                    <code>[shopify_fee_calculator paypal_percent="3.1" paypal_fixed="0.35"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[shopify_fee_calculator paypal_percent=&quot;3.1&quot; paypal_fixed=&quot;0.35&quot;]')">Copy</button>
                </div>

                <h3>Example 4: Full Custom Configuration</h3>
                <div class="crc-shortcode-box">
                    <code>[shopify_fee_calculator basic_price="42" basic_sp_percent="3.0" basic_transaction_fee="2.0" shopify_price="108" shopify_sp_percent="2.7" advanced_price="399"]</code>
                    <button class="crc-copy-shortcode" onclick="crcCopyShortcode(this, '[shopify_fee_calculator basic_price=&quot;42&quot; basic_sp_percent=&quot;3.0&quot; basic_transaction_fee=&quot;2.0&quot; shopify_price=&quot;108&quot; shopify_sp_percent=&quot;2.7&quot; advanced_price=&quot;399&quot;]')">Copy</button>
                </div>

                <h3>How It Works</h3>
                <ol>
                    <li><strong>Select Time Period:</strong> Choose Monthly or Yearly calculations</li>
                    <li><strong>Choose Payment Methods:</strong> Check Shopify Payments, PayPal, or Other Gateway</li>
                    <li><strong>Enter Sales Data:</strong> Input monthly sales value and number of transactions</li>
                    <li><strong>View Comparison:</strong> See fees calculated for all 3 plans side-by-side</li>
                    <li><strong>Best Value Highlight:</strong> The most cost-effective plan is automatically highlighted in green</li>
                </ol>

                <h3>Key Features</h3>
                <div class="crc-feature-grid">
                    <div class="crc-feature-item">
                        <h4>3-Plan Comparison</h4>
                        <p>Compare Basic ($39), Shopify ($105), and Advanced ($399) plans side-by-side.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Multiple Payment Methods</h4>
                        <p>Calculate fees for Shopify Payments, PayPal, and custom payment gateways.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Best Value Detection</h4>
                        <p>Automatically highlights the most cost-effective plan with green border and badge.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Monthly/Yearly Toggle</h4>
                        <p>Switch between monthly and annual calculations with one click.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Real-Time Updates</h4>
                        <p>All calculations update instantly as you adjust inputs.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Fee Breakdown</h4>
                        <p>See detailed breakdown of each fee type per plan.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Conditional Fields</h4>
                        <p>Other Gateway section appears only when selected.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Fully Customizable</h4>
                        <p>Update all pricing via shortcode attributes - no code changes needed.</p>
                    </div>
                    <div class="crc-feature-item">
                        <h4>Mobile Responsive</h4>
                        <p>3-column layout on desktop stacks beautifully on mobile.</p>
                    </div>
                </div>

                <h3>Fee Calculations</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th>Fees Calculated</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Shopify Payments</strong></td>
                            <td>(Sales × SP Rate%) + (Transactions × SP Fixed Fee)</td>
                        </tr>
                        <tr>
                            <td><strong>PayPal</strong></td>
                            <td>(Sales × PayPal Rate%) + (Transactions × PayPal Fixed) + (Sales × Transaction Fee%)</td>
                        </tr>
                        <tr>
                            <td><strong>Other Gateway</strong></td>
                            <td>(Sales × Gateway Rate%) + (Transactions × Gateway Fixed) + (Sales × Transaction Fee%)</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Plan Selection Guide</h3>
                <table class="crc-attributes-table">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Best For</th>
                            <th>Key Benefits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Basic ($39/mo)</strong></td>
                            <td>New stores, low volume</td>
                            <td>Low monthly fee, suitable for testing and starting out</td>
                        </tr>
                        <tr>
                            <td><strong>Shopify ($105/mo)</strong></td>
                            <td>Growing stores, medium volume</td>
                            <td>Lower processing fees (2.6%), better for $10k+/month in sales</td>
                        </tr>
                        <tr>
                            <td><strong>Advanced ($399/mo)</strong></td>
                            <td>High-volume stores</td>
                            <td>Lowest fees (2.4%), cost-effective above $50k+/month</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Use Cases</h3>
                <ul>
                    <li><strong>Store Planning:</strong> Determine which Shopify plan is most cost-effective for your volume</li>
                    <li><strong>Plan Upgrades:</strong> Calculate when to upgrade from Basic to Shopify or Advanced</li>
                    <li><strong>Payment Method Selection:</strong> Compare costs of Shopify Payments vs PayPal vs other gateways</li>
                    <li><strong>Budget Forecasting:</strong> Project monthly/yearly payment processing costs</li>
                    <li><strong>ROI Analysis:</strong> See if higher-tier plans pay for themselves in fee savings</li>
                    <li><strong>Client Consulting:</strong> Help clients choose the right Shopify plan</li>
                    <li><strong>Growth Planning:</strong> Model costs at different sales volumes</li>
                    <li><strong>Multi-Gateway Strategy:</strong> Calculate costs when using multiple payment methods</li>
                </ul>

                <h3>Best Practices</h3>
                <ul>
                    <li><strong>Use Actual Data:</strong> Input your real monthly averages for accurate results</li>
                    <li><strong>Consider Growth:</strong> Calculate for your expected volume in 3-6 months</li>
                    <li><strong>Factor All Gateways:</strong> If you use multiple payment methods, calculate all of them</li>
                    <li><strong>Check Yearly Savings:</strong> Use yearly toggle to see annual savings</li>
                    <li><strong>Update Regularly:</strong> When Shopify updates rates, update shortcode attributes</li>
                    <li><strong>Account for Peak Seasons:</strong> Use peak monthly volume for worst-case calculations</li>
                    <li><strong>Compare Total Cost:</strong> Remember that plan subscription + fees = total cost</li>
                    <li><strong>Break-Even Analysis:</strong> Calculate at what volume a higher plan becomes cheaper</li>
                </ul>

                <h3>Updating for New Shopify Pricing</h3>
                <p>When Shopify updates their pricing or fee structure, simply update the shortcode attributes - no code changes needed:</p>
                <pre style="background: #F3F4F6; padding: 1rem; border-radius: 8px; overflow-x: auto;">
[shopify_fee_calculator
    basic_price="NEW_PRICE"
    basic_sp_percent="NEW_RATE"
    shopify_price="NEW_PRICE"
    shopify_sp_percent="NEW_RATE"
    advanced_price="NEW_PRICE"
    advanced_sp_percent="NEW_RATE"
    paypal_percent="NEW_RATE"
    paypal_fixed="NEW_FEE"]
                </pre>
            </div>

            <!-- Support -->
            <div class="crc-admin-section">
                <div class="crc-support-box">
                    <h3>Need Help?</h3>
                    <p><strong>Website:</strong> <a href="https://reportgenix.com" target="_blank">reportgenix.com</a></p>
                    <p><strong>Email:</strong> support@reportgenix.com</p>
                    <p><strong>Version:</strong> <?php echo self::VERSION; ?></p>
                </div>
            </div>
        </div>

        <script>
            function crcCopyShortcode(button, text) {
                // Use modern clipboard API
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(text).then(function() {
                        button.textContent = 'Copied!';
                        button.classList.add('copied');
                        setTimeout(function() {
                            button.textContent = 'Copy';
                            button.classList.remove('copied');
                        }, 2000);
                    }).catch(function(err) {
                        console.error('Failed to copy:', err);
                        alert('Failed to copy shortcode');
                    });
                } else {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-9999px';
                    document.body.appendChild(textArea);
                    textArea.select();

                    try {
                        document.execCommand('copy');
                        button.textContent = 'Copied!';
                        button.classList.add('copied');
                        setTimeout(function() {
                            button.textContent = 'Copy';
                            button.classList.remove('copied');
                        }, 2000);
                    } catch (err) {
                        console.error('Failed to copy:', err);
                        alert('Failed to copy shortcode');
                    }

                    document.body.removeChild(textArea);
                }
            }
        </script>
        <?php
    }
}

// Initialize the plugin
new ReportGenix_Tools_Collection();

/**
 * Plugin activation hook
 */
register_activation_hook(__FILE__, 'crc_plugin_activate');
function crc_plugin_activate() {
    // Flush rewrite rules (if needed in future)
    flush_rewrite_rules();
}

/**
 * Plugin deactivation hook
 */
register_deactivation_hook(__FILE__, 'crc_plugin_deactivate');
function crc_plugin_deactivate() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
