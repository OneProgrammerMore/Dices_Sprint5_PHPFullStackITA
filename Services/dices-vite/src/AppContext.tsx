// AppContext.tsx
/*
import React, { createContext, useContext, useState } from 'react';

interface AppContextType {
    variable: string;
    updateVariable: (newValue: string) => void;
}

const AppContext = createContext<AppContextType>({
    variable: 'initialValue',
    updateVariable: () => {}
});

export const useAppContext = () => useContext(AppContext);

export const AppProvider: React.FC = ({ children }) => {
    const [variable, setVariable] = useState('initialValue');

    const updateVariable = (newValue: string) => {
        setVariable(newValue);
    };

    return (
        <AppContext.Provider value={{ variable, updateVariable }}>
            {children}
        </AppContext.Provider>
    );
};
*/
