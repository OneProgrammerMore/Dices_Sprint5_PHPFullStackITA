import '../styles.css'
import React from 'react';

import {HeaderDiv as HeaderDiv} from './HeaderDiv.tsx';
import NavigatorDiv from './NavigatorDiv.tsx';
import MainDiv from './MainDiv.tsx';
import FooterDiv from './FooterDiv.tsx';

import { MyContextProvider} from '../contextSrc/MyContext.tsx';


interface IProps {
	props?: any;
}
interface IState {
	jsonData?: any[];
	dataItems?: any[];
}

export default class MyHTMLDiv extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);	
	}
	
	render(){
		return (
			<div>
				<MyContextProvider>
					<HeaderDiv/>
						
					<nav id="nav">
						<NavigatorDiv/>
					</nav>
					
					<main id="root">
						<MainDiv/>
					</main>
					

					<FooterDiv/>
					
				</MyContextProvider>
			</div>
		)
	}
}

