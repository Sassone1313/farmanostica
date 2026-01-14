import React, { useEffect } from 'react'
import style from './general.module.scss';
import { useState } from 'react';
import Setting from './../../icons/settings.svg'; // Adjust the path as necessary
import AngleDown from './../../icons/angle-down.svg'; // Adjust the path as necessary
import AngleUp from './../../icons/angle-up.svg'; // Adjust the path as necessary
import Slider from './../../icons/sliders.svg'; // Adjust the path as necessary



function General({ selectedFieldId, allfields, handleFields }) {

    const [dragging, setDragging] = useState(false);


    return (
       allfields.map((obj =>{
        if(obj.id === selectedFieldId ) {
            return (
                 <>
            <div onClick={() => setDragging(!dragging)} className={style.general_main_container}>
                <div className={style.general_container}>
                    <img src={Slider} alt="Settings Icon" className={style.general_icon} />
                    <h3 className={style.general_title}>Advanced</h3>
                </div>
                <div className={style.general_up_down_arrow}>

                    {dragging ? (
                        <div className={style.general_arrow} >
                            <img src={AngleUp} alt="Angle Up Icon" className={style.general_arrow_icon} />
                        </div>
                    ) : (
                        <div className={style.general_arrow} >
                            <img src={AngleDown} alt="Angle Down Icon" className={style.general_arrow_icon} />
                        </div>
                    )}

                </div>
            </div>
            <div>
                {dragging && obj && obj.id === selectedFieldId && (
                    <div >
                        {
                            obj.type === 'text' && !obj.isDefault ? (
                                <>
                              {
                                obj.fieldType === 'text' && (
                                          <div className={style.general_input_container}>
                                        <div className={style.general_input_label}>Allowed Characters(Regex)</div>
                                        <input type="text" name='pattern' value={obj.pattern} onChange={(e) => handleFields(e, obj.id, 'pattern')} className={style.general_input} placeholder=""  />
                                    </div>
                                ) 
                              }

                                    <div className={style.general_input_container}>
                                        <div className={style.general_input_label}>Custom Data</div>
                                        <input type="text" name='dataCustom' value={obj.dataCustom} onChange={(e) => handleFields(e, obj.id, 'dataCustom')} className={style.general_input}  />
                                    </div>
                                </>
                            ) : (
                               <div className={style.general_no_fields_container}> 
                                <h4>No fields available</h4>
                               </div>
                            )
                        }









                    </div>

                )
                    // ))

                }
            </div>


        </>
            )
        }
       }))
    )
}

export default General
