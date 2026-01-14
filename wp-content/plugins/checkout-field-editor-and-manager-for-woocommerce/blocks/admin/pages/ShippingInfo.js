import React, { useState, useEffect, useCallback } from 'react';
import FieldDisplayTable from '../components/FieldDisplayTable/FieldDisplayTable';
import FieldsAndOptionsTable from '../components/FieldsAndOptionsTable/FieldsAndOptionsTable';

function ShippingInfo({ onSaveFields, allFields, setAllFields, handleFields, moveItem }) {

  const [fields, setFields] = useState(allFields);
  const [selectedFieldId, setSelectedFieldId] = useState();


  useEffect(() => {
    setFields(allFields);

  }, [allFields]);

  //handlefields 
  const selectFieldOptions = (id) => {

    setSelectedFieldId(id);

  }


  return (
    <div className="aco-contact-info">
      <div className='aco-field-main-container'>
        <FieldDisplayTable
          moveItem={moveItem}
          setAllFields={setAllFields}
          allFields={fields}
          selectFieldOptions={selectFieldOptions}


        />
        <FieldsAndOptionsTable
          setAllFields={setAllFields}
          allFields={fields}
          selectedFieldId={selectedFieldId}
          handleFields={handleFields}
        />
      </div>
    </div>
  );
}

export default React.memo(ShippingInfo);