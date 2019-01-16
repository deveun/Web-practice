import React, { Component } from 'react';
import Square from './Square'
import './index.css'

class Board extends Component {

	render() {
		console.log("RENDERING");
		const { arr, mark, onMark } =this.props;
		let status;
		const winner = calculateWinner(arr);
		if(winner)
			status = 'Winner is: ' + winner;
		else
			status = 'Next player: '+ mark;

		const items1= arr.filter(item => item.id < 3);
		const items2= arr.filter(item => 2 < item.id && item.id < 6);
		const items3= arr.filter(item => 5 < item.id && item.id < 9);

		const row1= items1.map( item => (<Square key={item.id} item={item} onMark={onMark}/>));
		const row2= items2.map( item => (<Square key={item.id} item={item} onMark={onMark}/>));
		const row3= items3.map( item => (<Square key={item.id} item={item} onMark={onMark}/>));

		return (
			<div>
			<div className="status">{status}</div>
			<div className="board-row">
			{row1}
			</div>
			<div className="board-row">
			{row2}
			</div>
			<div className="board-row">
			{row3}
			</div>
			</div>
			);
	}
}

//lines array has every case of winning places. 
function calculateWinner(squares) {
	const lines = [
	[0, 1, 2],
	[3, 4, 5],
	[6, 7, 8],
	[0, 3, 6],
	[1, 4, 7],
	[2, 5, 8],
	[0, 4, 8],
	[2, 4, 6]
	];
	for (let i = 0; i < lines.length; i++) {
		const [a, b, c] = lines[i];
		if (squares[a].value && squares[a].value === squares[b].value && squares[a].value === squares[c].value) {
			return squares[a].value;
		}
	}
	return null;
}


export default Board;