import '../styles.css'
import React from 'react';
import Logout from './Logout.tsx';

import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx';


interface IState {
	jsonData?: any[];
	dataItems?: any[];
}

export class HeaderDiv extends React.Component<{}, IState>{
	
	static contextType = MyContext;
	//Difne Context Type:
	declare context: MyContextType;
	
	
	constructor(props: {}) {
		super(props);	
	}
	
	
	
	changeNavSection = (newType: string) => {
		// Accessing updateValue function from context
		if(Functions.getCookie('userid') != ''){
			this.context.updateValueMain(newType);
		}else{
			alert('It is necessary to be logged in in order to go to home page');
		}
	}
	


	render(){
		return (
			<header>
				<div id='HeaderLeft'>
					<div id="WebLogo">
					</div>
					<div id="WebName" onClick={ () => this.changeNavSection('Home') } >
						Dices
					</div>
				</div>
				<div id='HeaderRight'>
					<Logout />
				</div>
			</header>
		)
	}
}
