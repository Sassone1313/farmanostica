import React, { useEffect, useState, useContext } from 'react'
import style from './fieldDisplayTable.module.scss'
import Action_remove from '../../icons/action_remove.svg'
import { SortableContext, sortableKeyboardCoordinates, verticalListSortingStrategy, } from '@dnd-kit/sortable';
import { useDroppable, useSortable } from '@dnd-kit/core';
import { locationContext } from '../../App';
import SortableItem from './SortableItem';
import { CSS } from '@dnd-kit/utilities';

function FieldDisplayTable({ allFields, setAllFields, selectFieldOptions, moveItem }) {
  const fieldLocation = useContext(locationContext);
  const [fields, setFields] = useState(allFields || []);
  const [warningPopUp, setWarningPopUp] = useState({ show: false, id: null, type: null });
  const { setNodeRef, isOver } = useDroppable({ id: "field-droppable" });
  const [fadeOut, setFadeOut] = useState(false);

  useEffect(() => {
    if (warningPopUp.type === true) {
      setFadeOut(false);
      const timer1 = setTimeout(() => setFadeOut(true), 2500); // Start fade after 2.5s
      const timer2 = setTimeout(() => setWarningPopUp({ show: false, id: null, type: null }), 3000); // Remove after 3s
      return () => {
        clearTimeout(timer1);
        clearTimeout(timer2);
      };
    }
    setFields(allFields);
  }, [allFields, warningPopUp]);

  function handleRemoveingFields(id) {

    const updatedFields = allFields.filter(value => value.id !== id);
    setAllFields(updatedFields);
    setWarningPopUp({ show: false, id: null });
  }

  return (
    <SortableContext strategy={verticalListSortingStrategy} items={allFields.map((items) => items.id)}>
      <div ref={setNodeRef}  className={style.fieldDisplayTable_main_container}>
        {fields.map((obj, index) => {
          if (obj.location === fieldLocation) {
            if (['text', 'email', 'tel', 'number'].includes(obj.type)) {
              return (
                <SortableItem
                  key={obj.id}
                  id={obj.id}
                  index={index}
                  moveItem={moveItem}
                >
                  <div className={style.fieldDisplayTable_header} key={obj.id}>
                    {warningPopUp.type === true && warningPopUp.id === obj.id && (
                      <div className={`${style.fieldDisplayTable_topright_warning} ${fadeOut ? style.fadeOut : ''}`}>
                        <span>This default field cannot be removed.</span>
                      </div>
                    )}

                    <div onMouseDown={() => selectFieldOptions(obj.id)} className={style.FieldDisplayTable_fields} tabIndex={0}>
                      <div className={style.fieldDisplayTable_field_label_container}>
                        <div className={style.fieldDisplayTable_field_label_wrapper}>
                          <label className={style.fieldDisplayTable_field_label} htmlFor="field-label">{obj.label}</label>
                          {obj.required && <span className={style.fieldDisplayTable_required}>*</span>}
                        </div>
                        <div title='Remove'
                          onMouseDown={e => {
                            e.stopPropagation();
                            setWarningPopUp({ show: true, id: obj.id, type: obj.isDefault });
                          }}
                          className={style.fieldDisplayTable_fields_container}
                        >
                          <img
                            src={Action_remove}
                            alt="Remove field"
                            style={obj.isDefault ? { opacity: 0.5 } : undefined}
                            className={style.fieldDisplayTable_remove_icon}
                          />                        </div>
                      </div>
                      <input
                        autoComplete="off"
                        className={style.fieldDisplayTable_input}
                        id="field-label"
                        aria-required="true"
                      />
                    </div>
                    {/* -----------------popup warning---------------- */}
                    {warningPopUp.show && warningPopUp.id === obj.id && warningPopUp.type !== true && (
                      <div className={style.fieldDisplayTable_remove_warning_container}>
                        <div className={style.fieldDisplayTable_warning}>
                          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#FF0000" strokeWidth="2" />
                            <path d="M12 6V12" stroke="#FF0000" strokeWidth="2" strokeLinecap="round" />
                            <circle cx="12" cy="16" r="1" fill="#FF0000" />
                          </svg>
                          <div> Do you want to delete this field?</div>
                        </div>
                        <div className={style.fieldDisplayTable_remove_warning_button}>
                          <div
                            onMouseDown={() => setWarningPopUp({ show: false, id: null })}
                            className={style.fieldDisplayTable_remove_warning_no_button}
                          >No</div>
                          <div
                            onMouseDown={() => handleRemoveingFields(obj.id)}
                            className={style.fieldDisplayTable_remove_warning_yes_button}
                          >Yes</div>
                        </div>
                      </div>
                    )}
                  </div>
                </SortableItem>
              )
            } else if (obj.type === 'select') {
              return (
                <SortableItem
                  key={obj.id}
                  id={obj.id}
                  index={index}
                // moveItem={moveItem}
                >


                  <div className={style.fieldDisplayTable_header} key={obj.id}>
                    {warningPopUp.type === true && warningPopUp.id === obj.id && (
                      <div className={`${style.fieldDisplayTable_topright_warning} ${fadeOut ? style.fadeOut : ''}`}>
                        <span>This default field cannot be removed.</span>
                      </div>
                    )}
                    <div onMouseDown={() => selectFieldOptions(obj.id)} className={style.FieldDisplayTable_fields} tabIndex={0}>
                      <div className={style.fieldDisplayTable_field_label_container}>
                        <div className={style.fieldDisplayTable_field_label_wrapper}>
                          <label className={style.fieldDisplayTable_field_label} htmlFor="field-label">{obj.label}</label>
                          {obj.required && <span className={style.fieldDisplayTable_required}>*</span>}
                        </div>
                        <div title='Remove'
                          onMouseDown={e => {
                            e.stopPropagation();
                            setWarningPopUp({ show: true, id: obj.id, type: obj.isDefault });
                          }}
                          className={style.fieldDisplayTable_fields_container}
                        >
                          <img
                            src={Action_remove}
                            alt="Remove field"
                            style={obj.isDefault ? { opacity: 0.5 } : undefined}
                            className={style.fieldDisplayTable_remove_icon}
                          />
                        </div>
                      </div>
                      <select
                        className={style.fieldDisplayTable_input}
                        id="field-label"
                        aria-required="true"
                      >
                        <option value="text">Select Options</option>

                      </select>
                    </div>
                    {warningPopUp.show && warningPopUp.id === obj.id && warningPopUp.type !== true && (
                      <div className={style.fieldDisplayTable_remove_warning_container}>
                        <div className={style.fieldDisplayTable_warning}>
                          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#FF0000" strokeWidth="2" />
                            <path d="M12 6V12" stroke="#FF0000" strokeWidth="2" strokeLinecap="round" />
                            <circle cx="12" cy="16" r="1" fill="#FF0000" />
                          </svg>
                          <div> Do you want to delete this field?</div>
                        </div>
                        <div className={style.fieldDisplayTable_remove_warning_button}>
                          <div
                            onMouseDown={() => setWarningPopUp({ show: false, id: null })}
                            className={style.fieldDisplayTable_remove_warning_no_button}
                          >No</div>
                          <div
                            onMouseDown={() => handleRemoveingFields(obj.id)}
                            className={style.fieldDisplayTable_remove_warning_yes_button}
                          >Yes</div>
                        </div>
                      </div>
                    )}
                  </div>
                </SortableItem>
              )
            } else if (obj.type === 'checkbox') {
              return (
                <SortableItem
                  key={obj.id}
                  id={obj.id}
                  index={index}
                // moveItem={moveItem}
                >
                  <div className={style.fieldDisplayTable_header} key={obj.id}>
                    {warningPopUp.type === true && warningPopUp.id === obj.id && (
                      <div className={`${style.fieldDisplayTable_topright_warning} ${fadeOut ? style.fadeOut : ''}`}>
                        <span>This default field cannot be removed.</span>
                      </div>
                    )}

                    <div onMouseDown={() => selectFieldOptions(obj.id)} className={style.FieldDisplayTable_fields} tabIndex={0}>
                      <div className={style.fieldDisplayTable_field_label_container}>
                        <div className={style.fieldDisplayTable_field_label_wrapper}>

                        </div>
                        <div title='Remove'
                          onMouseDown={e => {
                            e.stopPropagation();
                            setWarningPopUp({ show: true, id: obj.id, type: obj.isDefault });
                          }}
                          className={style.fieldDisplayTable_fields_container}
                        >
                          <img
                            src={Action_remove}
                            alt="Remove field"
                            style={obj.isDefault ? { opacity: 0.5 } : undefined}
                            className={style.fieldDisplayTable_remove_icon}
                          />
                        </div>
                      </div>
                      <div className={style.fieldDisplayTable_field_label_wrapper}>
                        <div className={style.fieldDisplayTable_input_checkbox} >
                          <input
                            type='checkbox'
                            // className={style.fieldDisplayTable_input_checkbox}
                            id="checkbox-field"
                            aria-required="true"
                          />
                        </div>
                        <label className={style.fieldDisplayTable_field_label} htmlFor="field-label">{obj.label}</label>
                        {obj.required && <span className={style.fieldDisplayTable_required}>*</span>}
                      </div>

                    </div>
                    {/* -----------------popup warning---------------- */}
                    {warningPopUp.show && warningPopUp.id === obj.id && warningPopUp.type !== true && (
                      <div className={style.fieldDisplayTable_remove_warning_container}>
                        <div className={style.fieldDisplayTable_warning}>
                          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="#FF0000" strokeWidth="2" />
                            <path d="M12 6V12" stroke="#FF0000" strokeWidth="2" strokeLinecap="round" />
                            <circle cx="12" cy="16" r="1" fill="#FF0000" />
                          </svg>
                          <div> Do you want to delete this field?</div>
                        </div>
                        <div className={style.fieldDisplayTable_remove_warning_button}>
                          <div
                            onMouseDown={() => setWarningPopUp({ show: false, id: null })}
                            className={style.fieldDisplayTable_remove_warning_no_button}
                          >No</div>
                          <div
                            onMouseDown={() => handleRemoveingFields(obj.id)}
                            className={style.fieldDisplayTable_remove_warning_yes_button}
                          >Yes</div>
                        </div>
                      </div>
                    )}
                  </div>
                </SortableItem>
              )
            }
          }
          return null;
        })}
      </div>
    </SortableContext>
  )
}

export default FieldDisplayTable