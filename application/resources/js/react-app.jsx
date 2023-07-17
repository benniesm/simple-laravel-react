import './bootstrap';
import '../css/app.css'

import ReactDOM from 'react-dom/client'; 

export default function ReactApp() {
  return (
    <div>Hello</div>
  );
};

ReactDOM.createRoot(document.getElementById('app')).render(<ReactApp />);