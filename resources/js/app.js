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
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

document.addEventListener("DOMContentLoaded", () => {
    // 1. Fade In
    gsap.from(".gsap-fade", {
        duration: 1,
        opacity: 0,
        y: -50,
        stagger: 0.3
    });

    // 2. Stagger Buttons
    gsap.from(".gsap-stagger", {
        duration: 1,
        opacity: 0,
        y: 50,
        stagger: 0.2,
        delay: 1
    });

    // 3. Slide In
    gsap.from(".gsap-slide", {
        duration: 1,
        x: -200,
        opacity: 0
    });

    // 4. Scale
    gsap.from(".gsap-scale", {
        duration: 1,
        scale: 0,
        opacity: 0,
        delay: 0.5
    });

    // 5. Rotate
    gsap.from(".gsap-rotate", {
        duration: 1,
        rotation: 360,
        opacity: 0,
        delay: 1
    });

    // 6. Timeline Animation
    let tl = gsap.timeline({ repeat: -1, yoyo: true });
    tl.from(".timeline-box", {
        duration: 1,
        opacity: 0,
        y: 100,
        stagger: 0.5
    });

    // 7. ScrollTrigger
    gsap.utils.toArray(".scroll-card").forEach(card => {
        gsap.from(card, {
            scrollTrigger: {
                trigger: card,
                start: "top 80%",
                toggleActions: "play none none none"
            },
            duration: 1,
            opacity: 0,
            y: 100,
            ease: "power3.out"
        });
    });
});
