import React, { useEffect } from 'react'
import style from './general.module.scss';
import { useState } from 'react';
import Setting from './../../icons/settings.svg';
import AngleDown from './../../icons/angle-down.svg';
import AngleUp from './../../icons/angle-up.svg';
import ToggleSwitch from './../ToggleSwitch/ToggleSwitch';
import Trash from './../../icons/trash.svg';
import { SortableContext, verticalListSortingStrategy } from '@dnd-kit/sortable';
import SortableItem from './SeleteFieldSortableItems';
import { useDroppable } from '@dnd-kit/core';

function General({ selectedFieldId, allfields, handleFields, setAllFields }) {

    const defaultLabels = [
        { id: 1, value: 'option - 1', label: 'Option - 1' },
        { id: 2, value: 'option - 2', label: 'Option - 2' },
    ];
    
    const { setNodeRef } = useDroppable({ id: "field-droppable" });
    const [dragging, setDragging] = useState(true);
    const [duplicateIds, setDuplicateIds] = useState([]);

    // Find the current field
    const currentField = allfields?.find(obj => obj.id === selectedFieldId);

    // Get options for select fields
    const options = currentField?.options && currentField.options.length > 0 
        ? currentField.options 
        : defaultLabels;

    // Update duplicate detection when options change
    useEffect(() => {
        if (!options || options.length === 0) {
            setDuplicateIds([]);
            return;
        }

        const valueCountMap = {};
        const duplicates = [];

        options.forEach(option => {
            if (valueCountMap[option.value]) {
                duplicates.push(option.id);
            } else {
                valueCountMap[option.value] = option.id;
            }
        });

        setDuplicateIds(duplicates);
    }, [options]);

    function handleNewFields() {
        const newOption = {
            id: Date.now(),
            value: '',
            label: '',
        };

        const updatedOptions = [...options, newOption];
        updateLocalFields(updatedOptions);
    }

    // Update allfields with new options
    const updateLocalFields = (value) => {
        if (!allfields || !selectedFieldId) return;
        
        setAllFields(
            allfields.map(obj =>
                obj.id === selectedFieldId
                    ? { ...obj, options: value }
                    : obj
            )
        );
    };

    function removeOptionFields(id) {
        const removeOptions = options.filter(obj => obj.id !== id);
        updateLocalFields(removeOptions);
    }

    // Check if a specific option ID is a duplicate
    const isDuplicate = (optionId) => {
        return duplicateIds.includes(optionId);
    };

    return (
        <>
            <div onClick={() => setDragging(!dragging)} className={style.general_main_container}>
                <div className={style.general_container}>
                    <img src={Setting} alt="Settings Icon" className={style.general_icon} />
                    <h3 className={style.general_title}>General</h3>
                </div>
                <div className={style.general_up_down_arrow}>
                    {dragging ? (
                        <div className={style.general_arrow}>
                            <img src={AngleUp} alt="Angle Up Icon" className={style.general_arrow_icon} />
                        </div>
                    ) : (
                        <div className={style.general_arrow}>
                            <img src={AngleDown} alt="Angle Down Icon" className={style.general_arrow_icon} />
                        </div>
                    )}
                </div>
            </div>

            {dragging && currentField && (
                <div>
                    <div className={style.general_input_container}>
                        <div className={style.general_input_label}>Field Label</div>
                        <input 
                            type="text" 
                            name='label' 
                            value={currentField.label || ""} 
                            onChange={(e) => handleFields(e, currentField.id)} 
                            className={style.general_input} 
                            placeholder="Enter field label" 
                        />
                    </div>

                    <div className={style.general_toggle_container}>
                        <div className={`${style.general_input_label} ${currentField.isDefault ? style.general_input_default_disable : ''}`}>
                            Enable/Disable Field
                        </div>
                        <div className={style.general_toggle_button}>
                            <ToggleSwitch
                                name="enable"
                                action={currentField.enable}
                                id={currentField.id}
                                handleFields={handleFields}
                                isDefault={currentField.isDefault}
                            />
                        </div>
                    </div>

                    {/* Placeholder for select fields */}
                    {currentField.type === 'select' && !currentField.isDefault && (
                        <div className={style.general_input_container}>
                            <div className={style.general_input_label}>Field Placeholder</div>
                            <input
                                type="text"
                                name="placeholder"
                                value={currentField.placeholder || ""}
                                onChange={(e) => handleFields(e, currentField.id)}
                                className={style.general_input}
                                placeholder="Enter placeholder"
                            />
                        </div>
                    )}

                    <div className={style.general_toggle_container}>
                        <div className={style.general_input_label}>Is Required</div>
                        <div className={style.general_toggle_button}>
                            <ToggleSwitch
                                name="required"
                                action={currentField.required}
                                id={currentField.id}
                                handleFields={handleFields}
                                isDefault={currentField.isDefault}
                            />
                        </div>
                    </div>

                    <div className={style.general_input_container}>
                        <div className={style.general_input_label}>Field Name</div>
                        <input
                            type="text"
                            value={currentField.id}
                            className={`${style.general_input} ${currentField.isDefault ? style.general_input_static : ""}`}
                            placeholder=""
                            readOnly={true}
                        />
                        <span className={style.general_input_span}>
                            * Name must be unique
                        </span>
                    </div>

                    {/* Field Description for text fields */}
                    {currentField.type === 'text' && (
                        <div className={style.general_input_container}>
                            <div className={style.general_input_label}>Field Description</div>
                            <input 
                                type="text" 
                                name='description' 
                                value={currentField.description || ""} 
                                onChange={(e) => handleFields(e, currentField.id, 'description')} 
                                className={style.general_input} 
                                placeholder="" 
                            />
                        </div>
                    )}

                    {/* Field Options for select fields */}
                    {currentField.type === 'select' && !currentField.isDefault && (
                        <div className={style.general_input_container}>
                            <div className={style.general_input_label}>Field Options</div>
                            <SortableContext
                                strategy={verticalListSortingStrategy}
                                items={options.map((items) => items.id)}
                            >
                                <div ref={setNodeRef} className={style.general_option_main_container}>
                                    {options.map((sub) => (
                                        <SortableItem key={sub.id} id={sub.id}>
                                            <div className={`${style.general_option_label_value} ${isDuplicate(sub.id) ? style.general_option_label_error : ''}`}>
                                                <div className={style.general_option_label}>
                                                    <label className={style.general_input_label}>Label</label>
                                                    <div className={style.general_option_value}>
                                                        <input
                                                            type="text"
                                                            name='label'
                                                            value={sub.label || ""}
                                                            onChange={(e) => handleFields(e, currentField.id, sub.id)}
                                                            className={style.general_input}
                                                            placeholder="Enter option value"
                                                        />
                                                    </div>
                                                </div>
                                                <div className={style.general_option_label}>
                                                    <label className={style.general_input_label}>Value</label>
                                                    <span className={style.general_input_span_required}>*</span>
                                                    <div className={style.general_option_value}>
                                                        <input
                                                            type="text"
                                                            value={sub.value || ""}
                                                            name='value'
                                                            onChange={(e) => handleFields(e, currentField.id, sub.id)}
                                                            className={style.general_input}
                                                            placeholder="Enter option label"
                                                        />
                                                    </div>
                                                </div>
                                                {options.length !== 1 && (
                                                    <div
                                                        onClick={() => removeOptionFields(sub.id)}
                                                        className={style.general_option_delete}
                                                    >
                                                        <img
                                                            src={Trash}
                                                            alt="Delete Icon"
                                                            className={style.general_option_delete_icon}
                                                        />
                                                    </div>
                                                )}
                                            </div>
                                        </SortableItem>
                                    ))}
                                </div>
                                {duplicateIds.length > 0 && (
                                    <span style={{ color: '#f13939', marginLeft: 8 }}>
                                        Value must be unique
                                    </span>
                                )}
                            </SortableContext>

                            <div className={style.general_option_add_new_container}>
                                <button onClick={handleNewFields} className={style.general_option_add_new_button}>
                                    Add new
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            )}
        </>
    )
}

export default General