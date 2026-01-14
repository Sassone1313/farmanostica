import React, { useState, useEffect } from 'react';
import { Routes, Route, HashRouter } from 'react-router-dom';
import BlockTabs from './components/BlockTabs/BlockTabs';
import AdditionalInfo from './pages/AdditionalInfo';
import ContactInfo from './pages/ContactInfo';
import ShippingInfo from './pages/ShippingInfo';
import CheckoutBar from './components/CheckoutBar/CheckoutBar';
import Settings from './icons/settings.svg';
import { DndContext } from '@dnd-kit/core';
import { arrayMove } from '@dnd-kit/sortable'
import ResetAlert from './components/PopAlert/ResetAlert';
import Warning from './components/Warning/Warning';
import './index.scss';
import Loadding from './utils/Loading/Loading';

export const locationContext = React.createContext();

const App = () => {

  let defaultLabels = [
    { id: 1, value: 'option - 1', label: 'Option - 1' },
    { id: 2, value: 'option - 2', label: 'Option - 2' },
  ]

  const [allFields, setAllFields] = useState([]);
  const [defaultFields, setDefaultFields] = useState({});
  const [updateField, setUpdateField] = useState([])
  const [isLoading, setIsLoading] = useState({
    reset: false,
    saving: false,
    loading: true,
  });
  const [error, setError] = useState(null);
  const [resetPopUp, setResetPopUP] = useState(false);
  const [warning, setWarning] = useState(false);


  useEffect(() => {
    if (window.acoAdminData.checkout_classic === "true") {
      setWarning(true);

    }

    fetchFields();
  }, []);

  const fetchFields = async () => {
    setIsLoading((prev) => (
      { ...prev, loading: true }
    ));
    try {
      setError(null);
      const [customFieldsData, defaultFieldsData] = await Promise.all([
        window.wp.apiFetch({ path: '/aco-wc-checkout/v1/settings' }),
        window.wp.apiFetch({ path: '/aco-wc-checkout/v1/default-fields' })
      ]);

      // Deduplicate custom fields by id
      const customFields = Array.isArray(customFieldsData) ?
        [... new Map(customFieldsData.map(field => [field.id, field])).values()] : [];

      // Convert default fields to array and mark as default
      const defaultFieldsArray = Object.entries(defaultFieldsData || {}).map(([id, field]) => ({
        ...field,
        id,
        isDefault: true,
      }));

      // Combine fields, prioritizing custom fields to avoid ID conflicts
      const allFields = [
        ...customFields,
        ...defaultFieldsArray.filter((df) => !customFields.some((cf) => cf.id === df.id)),
      ];

      setAllFields(allFields);
      setUpdateField(allFields)
      setDefaultFields(defaultFieldsData || {});
    }

    catch (error) {
      setError('Failed to load fields. Please try again.');
      console.error('Error fetching fields:', error);
      setAllFields([]);
    } finally {
      setIsLoading((prev) => (
        { ...prev, loading: false }));
      setResetPopUP(false)
    }
  }

const handleFields = (e, fieldId, subId = null) => {
  const { name, value, type, checked } = e.target;

  setAllFields((prev) =>
    prev.map((obj) => {
      if (obj.id !== fieldId) return obj;

      // Handle nested select options
      if (subId && obj.options) {
        
        return {
          ...obj,
          options: obj.options.map((opt) =>
            opt.id === subId
              ? { ...opt, [name]:  value }
              : opt
          ),
        };
      }
      // Handle normal fields
      return {
        ...obj,
        [name]: type === "checkbox" ? checked : value,
      };
    })
  );
};




  const saveFields = async (updatedFields) => {

    setIsLoading((prev) => (
      { ...prev, saving: true }
    ))

    try {

      let updatedFieldsvalue = updatedFields.map(obj => {
        return {
          ...obj,
          options: obj?.options?.filter(
            (item, index, arr) =>
              item?.value?.toString().trim() !== "" && // remove empty value
              item?.label?.toString().trim() !== "" && // remove empty label
              index === arr.findIndex(otherItem => otherItem.value === item.value) // remove duplicates
          )
        };
      });


      setAllFields(updatedFieldsvalue);

      await window.wp.apiFetch({
        path: '/aco-wc-checkout/v1/settings',
        method: 'POST',
        data: { fields: updatedFieldsvalue },
        headers: { 'X-WP-Nonce': window.acoWcCheckoutSettings.nonce },
      });

      const updatedFieldsArray = Object.values(updatedFieldsvalue.filter(obj => obj.isDefault === true)); // defaultFieldsObject is your object

      await window.wp.apiFetch({
        path: '/aco-wc-checkout/v1/default-fields',
        method: 'POST',
        data: { fields: updatedFieldsArray },
        headers: { 'X-WP-Nonce': window.acoWcCheckoutSettings.nonce },
      });

    } catch (error) {
      console.error('Error saving fields:', error);
    } finally {
      setIsLoading((prev) => (
        { ...prev, saving: false }
      ))
    }
  };

  const resetFields = async () => {
    setIsLoading((prev) => (
      { ...prev, reset: true }
    ))
    try {
      if (allFields.length > 11) {
        await Promise.all([
          window.wp.apiFetch({
            path: '/aco-wc-checkout/v1/reset_custom-fields',
            method: 'POST',
            headers: { 'X-WP-Nonce': window.acoWcCheckoutSettings.nonce },
          }),
          window.wp.apiFetch({
            path: '/aco-wc-checkout/v1/reset_default-fields',
            method: 'POST',
            headers: { 'X-WP-Nonce': window.acoWcCheckoutSettings.nonce },
          }),
        ]);
      } 
       window.location.reload();

    } catch (error) {

      console.error('Error Reset fields', error);

    } finally {
      setIsLoading((prev) => (
        { ...prev, reset: false }
      ))
      setResetPopUP(false);

    }
  }

  function handleDragEnd(event) {

    const { active, over } = event;
    if (!over) return;

    // Handle adding new fields or reordering existing fields
    const [id, location] = active.id.split(':');
    const fieldType = id.trim();

    // Find the drop index
    let dropIndex = allFields.length; // Default to appending
    if (over.id !== 'field-droppable') {
      // If dropped on an existing field, use its index
      dropIndex = allFields.findIndex(item => item.id === over.id);
      if (dropIndex === -1) dropIndex = allFields.length; // Fallback
    }

    const newField = {
      id: `${fieldType}-${Date.now()}`,
      type: fieldType === 'number' ? 'text' : fieldType, // Ensure 'number' type is set correctly
      fieldType: fieldType,
      label:
        fieldType === 'text' ? 'Text Field' :
          fieldType === 'select' ? 'Select Field' :
            fieldType === 'number' ? 'Number Field' :
              'Checkbox Field',
      placeholder: '',
      index: dropIndex,
      required: false,
      pattern:
        fieldType === 'number' ? '^[0-9]*$' :
          null,
      enable: true,
      location: location ? location.trim() : '',
      ...(fieldType === 'select' && { options: defaultLabels }),
    };

    setAllFields(prev => {
      const updatedFields = [...prev];
      updatedFields.splice(dropIndex, 0, newField); // Insert at dropIndex
      // Reassign indices
      return updatedFields.map((field, i) => ({ ...field, index: i }));
    });

    // Handle reordering existing fields
    if (active.id !== over.id) {

      const oldIndex = allFields.findIndex(item => item.id === active.id);
      const newIndex = allFields.findIndex(item => item.id === over.id);

      if (oldIndex !== -1 && newIndex !== -1) {
        setAllFields(arrayMove(allFields, oldIndex, newIndex));
        resetIndex();
      }
    }
  }


  const resetIndex = () => {
    setAllFields(prev => {
      const updatedFields = prev.map((obj, i) => ({
        ...obj,
        index: i
      }));

      // Update another state if needed
      setDefaultFields(updatedFields.filter(obj => obj.isDefault === true));

      // Return the updated array for setAllFields
      return updatedFields;
    });
  };


  const moveItem = (fromIndex, toIndex) => {
    setAllFields((prev) => {

      if (toIndex >= 0 && toIndex < prev.length) {
        return arrayMove(prev, fromIndex, toIndex);
      }
      return prev;
    });
  };





  return (

    <div>

      {isLoading.loading && <Loadding />}


      <HashRouter>

        <div className="aco-admin-container">
          {resetPopUp && (
            <ResetAlert
              setResetPopUP={setResetPopUP}
              resetFields={resetFields}
              isLoading={isLoading}
            />
          )}
          <Warning />
          <nav className="aco-nav">
            <div className="aco-header-container">

              <div className='aco-header-title'>
                <h3 className='aco-header' >Build Your Form</h3>
              </div>
              <div className="aco-header-button-container" >
                {/* <a className='aco-svg-button'>
                <img src={Settings} alt="Settings Icon" />
              </a> */}
                <button onClick={() => setResetPopUP(true)} className="aco-reset-button">Reset</button>
                <button
                  onClick={() => saveFields(allFields, defaultFields)}
                  className={`aco-save-changes-button ${isLoading.saving ? 'loading' : ''}`}
                >
                  {isLoading.saving ? 'Saving…' : 'Save Changes'}
                </button>

              </div>
            </div>
            <CheckoutBar />
            <BlockTabs />
          </nav>
          <DndContext onDragEnd={handleDragEnd}>
            <Routes>
              <Route
                path="/block/additional-info"
                element={
                  <locationContext.Provider value={'additional_info'}>
                    <AdditionalInfo
                      moveItem={moveItem}
                      allFields={allFields}
                      updateField={updateField}
                      setAllFields={setAllFields}
                      defaultFields={defaultFields}
                      setDefaultFields={setDefaultFields}
                      onSaveFields={saveFields}
                      handleFields={handleFields}
                    />
                  </locationContext.Provider>
                }
              />

              <Route
                path="/block/contact-info"
                element={
                  <locationContext.Provider value={'contact'}>
                    <ContactInfo
                      moveItem={moveItem}
                      allFields={allFields}
                      updateField={updateField}
                      setAllFields={setAllFields}
                      defaultFields={defaultFields}
                      setDefaultFields={setDefaultFields}
                      onSaveFields={saveFields}
                      handleFields={handleFields}
                    />
                  </locationContext.Provider>
                }
              />

              <Route
                path="/block/address"
                element={
                  <locationContext.Provider value={'address'}>
                    <ShippingInfo
                      moveItem={moveItem}
                      allFields={allFields}
                      updateField={updateField}
                      setAllFields={setAllFields}
                      defaultFields={defaultFields}
                      setDefaultFields={setDefaultFields}
                      onSaveFields={saveFields}
                      handleFields={handleFields}
                    />
                  </locationContext.Provider>
                }
              />

            </Routes>
          </DndContext>
        </div>
      </HashRouter>
    </div>
  );
};

export default App;