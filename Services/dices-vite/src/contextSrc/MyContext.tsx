import React, { useState, ReactNode} from 'react'
//import React, { useState, ReactNode } from 'react';


interface MyContextType {
  userTypeSwitch: string;
  updateValue: (newValue: string) => void;
  mainSwitch: string;
  updateValueMain: (newValue: string) => void;
  playerID: number;
  updateValueMainAndUserID: (newValueUser: number, newValueMain: string) => void;
  updateValueUserTypeAndMain: (newValueUserType: string, newValueMain: string) => void;
}
const MyContext = React.createContext<MyContextType | undefined>(undefined);


interface MyContextProviderProps {
  children: ReactNode;
}
// Create a context provider
const MyContextProvider: React.FC<MyContextProviderProps> = ({ children }) => {
  const [userTypeSwitch, setValueUserType] = useState('None');
  const [mainSwitch, setValueMain] = useState('Login');
  const [playerID, setValueUserID] = useState(0);
  
  const updateValue = (newValue: string) => {
    setValueUserType(newValue);
  };
  
  const updateValueMain = (newValue: string) => {
    setValueMain(newValue);
  };
  
  const updateValueMainAndUserID = (newValueUser: number, newValueMain: string) => {
    setValueUserID(newValueUser);
    setValueMain(newValueMain);
  };
  
  const updateValueUserTypeAndMain = (newValueUserType: string, newValueMain: string) => {
	setValueUserType(newValueUserType);
	setValueMain(newValueMain);
  };
	
  return (
    <MyContext.Provider value={{ userTypeSwitch, updateValue,mainSwitch, updateValueMain, playerID, updateValueMainAndUserID, updateValueUserTypeAndMain }}>
      {children}
    </MyContext.Provider>
  );
};

/*
export default MyContext;
export default MyContextProvider;*/
export {
	MyContext,
	MyContextProvider,
}
export type{
	MyContextType,
}
