import React from 'react'

const CourseList = () => {
  return (
    <React.Fragment>
         
        
          {/* Start Columns Area  */}
          <div className="rn-columns-area ptb--120 bg_color--1">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-8 col-md-12 col-12">
                                <div className="course-list-column-1">
                                    <div className='row mt--5'>
                                    <div className="col-lg-9 col-md-12 col-12 ">
                                      <h3 className='ml--25 mt--5'>Introduction to Front-End Development</h3>
                                      <div className="single-tab-content ml--25 mt--5">
                                        <h5>What you'll learn</h5>
                                        <li>Distinguish between front-end, back-end, and full-stack developers.</li>
                                        <li>Create and style a webpage with HTML and CSS.</li>
                                        <li>The benefits of working with UI frameworks.</li>

                                      </div>
                                    </div>
                                    <div className="col-lg-3 col-md-12 col-12 ">
                                        <a className='rn-btn mt--5' >Course Details</a>
                                    </div>

                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4 col-md-12 col-12 mt_sm--30">
                                <div className="course-list-column-2">
                                       
                                <div className="col-lg-12 col-md-12 col-12 mt_sm--30 ptb--30">
                                    <h3 className='text-center'>Instructor</h3>
                                </div>
                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/* Start Columns Area  */}
                

     
          
     
    </React.Fragment>
  )
}

export default CourseList;

