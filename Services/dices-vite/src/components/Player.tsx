import '../styles.css'
import React from 'react';

import * as Constants from '../constants.tsx';
import * as Functions from '../dices.tsx';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx';

interface IProps {
	props?: any;
	player_id?: number;
}

interface IState {
	jsonData?: any;
	dataItems?: any;
	player_id?: number | string;
}

export default class Player extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);

		this.state = {
			jsonData: [],
			dataItems: [],
			player_id: this.props.player_id,
		};

		this.componentDidMount = this.componentDidMount.bind(this);
		this.playerApiCall = this.playerApiCall.bind(this);
	}
	
	static contextType = MyContext;
	declare context: MyContextType;
	
	async playerApiCall(){
	  
		//ToDO - Version 1 - Cookieess!!! Bake some good cookies!!!
		var token = Functions.getCookie('token');
		
		var playerIDContext = this.context.playerID;
		var playerURI:string = '/api/players/'+playerIDContext+'/games';
		var playerEndPoint:string = Constants.dices_URL + playerURI;
		
		const response = await fetch( playerEndPoint, {
			method: 'GET',
			//mode: "no-cors", //Change the mode to cors
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
			
		});
		
		return response;
		
		
		//Redirect to play or ListUsers depending on user type
		
	}
  

	async componentDidMount(){
	

		const response = await this.playerApiCall();

		if(response.ok){
			
			const jsonDataPlayers = await response.json();
			
			this.setState({
				jsonData: jsonDataPlayers
			});
			
			var arr: any [] = [];
		
			Object.keys(jsonDataPlayers).forEach(key => arr.push({
				player_id: jsonDataPlayers[key]['player_id'], 
				id: jsonDataPlayers[key]['throw_id'], 
				date: jsonDataPlayers[key]['created_at'],
				dice_1: jsonDataPlayers[key]['dice_1'],
				dice_2: jsonDataPlayers[key]['dice_2'],
				dices_sum: jsonDataPlayers[key]['dices_sum']
				}));

			this.setState({
				dataItems: [
					arr.map(
					(game)=>{
							return(
								<tr key={game.id}>
									<td>
										{game.player_id}
									</td>
									<td>
										{game.id}
									</td>
									<td>
										{game.date}
									</td>
									<td>
										{game.dice_1}
									</td>
									<td>
										{game.dice_2}
									</td>
									<td>
										{game.dices_sum}
									</td>
								</tr>
								)
							}
					
					)
					
				]
			});

		}

	}
  
	render(){
		return (
			<div className="main_container">
				<h3>
					Player
				</h3>
				
				<table id="user_table">
					<thead>
						<tr>
							<th>
								Player ID
							</th>
							<th>
								Game ID
							</th>
							<th>
								Creaated At:
							</th>
							<th>
								Dice 1:
							</th>
							<th>
								Dice 2:
							</th>
							<th>
								Dices Sum - Result
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

