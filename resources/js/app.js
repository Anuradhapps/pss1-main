// Import Alpine.js only once
import Alpine from 'alpinejs';
import Collapse from '@alpinejs/collapse';

// Initialize Flatpickr
import flatpickr from 'flatpickr';
window.flatpickr = flatpickr;

// Initialize FilePond
import * as FilePond from 'filepond';
window.FilePond = FilePond;

// Initialize Prism.js
import Prism from 'prismjs';
import 'prismjs/plugins/normalize-whitespace/prism-normalize-whitespace';
import 'prismjs/themes/prism-tomorrow.css';
import 'prismjs/components/prism-markup-templating';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-css';
import 'prismjs/components/prism-javascript';

Prism.plugins.NormalizeWhitespace.setDefaults({
    'remove-trailing': true,
    'remove-indent': true,
    'left-trim': true,
    'right-trim': true
});

// Initialize Alpine.js with plugins
Alpine.plugin(Collapse);

// Start Alpine only if not already started
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.start();
}

// Highlight all Prism code blocks after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    Prism.highlightAll();
});
