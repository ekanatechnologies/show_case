import React from 'react'
import { BrowserRouter, Route, Routes } from 'react-router-dom';
// import PageScrollTop from './component/PageScrollTop';
import Paralax  from './home/Paralax';
// import HeaderThree  from './component/header/HeaderThree';

// Import pages files
import  BannerDesign from './servicepage/service/design-services/BannerDesign';
import DesignServices from  "./servicepage/service/design-services/DesignServices";
import LogoDesign from  "./servicepage/service/design-services/LogoDesign";
import WebDesign from  "./servicepage/service/design-services/WebDesign";
import DigitalMarketing from  "./servicepage/service/digital-marketing/DigitalMarketing";
import PayPerClick from  "./servicepage/service/digital-marketing/PayPerClick";
import SearchEngine from  "./servicepage/service/digital-marketing/SearchEngine";
import SocialMedia from  "./servicepage/service/digital-marketing/SocialMedia";

import DataMigrationServices from  "./servicepage/service/magento-services/DataMigrationServices";
import MagentoDesignServices from  "./servicepage/service/magento-services/MagentoDesignServices";
import DevelopmentServices from  "./servicepage/service/magento-services/DevelopmentServices";
import MagentoServices from  "./servicepage/service/magento-services/MagentoServices";

import AndroidApp from  "./servicepage/service/mobile-app-development/AndroidApp";
import Html5App from  "./servicepage/service/mobile-app-development/Html5App";
import HybridApp from  "./servicepage/service/mobile-app-development/HybridApp";
import IphoneApp from  "./servicepage/service/mobile-app-development/IphoneApp";
import MobileApp from  "./servicepage/service/mobile-app-development/MobileApp";

import CrmDevelopment from  "./servicepage/service/product-development/CrmDevelopment";
import ErpDevelopment from  "./servicepage/service/product-development/ErpDevelopment";
import InventorySystem from  "./servicepage/service/product-development/InventorySystem";
import ProductDevelopment from  "./servicepage/service/product-development/ProductDevelopment";

import ClientServer from  "./servicepage/service/software-development/ClientServer";
import ComponentDevelopment from  "./servicepage/service/software-development/ComponentDevelopment";
import Database from  "./servicepage/service/software-development/Database";
import MaintenanceEnhancement from  "./servicepage/service/software-development/MaintenanceEnhancement";
import SoftwareDevelopment from  "./servicepage/service/software-development/SoftwareDevelopment";

import CustomWeb from  "./servicepage/service/web-development/CustomWeb";
import Ecommerce from  "./servicepage/service/web-development/Ecommerce";
import Mlm from  "./servicepage/service/web-development/Mlm";
import WebDevelopment from  "./servicepage/service/web-development/WebDevelopment";

import SecurityFixes from  "./servicepage/service/wordpress-development/SecurityFixes";
import WordpressCustomization from  "./servicepage/service/wordpress-development/WordpressCustomization";
import WordpressDevelopment from  "./servicepage/service/wordpress-development/WordpressDevelopment";
import WordpressPlugin from  "./servicepage/service/wordpress-development/WordpressPlugin";
import Wordpresstheme from  "./servicepage/service/wordpress-development/Wordpresstheme";

// Technologies
import Angular from  "./servicepage/technologies/Angular";
import ReactWeb from  "./servicepage/technologies/ReactWeb";
import Codeigniter from  "./servicepage/technologies/back-end-technologies/Codeigniter";
import Laravel from  "./servicepage/technologies/back-end-technologies/Laravel";
import Php from  "./servicepage/technologies/back-end-technologies/Php";

import Drupal from  "./servicepage/technologies/cms-echnologies/Drupal";
import Joomla from  "./servicepage/technologies/cms-echnologies/Joomla";
import Magento from  "./servicepage/technologies/cms-echnologies/Magento";
import Wordpress from  "./servicepage/technologies/cms-echnologies/Wordpress";

import Android from  "./servicepage/technologies/mobile-app-technologies/Android";
import Ios from  "./servicepage/technologies/mobile-app-technologies/Ios";
import ReactNative from  "./servicepage/technologies/mobile-app-technologies/ReactNative";

// Element Layout
// import Service from "./elements/Service";
// import ServiceDetails from "./elements/ServiceDetails";
import About from "./elements/About";
import Contact from "./elements/Contact";
// import PortfolioDetails from "./elements/PortfolioDetails";
import Blog from "./elements/Blog";
// import BlogDetails from "./elements/BlogDetails";
import ErrorPage from "./elements/ErrorPage";
// import Portfolio from "./blocks/Portfolio";
import TestHeader from './component/header/TestHeader';


import Footer from './component/footer/Footer';
// import Header from './component/header/Header';
import Gallery from './blocks/Gallery';
import PrivacyPolicy from './elements/legal/PrivacyPolicy';
import CookiePolicy from './elements/legal/CookiePolicy';
import IndustrialTraining from './elements/IndustrialTraining';
// import ServiceBanner from './elements/common/ServiceBanner';
import Career from './elements/Career';
import UiUxDesign from './elements/training/UiUxDesign';

// import PortFolios from './blocks/fortfolios/PortFolios';






const App=()=> {
  return (
    <>
  
      <BrowserRouter>
        {/* <Header/> */}
           <TestHeader/>

          <Routes>
            <Route path={`/`} element={<Paralax />} />
            <Route path={`/privacy-policy`} element={<PrivacyPolicy/>} />
            <Route path={`/cookie-policy`} element={<  CookiePolicy/>} />
            <Route path={`/industrial-training`} element={< IndustrialTraining/>} />
            <Route path={`/uiux-design`} element={<UiUxDesign/>} />
            
            {/* Element Layot */}
            {/* <Route path={`/service`} element={<Service />} /> */}
            {/* <Route path={`/service-details`} element={<ServiceDetails />} /> */}
            <Route path={`/contact`} element={<Contact />} />
            <Route path={`/about`} element={<About />} />
            {/* <Route path={`/portfolio-details`} element={<PortfolioDetails />} /> */}
            <Route path={`/blog`} element={<Blog />} />
            {/* <Route path={`/blog-details-list`} element={<BlogDetails />} /> */}
            <Route path={`/career`} element={<Career/>} />
           
            {/* Service list Elements  */}
            <Route path={`/banner-design`} element={<BannerDesign />} />
            <Route path={`/design-services`} element={<DesignServices />} />
            <Route path={`/logo-design`} element={<LogoDesign />} />
            <Route path={`/web-design`} element={<WebDesign />} />

            <Route path={`/digital-marketing`} element={<DigitalMarketing />} />
            <Route path={`/pay-per-click-services`} element={<PayPerClick />} />
            <Route path={`/search-engine-optimization`} element={<SearchEngine />} />
            <Route path={`/social-media-optimization`} element={<SocialMedia />} />
            {/* Service list magento-services  */}
            <Route path={`/magento-data-migration-services`} element={<DataMigrationServices />} />
            <Route path={`/magento-design-services`} element={<MagentoDesignServices />} />
            <Route path={`/magento-development-services`} element={<DevelopmentServices />} />
            <Route path={`/magento-services`} element={<MagentoServices />} />
            {/* Service list  mobile-app-development */}
            <Route path={`/android-app-development`} element={<AndroidApp />} />
            <Route path={`/html5-app-development`} element={<Html5App />} />
            <Route path={`/hybrid-app-development`} element={<HybridApp />} />
            <Route path={`/iphone-app-development`} element={<IphoneApp />} />
            <Route path={`/mobile-app-development`} element={<MobileApp />} />

            {/* Service list  product-development */}
            <Route path={`/crm-development`} element={<CrmDevelopment />} />
            <Route path={`/erp-development`} element={<ErpDevelopment />} />
            <Route path={`/inventory-system-development`} element={<InventorySystem />} />
            <Route path={`/product-development`} element={<ProductDevelopment />} />

            {/* Service list  software-development */}
            <Route path={`/client-server-applications`} element={<ClientServer />} />
            <Route path={`/component-development`} element={<ComponentDevelopment />} />
            <Route path={`/database-applications`} element={<Database />} />
            <Route path={`/maintenance-enhancement`} element={<MaintenanceEnhancement />} />
            <Route path={`/software-development`} element={<SoftwareDevelopment />} />

            {/* Service list  web-development*/}
            <Route path={`/custom-web-development`} element={<CustomWeb />} />
            <Route path={`/ecommerce-development`} element={<Ecommerce />} />
            <Route path={`/mlm-development`} element={<Mlm />} />
            <Route path={`/web-development`} element={<WebDevelopment />} />
            {/* Service list  wordpress-development*/}
            <Route path={`/wordpress-development`} element={<WordpressDevelopment />} />
            <Route path={`/wordpress-customization`} element={<WordpressCustomization />} />
            <Route path={`/wordpress-security-fixes`} element={<SecurityFixes />} />
            <Route path={`/wordpress-plugin-development`} element={<WordpressPlugin />} />
            <Route path={`/wordpress-theme-development`} element={<Wordpresstheme />} />

            {/* Service list  wordpress-development*/}
           {/*  Technologies list */}
            {/* <Route path={`/headerThree`} element={<HeaderThree />} /> */}


            <Route path={`/angular`} element={<Angular />} />
            <Route path={`/react-js`} element={<ReactWeb />} />
            <Route path={`/php-development`} element={<Php />} />
            <Route path={`/lavavel-development`} element={<Laravel />} />

            <Route path={`/codeignite-development`} element={<Codeigniter />} />

            <Route path={`/android`} element={<Android />} />
            <Route path={`/ios`} element={<Ios />} />
            <Route path={`/react-native`} element={<ReactNative />} />

            <Route path={`/wordpress-developments`} element={<Wordpress />} />
            <Route path={`/magento-development`} element={<Magento />} />
            <Route path={`/joomla-development`} element={<Joomla />} />
            <Route path={`/drupal-development`} element={<Drupal />} />

            {/* <Route path={`/portfolio`} element={<Portfolio />} /> */}
            <Route path={`/portfolio`} element={<Gallery/>} />

            
            {/* <Route path={`/portfolio`} element={<Service/>} /> */}
            {/* Blocks Elements  */}
    
           
            {/* PortFolioTest */}

        
           

            <Route path={`*`} element={<ErrorPage/>} />
            <Route element={<ErrorPage />} />

          </Routes>

          <Footer/>

      </BrowserRouter>
    </>
  );
}



export default App;
