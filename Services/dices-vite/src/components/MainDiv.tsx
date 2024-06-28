import '../styles.css'
import React from 'react';

import Play from './Play.tsx';
import Delete from './Delete_games.tsx';
import ModifyName from './Modify_name.tsx';
import ListUsers from './List_user.tsx';
import Ranking from './Ranking.tsx';
import Winner from './Winner.tsx';
import Loser from './Loser.tsx';
import Player from './Player.tsx';
import Home from './Home.tsx';


import Login from './Login.tsx';
import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx'

interface IProps {
	props?: any;
}
interface IState {
	jsonData?: any[];
	dataItems?: any[];
}

export default class MainDiv extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);	
	}

	static contextType = MyContext;
	declare context: MyContextType;
	

	render(){
		
		return (
			<MyContext.Consumer>
				{context => {

					if(!context){
						return null;
					}else{
						switch(context.mainSwitch){
							//For ALL
							case 'Login':
								return <Login/>;
							//ToDo - Version 1 - Change Login To Home Component
							case 'Home':
								return <Home/>;
								
							//For Player
							case 'Play':
								return <Play/>; 
							case 'Delete':
								return <Delete/>;
							case 'ModifyName':
								return <ModifyName/>;
							case 'Player':
								return <Player/>;
								
							//For Admin
							case 'ListPlayers':
								return  <ListUsers/>;
							case 'Ranking':
								return 	<Ranking/>;
							case 'Winner':
								return <Winner/>;
							case 'Loser':
								return <Loser/>;
							default:
								return <Login />;
						}
					}
				 
				}}
			</MyContext.Consumer>
		);
	}
}
