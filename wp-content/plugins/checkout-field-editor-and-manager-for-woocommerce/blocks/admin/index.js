import { createRoot } from 'react-dom/client';
import './index.scss';
import App from './App';

const container = document.getElementById('aco-wc-checkout-admin-root');

if (container) {
  // Prevent double-initialization
  if (!container._reactRoot) {
    container._reactRoot = createRoot(container);
  }
  container._reactRoot.render(<App />);
}
