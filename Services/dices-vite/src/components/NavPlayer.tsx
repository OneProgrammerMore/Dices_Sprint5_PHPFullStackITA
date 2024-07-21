import '../styles.css'
import React from 'react';

import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx';

interface IProps {
	props?: any;
}

interface IState {
  jsonData?: any[];
  dataItems?: any[];
}

export default class NavPlayer extends React.Component<IProps, IState>{

	constructor(props: any) {
		super(props);	
	}
	
	static contextType = MyContext;
	declare context: MyContextType;
	
	changeNavSection = (newType: string) => {
		this.context.updateValueMain(newType);
	}
	
	changeNavSectionAndUser = (userID: string, mainType: string) => {
		this.context.updateValueMainAndUserID(userID, mainType);
	}

	render(){
		return (
			<div id="UserNav" className="navSection">
				
				<div className="navName">
					User
				</div>
				
				<div className="navItems">
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('Play')}>
							Play
						</a>
					</div>
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('Delete')}>
							Delete
						</a>
					</div>
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('ModifyName')} >
							Modify Name
						</a>
					</div>
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSectionAndUser(Functions.getCookie('userid'),'Player')} >
							Show Player
						</a>
					</div>
				</div>
				
			</div>
			
		)
	}
}
