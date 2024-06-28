import '../styles.css'
import React from 'react';

import {MyContext, MyContextType} from '../contextSrc/MyContext.tsx';

interface IProps {
	props?: any;
}
interface IState {
  jsonData?: any[];
  dataItems?: any[];
}

//import {ShowListPlayers, ShowRanking, ShowLoser, ShowWinner} from '../main.tsx';

export default class NavEmpty extends React.Component<IProps, IState>{
  
	constructor(props: any) {
		super(props);	
	}
	
	static contextType = MyContext;
	declare context: MyContextType;
	
	changeNavSection = (newType: string) => {
		this.context.updateValueMain(newType);
	}
	
	render(){
		return (
			<div id="AdminNav"  className="navSection">
				<div className="navName">
					Admin
				</div>
				
				<div className="navItems">
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('ListPlayers')} >
							List Players
						</a>
					</div>
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('Ranking')} >
							Ranking
						</a>
					</div>
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('Loser')} >
							Worst
						</a>
					</div>
					<div className="navItem">
						<a href="#" onClick={() => this.changeNavSection('Winner')} >
							Best
						</a>
					</div>
				</div>
			</div>
		)
	}
}
