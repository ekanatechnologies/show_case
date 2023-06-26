import React, { useState } from 'react';

import Modal from 'react-bootstrap/Modal';
import ContactFour from '../contact/ContactFour';

const TrainningList = [
    {
        images: 'assets/images/training/ux-pro.jpg',
        title: 'Ui/Ux Design',
        alt:' Ui/Ux Design development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/css-html.jpg',
        title: 'HTML5 & CSS3',
        alt:'HTML5 & CSS3 development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/css5-and-html.jpg',
        title: 'HTML5,CSS3 and JavaScript',
        alt:'HTML5,CSS3 and JavaScript development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/sql-.jpg',
        title: 'Php And MySql',
        alt:'Php And MySql development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/codeigniter-port.jpg',
        title: 'Php, MySql and CodeIgniter',
        alt:'Php, MySql and CodeIgniter development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/php_sql_code.jpg',
        title: 'Php, MySql and Laravel',
        alt:'Php, MySql and Laravel development and  Trainning services in Lucknow'
    },
   
    {
        images: 'assets/images/training/node_js.jpg',
        title: 'NodeJs',
        alt:'NodeJs development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/react_js.jpg',
        title: 'ReactJs',
        alt:'ReactJs development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/angular-js.jpg',
        title: 'AngularJs ',
        alt:'AngularJs development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/sco-in.png',
        title: 'Digital Marketing',
        alt:'Digital Marketing development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/andrio.jpg',
        title: 'Android Development',
        alt:'Android Development development and  Trainning services in Lucknow'

    },
   
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'C#, C++',
        alt:'C#, C++ development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Java',
        alt:'Java development and  Trainning services in Lucknow'

    },
    //


    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Python',
        alt:'Python development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Front End Web Development',
        alt:'Front End Web Development  and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/2324840-copy.png',
        title: '.Net Framework',
        alt:'.Net Framework development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Python for Data Science',
        alt:'Python for Data Science development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Aws Developer Training',
        alt:'Aws Developer Training development and  Trainning services in Lucknow'

    },
   
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Internet of Things (IoT)',
        alt:'Internet of Things (IoT) development and  Trainning services in Lucknow'

    },
    {
        images: 'assets/images/training/2324840-copy.png',
        title: 'Artificial Intelligence',
        alt:'Artificial Intelligence development and  Trainning services in Lucknow'

    },
]



const ServiceOne = () => {
    const [show, setShow] = useState(false);

    const handleClose = () => setShow(false);
    // const handleShow = () => setShow(true);

    return (
        <React.Fragment>
            <div className="container">
                <h2 className='text-center mt--30'>Discover Our Training </h2>
                <p className='text-center'>Our courses are built in partnership with technology leaders and are relevant to industry needs.
                    Upon completing a course, you'll receive a verified completion certificate recognized by industry leaders</p>
                <div className="row">
                    {TrainningList.map((val, i) => (
                        <div className="col-lg-3 col-md-4 col-sm-6 col-12" key={i}>
                            <div className="service service__style--1">
                                <div className="icon">
                                    <img width="100" height="300" loading="lazy" src={`${val.images}`} alt={`${val.alt}`} />
                                </div>
                                <div className="content">
                                    <h3 className="title">{val.title}</h3>
                                    <a className="rn-button-style--2 rn-btn-small-2" href='/uiux-design'>course </a>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>


                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        <Modal.Title>Enquire Now</Modal.Title>
                    </Modal.Header>
                    <Modal.Body>
                        <ContactFour />
                    </Modal.Body>

                </Modal>
            </div>

        </React.Fragment>
    )
}

export default ServiceOne;

