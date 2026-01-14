import React, { useState, useEffect } from 'react';
import FieldDisplayTable from '../components/FieldDisplayTable/FieldDisplayTable';
import FieldsAndOptionsTable from '../components/FieldsAndOptionsTable/FieldsAndOptionsTable';
import './styles.scss';

function AdditionalInfo({  allFields, setAllFields, handleFields, moveItem }) {

  const [selectedFieldId, setSelectedFieldId] = useState();


  //handlefields 
  const selectFieldOptions = (id) => {

    setSelectedFieldId(id);

  }


  return (
    
   <>
    <div className="aco-contact-info">
      <div className='aco-field-main-container'>
        <FieldDisplayTable
          moveItem={moveItem}
          setAllFields={setAllFields}
          allFields={allFields}
          selectFieldOptions={selectFieldOptions}


        />
        <FieldsAndOptionsTable
          setAllFields={setAllFields}
          allFields={allFields}
          selectedFieldId={selectedFieldId}
          handleFields={handleFields}
        />
      </div>
    </div>
    </>

  );
}

export default AdditionalInfo;