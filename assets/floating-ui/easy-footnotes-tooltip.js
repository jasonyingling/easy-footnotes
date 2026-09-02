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

    const { autoUpdate, computePosition, flip, shift, offset } = FloatingUIDOM;
    let tooltipCount = 0;

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
            tooltip.id = 'efn-tooltip-' + (++tooltipCount);

            // Get content from title attribute
            const content = trigger.getAttribute('title');
            if (!content) return;

            // Remove title to prevent native tooltip
            trigger.removeAttribute('title');
            trigger.setAttribute('data-efn-title', content);
            trigger.setAttribute('aria-describedby', tooltip.id);

            // The title attribute carries already-processed footnote HTML. qTip
            // rendered it as HTML, so retain links and allowed formatting here.
            tooltip.innerHTML = content;

            // Add tooltip to body
            document.body.appendChild(tooltip);

            // Hide timeout reference
            let hideTimeout = null;
            let fadeTimeout = null;
            let isTooltipHovered = false;
            let isTriggerHovered = false;
            let isTriggerFocused = false;
            let cleanupAutoUpdate = null;

            function updatePosition() {
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

            function cancelHide() {
                clearTimeout(hideTimeout);
                clearTimeout(fadeTimeout);
            }

            /**
             * Show tooltip
             */
            function show() {
                cancelHide();

                tooltip.style.display = 'block';
                updatePosition();

                if (!cleanupAutoUpdate) {
                    cleanupAutoUpdate = autoUpdate(trigger, tooltip, updatePosition);
                }

                // Trigger reflow for animation
                tooltip.offsetHeight;
                tooltip.classList.add('efn-tooltip-show');
            }

            /**
             * Hide tooltip with delay
             */
            function hide() {
                cancelHide();
                hideTimeout = setTimeout(function() {
                    if (!isTooltipHovered && !isTriggerHovered && !isTriggerFocused) {
                        tooltip.classList.remove('efn-tooltip-show');
                        if (cleanupAutoUpdate) {
                            cleanupAutoUpdate();
                            cleanupAutoUpdate = null;
                        }
                        fadeTimeout = setTimeout(function() {
                            if (!isTooltipHovered && !isTriggerHovered && !isTriggerFocused) {
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
                isTriggerFocused = true;
                show();
            });

            trigger.addEventListener('blur', function() {
                isTriggerFocused = false;
                hide();
            });

            /**
             * Handle tooltip hover (keep tooltip open when hovering over it)
             */
            tooltip.addEventListener('mouseenter', function() {
                isTooltipHovered = true;
                show();
            });

            tooltip.addEventListener('mouseleave', function() {
                isTooltipHovered = false;
                hide();
            });

            document.addEventListener('pointerdown', function(event) {
                if (!trigger.contains(event.target) && !tooltip.contains(event.target)) {
                    isTriggerHovered = false;
                    isTriggerFocused = false;
                    isTooltipHovered = false;
                    hide();
                }
            });
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEasyFootnotesTooltips);
    } else {
        initEasyFootnotesTooltips();
    }
})();
