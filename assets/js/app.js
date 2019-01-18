import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, NavLink, Switch } from 'react-router-dom';

import AnotherPage from "./pages/AnotherPage";
import Dashboard from "./pages/Dashboard";

class App extends React.Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    <ul>
                        <NavLink to="/react">Dashboard</NavLink>
                        <NavLink to="/react/another-page">Another Page</NavLink>
                    </ul>
                    <Switch>
                        <Route path="/react/another-page" component={AnotherPage}/>
                        <Route path="/react" component={Dashboard}/>
                    </Switch>
                </div>
            </BrowserRouter>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('root'));