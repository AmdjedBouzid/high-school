"use client";

import type React from "react";
import { createContext, useState, useContext, useEffect } from "react";
import { User, Theme, ThemeContextType, Supervisor } from "../utils/types";
import { getCurrentUser } from "../utils/functions";

const ThemeContext = createContext<ThemeContextType | undefined>(undefined);

export const ThemeProvider: React.FC<{ children: React.ReactNode }> = ({
  children,
}) => {
  const [user, setUser] = useState<User | null>(null);
  const [employees, setEmployees] = useState<User[]>([]);
  useEffect(() => {
    const fetchGlobalData = async () => {
      const currentUser = await getCurrentUser();
      setUser(currentUser);
    };
    fetchGlobalData();
  }, []);
  const [toDeleteOrUpdateEmployeeId, setToDeleteOrUpdateEmployeeId] =
    useState<number>(-1);
  const [supervisors, setSupervisors] = useState<Supervisor[] | []>([]);

  /**
   * Theme Management:
   *
   * - Manages the theme state ("light" or "dark").
   * - Initializes theme from localStorage on mount.
   * - Updates localStorage and applies the theme class on change.
   * - Provides a function to toggle the theme.
   */
  //.....................................................................
  const [theme, setTheme] = useState<Theme>("light");
  const [isInitialized, setIsInitialized] = useState(false);

  useEffect(() => {
    const savedTheme = localStorage.getItem("theme") as Theme | null;
    const initialTheme = savedTheme || "light"; // Default to light theme

    setTheme(initialTheme);
    setIsInitialized(true);
  }, []);

  useEffect(() => {
    if (isInitialized) {
      localStorage.setItem("theme", theme);
      if (theme === "dark") {
        document.documentElement.classList.add("dark");
      } else {
        document.documentElement.classList.remove("dark");
      }
    }
  }, [theme, isInitialized]);

  const toggleTheme = () => {
    setTheme((prevTheme) => (prevTheme === "light" ? "dark" : "light"));
  };
  //........................................................................................
  return (
    <ThemeContext.Provider
      value={{
        theme,
        toggleTheme,
        user,
        setUser,
        employees,
        setEmployees,
        toDeleteOrUpdateEmployeeId,
        setToDeleteOrUpdateEmployeeId,
        supervisors,
        setSupervisors,
      }}
    >
      {children}
    </ThemeContext.Provider>
  );
};

export const useTheme = () => {
  const context = useContext(ThemeContext);
  if (context === undefined) {
    throw new Error("useTheme must be used within a ThemeProvider");
  }
  return context;
};
