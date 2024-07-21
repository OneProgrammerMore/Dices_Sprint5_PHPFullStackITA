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

export default class Loser extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);

		this.state = {
			jsonData: [],
			dataItems: []
		};

	}
	static contextType = MyContext;
	declare context: MyContextType;
	
	changeNavSectionAndUser = (userID: string, mainType: string) => {
		this.context.updateValueMainAndUserID(userID, mainType);
	}
	
	async loserApiCall(){
			
		var token = Functions.getCookie('token');

		var loserURI:string = '/api/players/ranking/loser';
		var loserEndPoint:string = Constants.dices_URL + loserURI;
		
		const response = await fetch( loserEndPoint, {
			method: 'GET',
			//mode: "no-cors", //Change the mode to cors
			headers: {
				'Content-Type': 'application/json',
				'Authorization': 'Bearer ' + token,
			}
		});
		
		return response;
	}
	
	
	
	
	async componentDidMount(){
		
		const response = await this.loserApiCall();
		
		if(response.ok){
			const jsonDataPlayers = await response.json();

			this.setState({
				jsonData: jsonDataPlayers
			});
			
			var arr: any [] = [];
			Object.keys(jsonDataPlayers).forEach(key => arr.push({
				id: jsonDataPlayers[key]['user_id'], 
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
									<div onClick={() => this.changeNavSectionAndUser(player.id, 'Player')  } > 
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

		
		
		//this.forceUpdate();
		//return playersListData;
		
		console.log("Finish");
		
		
	}
  
  render(){
	  return (
	  <div className="main_container">
		<h3>
			Loser...
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

