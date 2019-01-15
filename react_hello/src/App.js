import React, { Component } from 'react';
//222 import './App.css'
import NewComponent from './NewComponent';
import NewComponent2 from './NewComponent2';
import Counter from './Counter';


class App extends Component {
  render() {
    //111
    // const style = {
    //   backgroundColor: 'yellow',
    //   padding: '20px;',
    //   color: 'blue',
    //   fontSize: '20px'
    // };
    return (
      //111
      // <div style={style}>
      <div>
      <NewComponent name="Class_1"/>
      <NewComponent name="Class_2"/>
      <NewComponent />
      ==================================
      <NewComponent2 name="Functional"/>
      <NewComponent2 />
      ==================================
      <Counter/>
      </div>
      //222
      // <div className="App">
      // {
      //   (()=>{
      //     if( name === 'react') return (<div>REACT</div>);
      //     else return (<div>Example</div>);
      //   })()
      // }
      // </div>
    );
  }
}
export default App;
