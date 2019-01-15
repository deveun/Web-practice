import React, { Component } from 'react';
import './index.css'

class Square extends Component {
	state = {
		mark: ''
	}
	//CLick Handler
	handleClick= () => {
		console.log("CALLED");
		const {mark} = this.state;
		this.setState({mark: 'X'});
	}

	render() {
		const {mark} = this.state;
		return (
			<button className="square" onClick={this.handleClick}>
			{mark}
			</button>
			);
	}
}

export default Square;