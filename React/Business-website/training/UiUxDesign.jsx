import React from "react";
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import { FiCheck } from "react-icons/fi";
import { Zoom } from "react-reveal";
import { FiUser } from "react-icons/fi";
import CourseList from "./CourseList";


const Testimonials = [
    {
        icon: <FiUser />,
        title: 'Felipe M.',
        description: "To be able to take courses at my own pace and rhythm has been an amazing experience. I can learn whenever it fits my schedule and mood."
    },
    {
        icon: <FiUser />,
        title: 'Jennifer J.',
        description: "I directly applied the concepts and skills I learned from my courses to an exciting new project at work."
    },
    {
        icon: <FiUser />,
        title: 'Larry W.',
        description: "When I need courses on topics that my university doesn't offer, Coursera is one of the best places to go."
    },
    {
        icon: <FiUser />,
        title: 'Chaitanya A.',
        description: "Learning isn't just about being better at your job: it's so much more than that. Coursera allows me to learn without limits."
    },



]


const UiUxDesign = () => {
    const tabStyle = "tab-style--1 "

    let
        tab1 = "About",
        tab2 = "Outcomes",
        tab3 = "Courses",
        tab4 = "Testimonials";


    return (
        <React.Fragment>

            {/* Start Columns Area  */}
            <div className="rn-columns-area ptb--120 bg_color--3">
                <div className="container">
                    <div className="row">
                        <div className="col-lg-8 col-md-6 col-12">
                            <div className="single-column">
                                <h2 className="tilte">Front-End Developer Professional Certificate</h2>
                                <p>Launch your career as a front-end developer. Build job-ready skills for an in-demand career and earn a credential from Meta. No degree or prior experience required to get started.</p>
                                <p>Instructor: Taught by Ekana Staff</p>
                                <div>
                                    <a className='rn-button-style--2 rn-btn-dark mt--5' >Enroll for Free <span>  Starts july 23</span></a>

                                </div>

                            </div>
                        </div>
                        <div className="col-lg-4 col-md-6 col-12 mt_sm--30">
                            <div className="single-column">
                                <div className="course-card">
                                    <div className="rn-course-card-list">
                                        <div className="rn-course-card">
                                            <div className="course-card-table-inner">
                                                <div className="course-card-header">
                                                    <h4 className="title">Professional Certificate - 9 course series</h4>
                                                     <span>Earn a career credential that demonstrates your expertise</span>
                                                </div>
                                                <div className="course-card-body">
                                                    <h5>Beginner level</h5>
                                                    <ul className="list-style--1">
                                                        <li>No previous experience necessary</li>
                                                     
                                                    </ul>
                                                    <h5>7 months at 6 hours a week</h5>
                                                    <h5>Flexible schedule</h5>
                                                    <p>Learn at your own pace</p>
                                                </div>
                                                {/* <div className="course-card-footer">
                                                    <a className="rn-btn" href="#pricing">Purchase Now</a>
                                                </div> */}
                                            </div>
                                        </div>

                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {/* Start Columns Area  */}

            {/* Start Tabs Area */}
            <div className="tabs-area">
                <div className="container">
                    <div className="row">
                        <h2 className="text-center">Find a career that works for you</h2>
                        <p className="text-center">Whatever your background or interests are, Professional Certificates have you covered.</p>
                        <div className="col-lg-12">
                            <Tabs>
                                <TabList className={`${tabStyle}`}>
                                    <Tab>{tab1}</Tab>
                                    <Tab>{tab2}</Tab>
                                    <Tab>{tab3}</Tab>
                                    <Tab>{tab4}</Tab>

                                </TabList>

                                <TabPanel>

                                    {/* Start Columns Area  */}
                                    <div className="rn-columns-area ptb--120 bg_color--1">
                                        <div className="container">
                                            <Zoom bottom>
                                                <div className="row">
                                                    <h3>What you'll learn</h3>
                                                    <div className="col-lg-6 col-md-6 col-12">
                                                        <div className="single-column">
                                                            <li><p>  Create a responsive website using HTML to structure content, CSS to handle visual style, and JavaScript to develop interactive experiences.  </p> </li>
                                                            <li><p> Learn Bootstrap CSS Framework to create webpages and work with GitHub repositories and version control.</p></li>

                                                        </div>
                                                    </div>
                                                    <div className="col-lg-6 col-md-6 col-12 mt_sm--30">
                                                        <div className="single-column">
                                                            {/* <h4 className="tilte">One Half</h4> */}
                                                            <li><p>Learn to use React in relation to Javascript libraries and frameworks.</p></li>
                                                            <li><p> Prepare for a coding interview, learn best approaches to problem-solving, and build portfolio-ready projects you can share during job interviews.</p></li>

                                                        </div>
                                                    </div>
                                                </div>
                                            </Zoom>
                                        </div>
                                    </div>
                                    {/* Start Columns Area  */}

                                </TabPanel>

                                <TabPanel>
                                    <div className="single-tab-content">

                                        <Zoom bottom>
                                            <div className="row sercice-details-content align-items-center">

                                                <div className="col-lg-12 col-12 order-2 order-lg-1">
                                                    <div className="details mt_md--30 mt_sm--30">
                                                        <h4 className="title">Prepare for a career in Front-end Development</h4>

                                                        <ul className="liststyle">
                                                            <li>Receive professional-level training from Meta</li>
                                                            <li>Demonstrate your proficiency in portfolio-ready projects</li>
                                                            <li>Earn an employer-recognized certificate from Meta</li>
                                                            <li>Qualify for in-demand job titles: Front-End Developer, Website Developer, Software Engineer</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </Zoom>
                                    </div>
                                </TabPanel>



                                <TabPanel>
                                    <div className="single-tab-content">
                                        <Zoom bottom>
                                            <h3>Professional Certificate - 9 course series</h3>
                                            <p>Want to get started in the world of coding and build websites as a career? This certificate, designed by the software engineering experts at Meta—the creators of Facebook and Instagram, will prepare you for a career as a front-end developer.</p>
                                            <p>Upon completion, you'll get access to the Meta Career Programs Job Board—a job search platform that connects you with 200+ employers who have committed to sourcing talent through Meta's certificate programs, as well as career support resources to help you with your job search. </p>
                                            <p>In this program, you'll learn: </p>



                                            <li>
                                                <p> How to code and build interactive web pages using HTML5, CSS and JavaScript.
                                                </p>


                                            </li>
                                            <li>
                                                <p>In-demand design skills to create professional page layouts using industry-standard tools such as Bootstrap, React, and Figma.
                                                </p>
                                            </li>
                                            <li>
                                                <p> GitHub repositories for version control, content management system (CMS) and how to edit images using Figma.
                                                </p>
                                            </li>
                                            <li>
                                                <p> How to prepare for technical interviews for front-end developer roles.</p>

                                            </li>
                                            <li>
                                                <p>By the end, you'll put your new skills to work by completing a real-world project where you'll create your own front-end web application. Any third-party trademarks and other intellectual property (including logos and icons) referenced in the learning experience remain the property of their respective owners. Unless specifically identified as such, Coursera’s use of third-party intellectual property does not indicate any relationship, sponsorship, or endorsement between Coursera and the owners of these trademarks or other intellectual property.
                                                </p>
                                            </li>
                                            <li><p>Applied Learning Project</p></li>
                                            <p>At the end of each course, you'll complete a project to test your new skills and ensure you understand the criteria before moving on to the next course. There are 9 projects in which you'll use a lab environment or a web application to perform tasks such as:

                                            </p>

                                            <li><p>Edit your Bio page—using your skills in HTML5, CSS and UI frameworks</p></li>
                                            <li><p>Edit your Bio page—using your skills in HTML5, CSS and UI frameworks</p></li>
                                            <li><p>Manage a project in GitHub—using version control in Git, Git repositories and the Linux Terminal </p></li>
                                            <li><p>Build a static version of an application—you'll apply your understanding of React, frameworks, routing, hooks, bundlers and data fetching. </p></li>

                                            <li><p>At the end of the program, there will be a Capstone project where you will bring your new skillset together to create the front-end web application.</p></li>
                                        </Zoom>

                                    </div>

                                    <CourseList />

                                </TabPanel>

                                <TabPanel>
                                    {/* Start Columns Area  */}

                                    <div className="service-area ptb--120 bg_color--1">
                                        <div className="container">
                                            <Zoom bottom>
                                                <div className="row">
                                                    <div className="col-lg-12">
                                                        <div className="section-title text-center mb--30">
                                                            <h2>Why people choose Ekana Technologies for their career</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Zoom>
                                            <Zoom bottom>
                                                <div className="row service-one-wrapper">
                                                    {Testimonials.map((val, i) => (
                                                        <div className="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12" key={i}>
                                                            <a className="text-center" href="/service-details">
                                                                <div className="service service__style--4">
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
                                            </Zoom >
                                        </div>
                                    </div>

                                    {/* Start Columns Area  */}
                                </TabPanel>

                            </Tabs>
                        </div>
                    </div>
                </div>
            </div>
            {/* End Tabs Area */}
        </React.Fragment>
    )
}




export default React.memo(UiUxDesign);
