import { useSortable } from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import DragIcon from './../../icons/drag-icon.svg'; // Replace with your actual icon
import React from 'react';

const SeleteFieldSortableItems = ({ id, children }) => {
  const {
    attributes,
    listeners,
    setNodeRef,
    setActivatorNodeRef,
    transform,
    transition,
    isDragging,
  } = useSortable({ id });

  const style = {
    transform: CSS.Transform.toString(transform),
    transition,
    opacity: isDragging ? 0.5 : 1,
  };

  return (
    <div ref={setNodeRef} style={style} {...attributes}>
      <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
        <div style={{ flex: 1 }}>{children}</div>
        <div
          ref={setActivatorNodeRef}
          {...listeners}
          style={{
            cursor: 'grab',
            padding: '8px',
            display: 'flex',
            alignItems: 'center',
          }}
        >
          <img src={DragIcon} alt="Drag" width="16" height="16" />
        </div>
      </div>
    </div>
  );
};

export default SeleteFieldSortableItems;

