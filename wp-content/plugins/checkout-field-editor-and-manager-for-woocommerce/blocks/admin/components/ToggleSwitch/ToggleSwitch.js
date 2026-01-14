import React from 'react';
import style from './toggleSwitch.module.scss';

function ToggleSwitch({ id, action, handleFields, name, isDefault }) {
  const onChange = (e) => {
    // Fake a normal event object for handleFields
    handleFields(
      {
        target: {
          name,
          type: "checkbox",
          checked: e.target.checked,
        },
      },
      id
    );
  };

  return (
    <div className={`${style.toggleSwitch_container} ${isDefault ? style.disabled : ''}`}>
      <label className={style.toggleSwitch}>
        <input
          type="checkbox"
          name={name}
          onChange={onChange}
          checked={!!action}
          disabled={isDefault}
        />
        <span className={style.slider}></span>
      </label>
    </div>
  );
}

export default ToggleSwitch;
