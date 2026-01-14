import React from 'react';
import styles from './blockTabs.module.scss';
import { NavLink } from 'react-router-dom';

function BlockTabs() {
  const getNavLinkClass = ({ isActive }) =>
    isActive ? styles.active : styles.navlink;

  return (
    <nav className={styles.navbar}>
      <NavLink to="/block/contact-info" className={getNavLinkClass}>
        Contact Information
      </NavLink>
      <NavLink to="/block/address" className={getNavLinkClass}>
        Address
      </NavLink>
      <NavLink to="/block/additional-info" className={getNavLinkClass}>
        Additional Information
      </NavLink>
    </nav>
  );
}

export default BlockTabs;