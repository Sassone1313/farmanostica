import { useState, useEffect } from 'react'
import React from 'react'
import style from './fieldsAndOptionsTable.module.scss'
import TabFields from '../TabFields/TabFields';
import General from '../TabOptions/General';
import Advanced from '../TabOptions/Advanced';
import { DndContext } from '@dnd-kit/core';
import { arrayMove } from '@dnd-kit/sortable'

function FieldsAndOptionsTable({ selectedFieldId, allFields, handleFields, setAllFields }) {
  const [displayFields, setDisplayFields] = useState(true);


  useEffect(() => {
    if (selectedFieldId) {
      setDisplayFields(false);
    } else {
      setDisplayFields(true);
    }

  }, [selectedFieldId])

  function handleDragEnd(event) {
    const { active, over } = event;

    const activeId = active.id;
    const overId = over.id;


    // Handle reordering options within a field
    setAllFields(prevFields => {
      return prevFields.map(field => {
        if (field.options && Array.isArray(field.options)) {
          const oldIndex = field.options.findIndex(option => option.id === activeId);
          const newIndex = field.options.findIndex(option => option.id === overId);

          if (oldIndex !== -1 && newIndex !== -1) {
            // Use arrayMove to reorder the options array
            field.options = arrayMove(field.options, oldIndex, newIndex);
          }
        }
        return field;
      });
    });

  }

    const moveItem = (fromIndex, toIndex) => {
      setAllFields((prev) => {
  
        if (toIndex >= 0 && toIndex < prev.length) {
          return arrayMove(prev, fromIndex, toIndex);
        }
        return prev;
      });
    };




  return (

 
    <div className={style.fieldsAndOptionsTable_main_container}>
      
      <div className={style.fieldsAndOptionsTable_header}>
        <div className={`${style.FieldsAndOptionsTable_title} ${displayFields ? style.active : ''}`}
          onClick={() => {
            setDisplayFields(true);

          }}>
          Fields
        </div>
        <div className={`${style.FieldsAndOptionsTable_title} ${!displayFields ? style.active : ''}`}
          onClick={() => {
            setDisplayFields(false);

          }}>
          Options
        </div>
      </div>
      <div>
        {displayFields && (
          <TabFields />
        )}
        {
          !displayFields && (
            <>
              <DndContext onDragEnd={handleDragEnd}>
                <General
                  setAllFields={setAllFields}
                  selectedFieldId={selectedFieldId}
                  allfields={allFields}
                  handleFields={handleFields}
                />
              </DndContext>

              <Advanced
                setAllFields={setAllFields}
                selectedFieldId={selectedFieldId}
                allfields={allFields}
                handleFields={handleFields}
              />
            </>

          )
        }

      </div>
    </div>
  )
}

export default FieldsAndOptionsTable
