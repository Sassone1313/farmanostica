import React, { useContext } from 'react';
import { useState } from 'react';
import style from './tabFields.module.scss';
import Number from '../../icons/Number.svg';
import Text from '../../icons/text.svg';
import Select from '../../icons/select.svg';
import Radio from '../../icons/radio.svg';
import { useDraggable, DragOverlay, useDndContext } from '@dnd-kit/core';
import Checkbox from '../../icons/checkbox.svg'
import { locationContext } from '../../App';
import Image from '../../images/premium.png';


function TabFields() {
  //---useContext hook---
  const fieldLocation = useContext(locationContext)

  const [icons] = useState([
    { id: 'text', name: 'Text', icon: Text, location: fieldLocation },
    { id: 'select', name: 'Select', icon: Select, location: fieldLocation },
    { id: 'checkbox', name: 'Checkbox', icon: Checkbox, location: fieldLocation },
    //  { id: 'number', name: 'Number', icon: Number, location: fieldLocation },
    // { id: 'radio', name: 'Radio', icon: Radio, location:fieldLocation },
  ]);

  const { active } = useDndContext();



  return (
    <div>
      <div className={style.TabFields_main_container}>
        {icons.map((obj) => {
          const { attributes, listeners, setNodeRef, transform, isDragging } = useDraggable({
            id: `${obj.id} : ${obj.location}`
          });
       

          return (
            <div
              ref={setNodeRef}
      
              key={obj.id}
              className={style.tabFields_icons_container}
              {...attributes}
              {...listeners}
            >
              <div className={style.tabFields_icons_title}>
                <img src={obj.icon} alt="Fields Icon" className={style.tabFields_icon} />
                <h5 className={style.tabFields_title}>{obj.name}</h5>
              </div>
            </div>
          );
        })}



      </div>

<DragOverlay dropAnimation={null}>
  {active && (() => {
    const draggedId = active.id.split(' : ')[0];
    const draggedObj = icons.find((o) => o.id === draggedId);
    if (!draggedObj) return null;

    return (
      <div
        className={style.tabFields_icons_container}
        style={{
          animation: "dragOverlayPop 200ms ease-out",
        }}
      >
        <div className={style.tabFields_icons_title}>
          <img
            src={draggedObj.icon}
            alt="Fields Icon"
            className={style.tabFields_icon}
          />
          <h5 className={style.tabFields_title}>{draggedObj.name}</h5>
        </div>
      </div>
    );
  })()}
</DragOverlay>

      {/* <div className={style.tabFields_number_container}>
        <img src={Image} alt=" coming soon banner" className={style.tabFields_number_icon} />
        <h5 className={style.tabFields_number_title}> Coming soon</h5>
        <p className={style.tabFields_number_description}>
          Our team is building new features to improve your experience. <br />Exciting updates are coming soon <br /> <strong>stay tuned!</strong>
        </p>
      </div> */}




    </div>
  );
}

export default TabFields;