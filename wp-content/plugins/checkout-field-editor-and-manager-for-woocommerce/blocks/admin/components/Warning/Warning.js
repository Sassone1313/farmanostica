import React, { useState, useEffect } from 'react';
import style from './warning.scss';

function Warning() {
    const [warning, setWarning] = useState(false);

    useEffect(() => {
        if (window.acoAdminData && window.acoAdminData.checkout_classic === "true") {
            setWarning(true);
        }
    }, [window.acoAdminData]);

    return (

        <>

            {warning && (

                <div className='notification_block'>
                    <p>
    
                           You're editing fields for the block checkout, but your site is currently using the classic checkout. <br />
                
                    </p>
                </div>


            )}
        </>

    )
}

export default Warning

