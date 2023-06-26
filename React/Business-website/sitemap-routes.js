import React from 'react';
import { Routes, Route } from 'react-router';

export default (
    // Switch is added in v4 react-router
    <Routes>
        <Route path='/' />
        <Route path='/privacy-policy' />
        <Route path='/cookie-policy' />
        <Route path='/industrial-training' />
        <Route path='/service' />

        <Route path='/contact' />
        <Route path='/about' />
        <Route path='/blog' />
        <Route path='/career' />
        <Route path='/banner-design' />

        <Route path={`/design-services`} />
        <Route path={`/logo-design`} />
        <Route path={`/web-design`} />

        <Route path={`/digital-marketing`} />
        <Route path={`/pay-per-click-services`} />
        <Route path={`/search-engine-optimization`} />
        <Route path={`/social-media-optimization`} />

        <Route path={`/magento-data-migration-services`} />
        <Route path={`/magento-design-services`} />
        <Route path={`/magento-development-services`} />
        <Route path={`/magento-services`} />

        <Route path={`/android-app-development`} />
        <Route path={`/html5-app-development`} />
        <Route path={`/hybrid-app-development`} />
        <Route path={`/iphone-app-development`} />
        <Route path={`/mobile-app-development`} />

        {/* Service list  product-development */}
        <Route path={`/crm-development`} />
        <Route path={`/erp-development`} />
        <Route path={`/inventory-system-development`} />
        <Route path={`/product-development`} />

        {/* Service list  software-development */}
        <Route path={`/client-server-applications`} />
        <Route path={`/component-development`} />
        <Route path={`/database-applications`} />
        <Route path={`/maintenance-enhancement`} />
        <Route path={`/software-development`} />

        {/* Service list  web-development*/}
        <Route path={`/custom-web-development`} />
        <Route path={`/ecommerce-development`} />
        <Route path={`/mlm-development`} />
        <Route path={`/web-development`} />
        {/* Service list  wordpress-development*/}
        <Route path={`/wordpress-development`} />
        <Route path={`/wordpress-customization`} />
        <Route path={`/wordpress-security-fixes`} />
        <Route path={`/wordpress-plugin-development`} />
        <Route path={`/wordpress-theme-development`} />




        <Route path={`/angular`} />
        <Route path={`/react-js`} />
        <Route path={`/php-development`} />
        <Route path={`/lavavel-development`} />

        <Route path={`/codeignite-development`} />

        <Route path={`/android`} />
        <Route path={`/ios`} />
        <Route path={`/react-native`} />

        <Route path={`/wordpress-developments`} />
        <Route path={`/magento-development`} />
        <Route path={`/joomla-development`} />
        <Route path={`/drupal-development`} />

        {/* <Route path={`/portfolio`} element={<Portfolio />} /> */}
        <Route path={`/portfolio`} />

        {/* <Route path={`/portfolio`} element={} /> */}
        {/* Blocks Elements  */}




        <Route path='*' /> // No-match case
    </Routes>
);