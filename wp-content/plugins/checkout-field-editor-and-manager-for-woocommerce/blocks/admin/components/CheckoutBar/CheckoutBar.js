import React, { useState } from "react";
import style from "./checkoutBar.module.scss";


const CheckoutBar = () => {
  const [localSection, setLocalSection] = useState("block");

  const handleClick = (section) => {
    setLocalSection(section);
  };

  return (
    <nav className={style.navbar}>
      <a
        href={`${window.location.origin}${window.location.pathname}?page=awcfe_admin_ui#/section/billing`}
        onClick={() => handleClick("billing")}
        className={localSection === "billing" ? style.active : style.navlink}
      >
        Classic Checkout
      </a>
      <a
        href={`${window.location.origin}${window.location.pathname}?page=aco-wc-checkout-block#/block/contact-info`}
        onClick={() => handleClick("block")}
        className={localSection === "block" ? style.active : style.navlink}
      >
        Block Checkout
      </a>
    </nav>
  );
};

export default CheckoutBar;