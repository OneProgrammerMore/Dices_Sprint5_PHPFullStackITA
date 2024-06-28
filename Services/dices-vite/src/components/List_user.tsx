import '../styles.css'
import React from 'react';

import * as Constants from '../constants.tsx';
import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx'

interface IProps {
		props?: any;
}

interface IState {
  jsonData?: any[];
  dataItems?: any[];
}

export default class ListUsers extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);

		this.state = {
			jsonData: [],
			dataItems: []
		};

	}
	
	
	static contextType = MyContext;
	declare context: MyContextType;
	
	changeNavSectionAndUser = (userID: number, mainType: string) => {
		// Accessing updateValue function from context
		this.context.updateValueMainAndUserID(userID, mainType);
		//this.context.updateValueMain(mainType);
	}
	
	async listPlayersApiCall(){
		//Procedure
		//0. Prevent default submit
		//1. Take all parameters from the form
		//2. Validate the parameters from the form
		//3. Send the parameters to the API
		//4. Fetch response and act according it
			//Status 201 -> Store Token and reroute to Play
			//Status 401 -> Show error message
			
		console.log("Status One");
		var token = Functions.getCookie('token');
		var listPlayersURI:string = '/api/players';
		var listPlayersEndPoint:string = Constants.dices_URL + listPlayersURI;
		
		const response = await fetch( listPlayersEndPoint, {
			method: 'GET',
			//mode: "no-cors", //Change the mode to cors
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
			
		});
		
		const result = await response.json();
		console.log(result);
		
		if(response.ok){
			console.log("Response OK");
		}
		return result;
	}




	async componentDidMount(){
	
		const jsonDataPlayers = await this.listPlayersApiCall();
		
		/*
		this.setState({
			jsonData: jsonDataPlayers
		});
		*/
		
		var arr: any [] = [];
		//ToDo - Version 1 - Maybe that not needed:
		Object.keys(jsonDataPlayers).forEach(key => arr.push({
			id: key, 
			name: jsonDataPlayers[key]['user_name'],
			tries: jsonDataPlayers[key]['user_tries'],
			wins: jsonDataPlayers[key]['user_wins'],
			wins_perc: jsonDataPlayers[key]['wins_perc']
			}));
		

		this.setState({
			dataItems: [
				arr.map(
				(player)=>{
					return(
						<tr key={player.id}>
							<td>
								{player.id}
							</td>
							<td>
								{player.name}
							</td>
							<td>
								{player.tries}
							</td>
							<td>
								{player.wins}
							</td>
							<td>
								{player.wins_perc}
							</td>
							<td>
								<div onClick={ () => this.changeNavSectionAndUser(player.id, 'Player') } > 
									<i className="moreInfoIcon"></i>
								</div>
							</td>
						</tr>
						)
					}
				
				)
				
			]
		});

	}
  
	render(){
		return (
			<div className="main_container">
				<h3>
					List Players
				</h3>
				<table id="user_table">
					<thead>
						<tr>
							<th>
								User ID
							</th>
							<th>
								User Name
							</th>
							<th>
								Tries
							</th>
							<th>
								Wins
							</th>
							<th>
								Wins Percentage
							</th>
							<th>
								More Info
							</th>
						</tr>
					</thead>
					
					<tbody>
						{this.state.dataItems}
					</tbody>
					</table>
				
			</div>
		)
	}
	
	
}

//export default Login
