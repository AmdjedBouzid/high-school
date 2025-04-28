"use client";

import type React from "react";
import { createContext, useState, useContext, useEffect, use } from "react";
import {
  User,
  Theme,
  ThemeContextType,
  Supervisor,
  Major,
  Grad,
  Section,
} from "../utils/types";
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
    const gradsData: Grad[] = [
      {
        id: -1,
        name: "All",
        created_at: "2025-04-23 21:42:23",
        updated_at: "2025-04-23 21:42:23",
      },
      {
        id: 1,
        name: "First Year",
        created_at: "2025-04-23 21:42:23",
        updated_at: "2025-04-23 21:42:23",
      },
      {
        id: 2,
        name: "Second Year",
        created_at: "2025-04-23 21:43:00",
        updated_at: "2025-04-23 21:43:00",
      },
      {
        id: 3,
        name: "Third Year",
        created_at: "2025-04-23 21:43:00",
        updated_at: "2025-04-23 21:43:00",
      },
    ];
    setGrads(gradsData);
    fetchGlobalData();
  }, []);
  const [toDeleteOrUpdateEmployeeId, setToDeleteOrUpdateEmployeeId] =
    useState<number>(-1);
  const [supervisors, setSupervisors] = useState<Supervisor[] | []>([]);
  const [toDeleteOrUpdateSupervisorId, setToDeleteOrUpdateSupervisorId] =
    useState<number>(-1);
  const [majors, setMajors] = useState<Major[] | []>([]);
  const [toDeleteOrUpdateMajorId, setToDeleteOrUpdateMajorId] =
    useState<number>(-1);
  const [grads, setGrads] = useState<Grad[] | []>([]);
  const [gradId, setGradId] = useState<number>(-1);
  const [majorId, setMajorId] = useState<number>(-1);
  const [sections, setSections] = useState<Section[] | []>([]);

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
        toDeleteOrUpdateSupervisorId,
        setToDeleteOrUpdateSupervisorId,
        majors,
        setMajors,
        toDeleteOrUpdateMajorId,
        setToDeleteOrUpdateMajorId,
        grads,
        setGrads,
        gradId,
        setGradId,
        majorId,
        setMajorId,
        sections,
        setSections,
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
