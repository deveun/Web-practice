//			*** REFERENCE ***			//
//	https://brunch.co.kr/@hee072794/72	//

import React, { Component } from 'react';
import Board from './Board';
import './index.css';

class Game extends Component {
	state = {
		history:[
		{arr:[
			{id:0, value:''},{id:1, value:''},{id:2, value:''},
			{id:3, value:''},{id:4, value:''},{id:5, value:''},
			{id:6, value:''},{id:7, value:''},{id:8, value:''}
			],
			clicked: ''
		}],
		arr: [
		{id:0, value:''},{id:1, value:''},{id:2, value:''},
		{id:3, value:''},{id:4, value:''},{id:5, value:''},
		{id:6, value:''},{id:7, value:''},{id:8, value:''}
		],
		mark: 'X'
	}

	handleClick = (h) => {
		this.setState({arr: h.arr})
	}

	handleMark = (id) => {
		const { history, arr , mark} = this.state;
		const marked = {id: id, value: mark}
		this.setState({
			arr: arr.map(
				item => item.id === id
				?	{ ...item, ...marked}
				: item)
		});
		this.setState({
			history: history.concat({arr: arr, clicked: id})
		});
		if(mark === 'X')
			this.setState({mark: 'O'});
		else if(mark === 'O')
			this.setState({mark: 'X'});
	}

	render() {
		const {history, arr, mark} = this.state;
		const list = history.map(
			h => h.clicked || h.clicked === 0
			? (<li><button onClick={()=>this.handleClick(h)}>Index {h.clicked+1} Clicked.</button></li>)
			: (<li><button onClick={()=>this.handleClick(h)}>Game Started</button></li>)
			);
		return (
			<div className="game">
			<div className="game-board">
			<Board onMark={this.handleMark} arr={arr} mark={mark}/>
			</div>
			<div className="game-info">
			<ol>{list}</ol>
			</div>
			</div>
			);
	}
}

export default Game;