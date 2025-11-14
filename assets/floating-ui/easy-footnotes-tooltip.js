/**
 * Easy Footnotes Tooltip Implementation using Floating UI
 * Replaces qtip2 with modern, actively maintained Floating UI
 */
(function() {
    'use strict';

    if (typeof FloatingUIDOM === 'undefined') {
        console.error('Floating UI library is not loaded');
        return;
    }

    const { computePosition, flip, shift, offset, arrow } = FloatingUIDOM;

    /**
     * Initialize tooltips for Easy Footnotes
     */
    function initEasyFootnotesTooltips() {
        const triggers = document.querySelectorAll('.easy-footnote a');

        triggers.forEach(function(trigger) {
            // Create tooltip element
            const tooltip = document.createElement('div');
            tooltip.className = 'efn-tooltip';
            tooltip.setAttribute('role', 'tooltip');

            // Get content from title attribute
            const content = trigger.getAttribute('title');
            if (!content) return;

            // Remove title to prevent native tooltip
            trigger.removeAttribute('title');
            trigger.setAttribute('data-efn-title', content);

            // Set tooltip content
            tooltip.textContent = content;

            // Add tooltip to body
            document.body.appendChild(tooltip);

            // Hide timeout reference
            let hideTimeout = null;
            let isTooltipHovered = false;
            let isTriggerHovered = false;

            /**
             * Show tooltip
             */
            function show() {
                clearTimeout(hideTimeout);

                // Update position
                computePosition(trigger, tooltip, {
                    placement: 'bottom',
                    middleware: [
                        offset(6),
                        flip(),
                        shift({ padding: 5 })
                    ]
                }).then(function(data) {
                    Object.assign(tooltip.style, {
                        left: data.x + 'px',
                        top: data.y + 'px'
                    });
                });

                tooltip.style.display = 'block';
                // Trigger reflow for animation
                tooltip.offsetHeight;
                tooltip.classList.add('efn-tooltip-show');
            }

            /**
             * Hide tooltip with delay
             */
            function hide() {
                hideTimeout = setTimeout(function() {
                    if (!isTooltipHovered && !isTriggerHovered) {
                        tooltip.classList.remove('efn-tooltip-show');
                        setTimeout(function() {
                            if (!isTooltipHovered && !isTriggerHovered) {
                                tooltip.style.display = 'none';
                            }
                        }, 200); // Wait for fade animation
                    }
                }, 400); // 400ms delay to match qtip2
            }

            /**
             * Handle trigger hover
             */
            trigger.addEventListener('mouseenter', function() {
                isTriggerHovered = true;
                show();
            });

            trigger.addEventListener('mouseleave', function() {
                isTriggerHovered = false;
                hide();
            });

            /**
             * Handle trigger focus (keyboard accessibility)
             */
            trigger.addEventListener('focus', function() {
                isTriggerHovered = true;
                show();
            });

            trigger.addEventListener('blur', function() {
                isTriggerHovered = false;
                hide();
            });

            /**
             * Handle tooltip hover (keep tooltip open when hovering over it)
             */
            tooltip.addEventListener('mouseenter', function() {
                isTooltipHovered = true;
                clearTimeout(hideTimeout);
            });

            tooltip.addEventListener('mouseleave', function() {
                isTooltipHovered = false;
                hide();
            });

            /**
             * Update position on scroll/resize
             */
            function updatePosition() {
                if (tooltip.style.display === 'block') {
                    computePosition(trigger, tooltip, {
                        placement: 'bottom',
                        middleware: [
                            offset(6),
                            flip(),
                            shift({ padding: 5 })
                        ]
                    }).then(function(data) {
                        Object.assign(tooltip.style, {
                            left: data.x + 'px',
                            top: data.y + 'px'
                        });
                    });
                }
            }

            window.addEventListener('scroll', updatePosition, true);
            window.addEventListener('resize', updatePosition);
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEasyFootnotesTooltips);
    } else {
        initEasyFootnotesTooltips();
    }
})();
