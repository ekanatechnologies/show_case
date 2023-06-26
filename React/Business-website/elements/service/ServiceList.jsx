...js
import React  from "react";
import { FiCast, FiLayers, FiUsers, FiMonitor } from "react-icons/fi";

const ServiceList = [
    {
        icon: <FiCast />,
        title: 'Software Development',
        description: 'A robust, dynamic and proven method to offer software development solutions for small to large scale businesses.',
        link: "/software-development"
    },
    {
        icon: <FiLayers />,
        title: 'Web Development',
        description: 'We specialised in eCommerce, Pos, inventory custom web development for small to large scale business',
        link:"/web-development"
    },

    {
        icon: <FiUsers />,
        title: 'Mobile App Development',
        description: 'Drive your business with own mobile app based on Android and iOS. We develop mobile apps with efficient with enhanced UI.',
        link:"/mobile-app-development"
    },
    {
        icon: <FiMonitor />,
        title: 'Design Services',
        description: 'Boost & Reinforce your brand with attractive, optimize creative and amazing user interface and user experience.',
        link:"/design-services"
    },
    {
        icon: <FiCast />,
        title: 'WordPress Development',
        description: 'Design and Development with various advanced features for an eCommerce solutions to attract customers.',
        link:"/wordpress-development"
    },
    {
        icon: <FiMonitor />,
        title: 'Digital Marketing',
        description: 'Find your potential audience through Digital marketing. Drive your business on the digital platform with digital marketing.',
        link:"/digital-marketing"
    },
    //



]

const ServiceList = (props) => {
        const { column } = props;
        const ServiceContent = ServiceList.slice(0, props.item);

   return (
            <React.Fragment>
                <div className="row">
                    {ServiceContent.map((val, i) => (
                        <div className={`${column}`} key={i}>
                            <a href={val.link}>
                                <div className="service service__style--2">
                                    <div className="icon">
                                        {val.icon}
                                    </div>

                                    <div className="content">
                                        <h3 className="title">{val.title}</h3>
                                        <p>{val.description}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ))}
                </div>
            </React.Fragment>
        )
  
  
}



export default React.memo(ServiceThree);

