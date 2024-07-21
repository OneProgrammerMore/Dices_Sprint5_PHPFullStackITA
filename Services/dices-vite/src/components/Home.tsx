import '../styles.css'
import React from 'react';

import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx'

interface IProps {
	props?: any;
}

interface IState {

}


export default class Home extends React.Component<IProps, IState>{
	
	constructor(props: any) {
		super(props);

	}
		
	static contextType = MyContext;
	declare context: MyContextType;
	
	changeNavSectionAndUser = (userID: string, mainType: string) => {
		this.context.updateValueMainAndUserID(userID, mainType);
	}
	
	
	render(){
		var messageL1 = '';
		var messageL2 = '';
		switch(this.context.userTypeSwitch){
			case 'Player':
				messageL1 = 'You are logged as player!';
				messageL2 = 'Time to roll the dices!';
				break;
			case 'Admin':
				messageL1 = 'You are logged as admin!';
				messageL2 = 'Quite boring but at least can you see...';
				break;
			default:
				break;
		}
		
		return (
			<div className="home" >
				Welcome to dices {Functions.getCookie('userName')} !!!
				<br/>
				{messageL1}<br/>{messageL2}
			</div>
		)
	}
	
}
