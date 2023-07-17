import './bootstrap';
import '../css/app.css'

import ReactDOM from 'react-dom/client'; 
import DisplayTags from './components/DisplayTags';

export default function ReactApp() {
  return (
    <DisplayTags />
  );
};

ReactDOM.createRoot(document.getElementById('app')).render(<ReactApp />);