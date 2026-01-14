import React, { useState } from 'react';
import style from './resetAlert.module.scss'

const ResetAlert = ({ setResetPopUP, resetFields, isLoading }) => {




    return (

<div onClick={() => setResetPopUP(false)} className={style.warp_container} >
            <div className={style.wrap}>
            <h2 > {wp.i18n.__('Are you sure you want to reset?')}</h2>
            <div className={style.mPopUp} > This will reset to the default fields<br /> All your changes will be deleted.</div>
            <button className={style.buttonNo} onClick={() => setResetPopUP(false)}  >Cancel </button>
            <button className={`${style.buttonYes} ${isLoading.reset ? style.loading : ''}`} onClick={() => resetFields()} >
                {isLoading.reset ? (
                    <span >Resetting...</span>
                ) :
                    'Yes, please reset'
                }

            </button>
        </div>
</div>

    )
}

export default ResetAlert
