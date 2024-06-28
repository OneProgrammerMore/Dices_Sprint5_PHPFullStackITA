
import '../styles.css'
import React from 'react';

interface IProps {
	props?: any;
}

interface IState {
	jsonData?: any[];
	dataItems?: any[];
}
export default class NavEmpty extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);	
	}

	render(){
		return (
			<div id="UserNav" className="navSection">
				If the ruler does not know your name ... <br/>
				With dices shall not you play!
			</div>
		)
	}
}

