// ***REFERENCE https://velopert.com/3642 *** //
import React, { Component } from 'react';
import PhoneForm from './component/PhoneForm';
import PhoneInfoList from './component/PhoneInfoList';
import './App.css';

class App extends Component {
  //you don't need to put data not used in render()
  id= 2
  state = {
    information: [
    {
      id: 0,
      name: 'user1',
      phone: '010-000-0000'
    },
    {
      id: 1,
      name: 'user2',
      phone: '02-123-4567'
    }
    ],
    //data filtering variable
    keyword: ''
  }
  //Add data Handler
  handleCreate = (data) => {
    //save current information array data
    const { information } = this.state;
    //using concat, add new information to array data
    this.setState({
      information: information.concat({id: this.id++, ...data})
    })
    console.log(data);
  }
  //Remove Handler
  handleRemove = (id) => {
    const { information } = this.state;
    this.setState({
      //make array again using filter function (remove)
      information: information.filter(info => info.id !== id)
    });
  }
  //Update Handler
  handleUpdate = (id, data) => {
    const { information } = this.state;
    this.setState({
      information : information.map(
        info => id === info.id
        ? {...info, ...data}
        : info
        )
    })
  }
  //Inputbox Change Handler
  handleChange = (e) => {
    this.setState({ 
      keyword: e.target.value });
  }



  render() {
    const { information, keyword } = this.state;
    const filteredList = information.filter( info => info.name.indexOf(keyword) !== -1);
    return (
      <div>
      <h2>React_PhoneBook Example</h2>
    {/*send method to children object(PhoneForm)*/}
    <PhoneForm onCreate={this.handleCreate}/><br/>
    {/*print JSON data
    {JSON.stringify(this.state)} */}
  {/*Search*/}
  <div>Search Box: 
  <input onChange={this.handleChange} placeholder="search for" value={keyword}/>
  </div>
  <PhoneInfoList data={filteredList} onRemove={this.handleRemove} onUpdate={this.handleUpdate}/>
  </div>
  );
  }
}

export default App;


//After making App.js, PhoneForm.js files like this.
//Now Create PhoneInfo, PhoneInfoList Components.

//After then, use PhoneInfoList Component inside of render.