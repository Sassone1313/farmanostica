import React, { useState, useEffect, useCallback } from 'react';
import FieldDisplayTable from '../components/FieldDisplayTable/FieldDisplayTable';
import FieldsAndOptionsTable from '../components/FieldsAndOptionsTable/FieldsAndOptionsTable';
import { DndContext } from '@dnd-kit/core';

function ContactInfo({ onSaveFields, allFields, setAllFields, handleFields, moveItem }) {

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
          allFields={fields}
          setAllFields={setAllFields}
          selectedFieldId={selectedFieldId}
          handleFields={handleFields}
        />
      </div>
    </div>


  );
}

export default React.memo(ContactInfo);