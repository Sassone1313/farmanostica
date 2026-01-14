document.addEventListener('DOMContentLoaded', function () {
    function createSocialMediaSection() {
        let socialSection = document.querySelector('.wc-block-checkout__social-fields');
        if (!socialSection) {
            socialSection = document.createElement('div');
            socialSection.classList.add('wc-block-checkout__social-fields', 'wc-block-checkout__additional-fields-wrapper'); // Mimic existing section styles
            const heading = document.createElement('h3');
            heading.textContent = 'Social Media';
            heading.classList.add('wc-block-checkout__form-section-heading'); // Optional: Match WooCommerce heading class for consistency
            socialSection.appendChild(heading);
        }
        return socialSection;
    }

    function repositionFields() {
        const form = document.querySelector('.wc-block-checkout__form');
        if (!form) {
            console.warn('Checkout form not found.');
            return false;
        }

        // Target insertion point: After address fields (adjust selector as needed)
        const addressWrapper = document.querySelector('.wc-block-checkout__billing-fields-wrapper') || document.querySelector('.wc-block-checkout__shipping-fields-wrapper');
        if (!addressWrapper) {
            console.warn('Address wrapper not found.');
            return false;
        }

        const socialSection = createSocialMediaSection();

        // Find social media field wrappers (adjust selector to match your fields, e.g., classes containing 'twitter_handle' or 'instagram_username')
        // Example: Assuming classes like 'wc-block-components-address-form__aco-wc-checkout-block-twitter_handle'
        const fieldWrappers = document.querySelectorAll('[class*="wc-block-components-address-form__aco-wc-checkout-block-"][class*="twitter_handle"], [class*="wc-block-components-address-form__aco-wc-checkout-block-"][class*="instagram_username"]'); // Add more for other fields
        const seenIds = new Set();
        let allMoved = true;

        fieldWrappers.forEach((fieldWrapper, index) => {
            const classList = Array.from(fieldWrapper.classList);
            const fieldIdClass = classList.find(cls => cls.includes('wc-block-components-address-form__aco-wc-checkout-block-'));
            const fieldId = fieldIdClass ? fieldIdClass.split('aco-wc-checkout-block-')[1] : null;

            if (!fieldId || seenIds.has(fieldId)) {
                console.warn(`Duplicate or invalid field detected: ${fieldId}`);
                fieldWrapper.remove();
                return;
            }
            seenIds.add(fieldId);

            // Move to social section
            if (socialSection.children[index + 1] !== fieldWrapper) { // +1 to account for heading
                socialSection.appendChild(fieldWrapper);
                allMoved = false;
            }
        });

        // Insert section if not already in DOM
        if (!form.contains(socialSection)) {
            addressWrapper.parentNode.insertBefore(socialSection, addressWrapper.nextSibling); // Insert after address
        }

        if (allMoved) console.log('All social fields positioned');
        return allMoved;
    }

    const observer = new MutationObserver(function (mutations, observer) {
        if (repositionFields()) {
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
    setTimeout(repositionFields, 1000); // Fallback for initial load
});