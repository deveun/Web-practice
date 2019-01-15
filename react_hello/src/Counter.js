import React, { Component } from 'react';

class Counter extends Component {
	// Dynamic Data
	state = {
		number: 0
	}

	//Method (Function)
	increaseFunction = () => {
		this.setState({
			number: this.state.number + 1
		});
	}

	decreaseFunction = () => {
		this.setState(
			(state) => ({
				number: state.number - 1
			})
		);
	}

	clearFunction = () => {
		this.setState({
			number: 0
		});
	}

	render() {
		return (
			<div>
			<h1>Counter Example</h1>
			<p>Using "State"</p>
			<div> Counter Result: {this.state.number}</div>
			<button onClick={this.increaseFunction}>+</button>
			<button onClick={this.decreaseFunction}>-</button>
			<button onClick={this.clearFunction}>x</button>
			</div>
			);
	}
}

export default Counter;