import '../styles.css'
import React from 'react';

import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx'

interface IProps {
	props?: any;
}

interface IState {
  jsonData?: any[];
  dataItems?: any[];
}

export default class Loser extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);

		this.state = {
			jsonData: [],
			dataItems: []
		};
		this.logOutFunction = this.logOutFunction.bind(this);

	}
		
	static contextType = MyContext;
	declare context: MyContextType;
	
	changeNavSectionAndUser = (userID: string, mainType: string) => {
		this.context.updateValueMainAndUserID(userID, mainType);
	}
	
	
	logOutFunction(){
		console.log('logOutFunctionStart');
		Functions.setCookie('token','',1);
		Functions.setCookie('userid','',1);
		this.context.updateValueUserTypeAndMain('None', 'Login');
		console.log('logOutFunctionEnded');
	}
  
	render(){
		return (
			<div className="LogOutDiv" onClick={this.logOutFunction}>
			Log Out
			</div>
		)
	}
}

