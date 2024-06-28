import '../styles.css'
import React from 'react';

import NavEmpty from './NavEmpty.tsx';
import NavPlayer from './NavPlayer.tsx';
import NavAdmin from './NavAdmin.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx';

interface IProps {
	props?: any;
}

interface IState {
	jsonData?: any[];
	dataItems?: any[];
}

export default class NavigatorDiv extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);	
	}
	
	static contextType = MyContext;
	declare context: MyContextType;
	
	render(){
	  
		return (
			<MyContext.Consumer>
				{context  =>
					{
						if(!context){
							return null;
						}
						switch(context.userTypeSwitch){
							case 'None':
								return <NavEmpty />;
							case 'Player':
								return <NavPlayer/>;
							case 'Admin':
								return 	<NavAdmin />;
							default:
								return <NavEmpty />;
						
						}
					}
				}
			</MyContext.Consumer>
		);
	}
}
