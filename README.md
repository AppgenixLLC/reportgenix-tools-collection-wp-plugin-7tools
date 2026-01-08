# ReportGenix Tools Collection - WordPress Plugin

**Version:** 2.0.0
**Author:** Appgenix LLC
**License:** GPL v2 or later
**WordPress Tested:** 6.0+
**PHP Version:** 7.4+

A comprehensive WordPress plugin providing 7 professional business calculators and tools for marketing, e-commerce, and business analytics.

---

## 🚀 Features

### 7 Professional Tools Included

1. **Conversion Rate Calculator** - Calculate and display conversion rates with performance benchmarks
2. **ROI Calculator** - Calculate Return on Investment with detailed metrics and projections
3. **ROAS Calculator** - Calculate Return on Ad Spend to measure advertising campaign effectiveness
4. **CAC Calculator** - Calculate Customer Acquisition Cost with detailed metrics and breakdowns
5. **CLV Calculator** - Calculate Customer Lifetime Value with CLV:CAC ratio analysis and What-If simulator
6. **SKU Generator** - Generate unique SKU codes with multiple formats, export options, and QR codes
7. **UTM Builder** - Build UTM tracking URLs for campaigns with live preview and QR code generation

---

## 📦 Installation

### Via WordPress Admin

1. Download the plugin zip file
2. Go to **WordPress Admin → Plugins → Add New**
3. Click **Upload Plugin**
4. Choose the downloaded zip file
5. Click **Install Now**
6. Activate the plugin

### Manual Installation

1. Download the plugin files
2. Upload the \`reportgenix-conversion-rate-calculator\` folder to \`/wp-content/plugins/\`
3. Activate the plugin through the **Plugins** menu in WordPress

---

## 📖 Usage

### Quick Start

Simply add any shortcode to your page or post:

\`\`\`
[conversion_rate_calculator]
[roi_calculator]
[roas_calculator]
[cac_calculator]
[clv_calculator]
[sku_generator]
[utm_builder]
\`\`\`

### Access Documentation

Go to **WordPress Admin → Tools Collection → Documentation** for complete shortcode attributes, examples, and best practices.

---

## 🔧 Shortcodes & Attributes

### 1. Conversion Rate Calculator

**Shortcode:** \`[conversion_rate_calculator]\`

**Attributes:**
- \`title\` - Custom title (default: "Conversion Rate Calculator")
- \`button_text\` - Custom button text (default: "Calculate Conversion Rate")
- \`show_benchmark\` - Show/hide performance indicator (default: "true")
- \`primary_color\` - Custom button color in hex format (default: "#4F46E5")

**Example:**
\`\`\`
[conversion_rate_calculator title="Calculate Your Store's Conversion" primary_color="#FF6B6B"]
\`\`\`

---

### 2. ROI Calculator

**Shortcode:** \`[roi_calculator]\`

**Attributes:**
- \`title\` - Custom title (default: "ROI Calculator")
- \`subtitle\` - Subtitle text
- \`default_currency\` - Default currency (default: "USD")
- \`show_period_selector\` - Show/hide period selector (default: "true")
- \`show_tips\` - Show/hide calculation tips (default: "true")
- \`primary_color\` - Custom color (default: "#4F46E5")

**Example:**
\`\`\`
[roi_calculator default_currency="EUR" show_tips="false"]
\`\`\`

---

### 3. ROAS Calculator

**Shortcode:** \`[roas_calculator]\`

**Attributes:**
- \`title\` - Custom title (default: "ROAS Calculator")
- \`subtitle\` - Subtitle text
- \`default_currency\` - Default currency (default: "USD")
- \`show_benchmark\` - Show/hide performance benchmarks (default: "true")
- \`show_tips\` - Show/hide optimization tips (default: "true")
- \`primary_color\` - Custom color (default: "#EF4444")

**Example:**
\`\`\`
[roas_calculator show_benchmark="true" primary_color="#DC2626"]
\`\`\`

---

### 4. CAC Calculator

**Shortcode:** \`[cac_calculator]\`

**Attributes:**
- \`title\` - Custom title (default: "Customer Acquisition Cost Calculator")
- \`subtitle\` - Subtitle text
- \`default_currency\` - Default currency (default: "USD")
- \`show_breakdown\` - Show/hide cost breakdown (default: "true")
- \`show_tips\` - Show/hide optimization tips (default: "true")
- \`default_period\` - Default time period (default: "monthly")
- \`primary_color\` - Custom color (default: "#F97316")

**Example:**
\`\`\`
[cac_calculator default_period="yearly" show_breakdown="true"]
\`\`\`

---

### 5. CLV Calculator

**Shortcode:** \`[clv_calculator]\`

**Attributes:**
- \`title\` - Custom title (default: "Customer Lifetime Value Calculator")
- \`subtitle\` - Subtitle text
- \`default_currency\` - Default currency (default: "USD")
- \`show_profit_margin\` - Show/hide profit margin field (default: "true")
- \`show_cac_field\` - Show/hide CAC field (default: "true")
- \`show_annual_value\` - Show/hide annual value (default: "true")
- \`show_tips\` - Show/hide improvement tips (default: "true")
- \`default_lifespan\` - Pre-fill customer lifespan
- \`default_frequency\` - Pre-fill purchase frequency
- \`primary_color\` - Custom color (default: "#059669")

**Example:**
\`\`\`
[clv_calculator default_lifespan="5" default_frequency="12" show_profit_margin="true"]
\`\`\`

---

### 6. SKU Generator

**Shortcode:** \`[sku_generator]\`

**Attributes:**
- \`title\` - Custom title (default: "SKU Generator")
- \`subtitle\` - Subtitle text
- \`max_skus\` - Maximum SKUs to generate (default: "1000")
- \`default_length\` - Default SKU length (default: "8")
- \`default_type\` - Default generation type (default: "random_numbers")
- \`show_export\` - Show/hide export buttons (default: "true")
- \`show_preview\` - Show/hide live preview (default: "true")
- \`default_prefix\` - Pre-fill prefix
- \`default_suffix\` - Pre-fill suffix
- \`primary_color\` - Custom color (default: "#2563EB")

**Example:**
\`\`\`
[sku_generator default_prefix="PROD" default_length="10" max_skus="500"]
\`\`\`

**Generation Types:**
- \`sequential\` - Sequential numbers (001, 002, 003...)
- \`random_numbers\` - Random numeric codes
- \`letters\` - Random letter codes
- \`alphanumeric\` - Random letters + numbers

---

### 7. UTM Builder

**Shortcode:** \`[utm_builder]\`

**Attributes:**
- \`title\` - Custom title (default: "UTM Builder")
- \`subtitle\` - Subtitle text
- \`show_term\` - Show/hide Campaign Term field (default: "true")
- \`show_content\` - Show/hide Campaign Content field (default: "true")
- \`show_id\` - Show/hide Campaign ID field (default: "false")
- \`show_qr\` - Show/hide QR code generation (default: "true")
- \`show_breakdown\` - Show/hide URL breakdown table (default: "true")
- \`default_url\` - Pre-fill the website URL
- \`primary_color\` - Custom color (default: "#7C3AED")
- \`remember_values\` - Remember inputs in localStorage (default: "true")

**Example:**
\`\`\`
[utm_builder default_url="https://example.com" show_qr="true" show_breakdown="true"]
\`\`\`

---

## 🎨 Key Features

### All Calculators Include:
- ✅ **30 Currency Support** - Major world currencies with proper formatting
- ✅ **Responsive Design** - Mobile, tablet, and desktop optimized
- ✅ **Copy to Clipboard** - One-click copy functionality
- ✅ **Professional UI** - Modern, clean design with custom color schemes
- ✅ **Instant Calculations** - Real-time results with animations
- ✅ **Keyboard Support** - Enter key to calculate
- ✅ **Print Friendly** - Optimized for printing results
- ✅ **Accessibility** - ARIA labels and screen reader support

### SKU Generator Special Features:
- ✅ **4 Generation Methods** - Sequential, random numbers, letters, alphanumeric
- ✅ **Duplicate Prevention** - Ensures unique SKU codes
- ✅ **Confusing Character Exclusion** - Optional filtering of 0/O and 1/I/l
- ✅ **Bulk Export** - Download as CSV or TXT
- ✅ **Live Preview** - See SKU format before generating
- ✅ **Custom Separators** - Dash, underscore, or none

### UTM Builder Special Features:
- ✅ **Live URL Preview** - Real-time preview as you type
- ✅ **Smart Formatting** - Auto-lowercase, spaces to underscores
- ✅ **QR Code Generation** - Instant QR codes for tracking URLs
- ✅ **URL Breakdown Table** - Visual parameter display
- ✅ **16 Medium Options** - Pre-configured campaign mediums
- ✅ **Source Autocomplete** - Suggestions for popular sources

### CLV Calculator Special Features:
- ✅ **What-If Simulator** - See impact of improvements
- ✅ **CLV:CAC Ratio Analysis** - 5-tier performance gauge
- ✅ **Profit-Based CLV** - Optional profit margin calculations
- ✅ **Payback Period** - Calculate CAC recovery time
- ✅ **Net Customer Value** - Automatic CLV - CAC calculation

---

## 🔄 Conditional Asset Loading

The plugin uses **smart asset loading** - CSS and JavaScript files are only loaded on pages that contain the respective shortcode. This ensures optimal performance and no conflicts with other plugins.

---

## 🎯 Use Cases

### E-commerce & Retail
- Track conversion rates across product pages
- Calculate profit margins and ROI
- Generate SKU codes for inventory
- Track marketing campaigns with UTM links

### Marketing Agencies
- Build client campaign tracking URLs
- Calculate advertising ROI and ROAS
- Measure customer acquisition costs
- Analyze customer lifetime value

### SaaS & Subscription Businesses
- Calculate CLV for subscription models
- Analyze CLV:CAC ratios for growth
- Track campaign performance
- Optimize customer acquisition

### Content Creators & Influencers
- Generate affiliate tracking links
- Calculate sponsorship ROI
- Track campaign performance
- Build UTM links for social media

---

## 📊 Currency Support (30+ Currencies)

USD, EUR, GBP, JPY, AUD, CAD, CHF, CNY, SEK, NZD, MXN, SGD, HKD, NOK, KRW, TRY, RUB, INR, BRL, ZAR, DKK, PLN, THB, IDR, HUF, CZK, ILS, PHP, AED, MYR

---

## 🛠️ Technical Details

### File Structure
\`\`\`
reportgenix-conversion-rate-calculator/
├── assets/
│   ├── css/
│   │   ├── calculator.css
│   │   ├── roi-calculator.css
│   │   ├── roas-calculator.css
│   │   ├── cac-calculator.css
│   │   ├── clv-calculator.css
│   │   ├── sku-generator.css
│   │   └── utm-builder.css
│   └── js/
│       ├── calculator.js
│       ├── roi-calculator.js
│       ├── roas-calculator.js
│       ├── cac-calculator.js
│       ├── clv-calculator.js
│       ├── sku-generator.js
│       └── utm-builder.js
├── reportgenix-tools-collection.php (Main plugin file)
└── README.md
\`\`\`

### Technology Stack
- **Frontend:** Vanilla JavaScript (ES6+), Modern CSS3
- **Backend:** PHP 7.4+
- **WordPress:** 6.0+ compatible
- **Architecture:** Object-oriented PHP, modular JavaScript
- **Performance:** Conditional asset loading, external stylesheets
- **Compatibility:** All modern browsers, IE11+ (graceful degradation)

### Coding Standards
- WordPress Coding Standards
- PSR-4 autoloading compatible
- Sanitization & validation for all inputs
- Nonce verification for security
- Escaping for all outputs

---

## 🔒 Security Features

- ✅ Input sanitization using WordPress sanitize functions
- ✅ Output escaping to prevent XSS
- ✅ Nonce verification for AJAX requests
- ✅ No SQL queries (uses WordPress options API)
- ✅ No external dependencies or CDN requirements
- ✅ All assets loaded locally

---

## 🌐 Browser Compatibility

| Browser | Version |
|---------|---------|
| Chrome | 90+ |
| Firefox | 88+ |
| Safari | 14+ |
| Edge | 90+ |
| Opera | 76+ |
| IE | 11 (limited support) |

---

## 📱 Mobile Support

All tools are fully responsive and optimized for:
- iPhone (iOS 12+)
- Android phones (Android 8+)
- Tablets (iPad, Android tablets)
- Desktop (all screen sizes)

---

## 🆕 Changelog

### Version 2.0.0 (2026-01-08)
- ✨ Added CLV Calculator with What-If simulator
- ✨ Added SKU Generator with 4 generation methods
- ✨ Added UTM Builder with QR code generation
- ✨ Added 30 currency support to all calculators
- ✨ Improved responsive design across all tools
- ✨ Enhanced documentation page
- 🐛 Removed activation notice
- 🔧 Optimized asset loading
- 🎨 Updated color schemes for better accessibility

### Version 1.0.0
- 🎉 Initial release
- ✨ Conversion Rate Calculator
- ✨ ROI Calculator
- ✨ ROAS Calculator
- ✨ CAC Calculator

---

## 💡 Support & Documentation

### Getting Help
- **Documentation:** WordPress Admin → Tools Collection → Documentation
- **GitHub Issues:** [Report bugs or request features](https://github.com/AppgenixLLC/reportgenix-tools-collection-wp-plugin-7tools/issues)
- **Email:** support@reportgenix.com
- **Website:** https://reportgenix.com

### Documentation Includes:
- Complete shortcode attribute reference
- 20+ usage examples
- Best practices for each tool
- Troubleshooting guide
- Performance optimization tips

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (\`git checkout -b feature/AmazingFeature\`)
3. Commit your changes (\`git commit -m 'Add some AmazingFeature'\`)
4. Push to the branch (\`git push origin feature/AmazingFeature\`)
5. Open a Pull Request

---

## 📄 License

This plugin is licensed under the GPL v2 or later.

\`\`\`
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
\`\`\`

---

## 🏢 About Appgenix LLC

Professional WordPress plugin development and custom software solutions.

- **Website:** https://appgenix.com
- **GitHub:** https://github.com/AppgenixLLC
- **Email:** info@appgenix.com

---

## 🌟 Show Your Support

If you find this plugin helpful, please:
- ⭐ Star this repository
- 📢 Share with others
- 🐛 Report bugs
- 💡 Suggest new features
- ✍️ Write a review

---

**Made with ❤️ by Appgenix LLC**
