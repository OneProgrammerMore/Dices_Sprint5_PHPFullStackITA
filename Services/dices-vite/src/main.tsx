import React from 'react'
import {createRoot} from 'react-dom/client'

import './dices.tsx'
import MyHTMLDiv from './components/MyHtml.tsx';



let container: any = null;

//document.addEventListener('DOMContentLoaded', function(event) {
document.addEventListener('DOMContentLoaded', function() {
  if (!container) {
    container = document.getElementById('MYHTML') as HTMLElement;
    const root = createRoot(container)
    
    
    root.render(
      <React.StrictMode>
		<MyHTMLDiv/>
      </React.StrictMode>
    );
  }
});
