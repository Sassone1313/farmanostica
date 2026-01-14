import React from 'react';
import { useSortable } from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';

function SortableItem({ id, children, index }) {
  const {
    attributes,
    listeners,
    setNodeRef,
    transform,
    transition,
    isDragging,
  } = useSortable({ id });

  // Customize transform with additional effects
  const customTransform = transform
    ? {
        ...transform,
        // scaleX: isDragging ? 1.1 : transform.scaleX, // Scale up by 10% when dragging
        // scaleY: isDragging ? 1.1 : transform.scaleY,
        // Add rotation (optional, comment out if not needed)
        // rotate: isDragging ? '5deg' : '0deg',
      }
    : null;

  const style = {
    transform: CSS.Transform.toString(transform),
    transition,
  };
  

  // Filter drag listeners to prevent dragging on elements with data-no-drag="true"
  const filteredListeners = {
    ...listeners,
    onPointerDown: (e) => {
      if (e.target.closest('[data-no-drag="true"]')) {
        return; // Prevent dragging
      }
      if (listeners?.onPointerDown) {
        listeners.onPointerDown(e);
      }
    },
  };

  return (
    <div
      ref={setNodeRef}
      style={style}
      {...attributes}
      {...filteredListeners}
      className="sortable-item"
    >
      {children}
    </div>
  );
}

export default SortableItem;